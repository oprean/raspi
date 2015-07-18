<?php
require_once '../php/components/commands.php';

define('WPI_PIN_NUMBERING', 0);
define('BCM_PIN_NUMBERING', 1);
define('PHYS_PIN_NUMBERING', 2);
define('DEFAULT_PIN_NUMBERING', PHYS_PIN_NUMBERING);

define('IN', 'in');
define('OUT', 'out');

/*| wiringPi | GPIO | Phys | Name   | Mode | Value |
+----------+------+------+--------+------+-------+
|      0   |  17  |  11  | GPIO 0 | IN   | High  |
|      1   |  18  |  12  | GPIO 1 | IN   | Low   |
|      2   |  27  |  13  | GPIO 2 | IN   | Low   |
|      3   |  22  |  15  | GPIO 3 | IN   | Low   |
|      4   |  23  |  16  | GPIO 4 | IN   | Low   |
|      5   |  24  |  18  | GPIO 5 | IN   | Low   |
|      6   |  25  |  22  | GPIO 6 | IN   | Low   |
|      7   |   4  |   7  | GPIO 7 | IN   | Low   |
|      8   |   2  |   3  | SDA    | IN   | High  |
|      9   |   3  |   5  | SCL    | IN   | High  |
|     10   |   8  |  24  | CE0    | IN   | Low   |
|     11   |   7  |  26  | CE1    | IN   | Low   |
|     12   |  10  |  19  | MOSI   | IN   | Low   |
|     13   |   9  |  21  | MISO   | IN   | Low   |
|     14   |  11  |  23  | SCLK   | IN   | High  |
|     15   |  14  |   8  | TxD    | IN   | Low   |
|     16   |  15  |  10  | RxD    | IN   | Low   |
|------------------------------------------------|
|     17   |  28  |   3  | GPIO 8 | IN   | Low   |
|     18   |  29  |   4  | GPIO 9 | IN   | Low   |
|     19   |  30  |   5  | GPIO10 | IN   | Low   |
|     20   |  31  |   6  | GPIO11 | IN   | Low   |
+----------+------+------+--------+------+-------+*/

class GPIO {
	
	private $gpio_table = array(
		array( 0, 17, 11, 'GPIO 0'),
		array( 1, 18, 12, 'GPIO 1'),
		array( 2, 27, 13, 'GPIO 2'),
		array( 3, 22, 15, 'GPIO 3'),
		array( 4, 23, 16, 'GPIO 4'),
		array( 5, 24, 18, 'GPIO 5'),
		array( 6, 25, 22, 'GPIO 6'),
		array( 7,  4,  7, 'GPIO 7'),
		array( 8,  2,  3, 'SDA'),
		array( 9,  3,  5, 'SCL'),
		array(10,  8, 24, 'CE0'),
		array(11,  7, 26, 'CE1'),
		array(12, 10, 19, 'MOSI'),
		array(13,  9, 21, 'MISO'),
		array(14, 11, 23, 'SCLK'),
		array(15, 14,  8, 'TxD'),
		array(16, 15, 10, 'RxD'),
		
		array(17, 28,  3, 'GPIO 8'),
		array(18, 29,  4, 'GPIO 9'),
		array(19, 30,  5, 'GPIO 10'),
		array(20, 31,  6, 'GPIO 11'),
	);
	
	private function get($pin, $numbering) {
		if ($numbering == WPI_PIN_NUMBERING) return $this->gpio_table[$pin];
		foreach ($this->gpio_table as $id => $gpio) {
			if ($gpio[$numbering] == $pin) 
				return array(
					'id' => $gpio[0],
					'wiringPi' => $gpio[0],
					'GPIO' => $gpio[1],
					'Phys' => $gpio[2],
					'Name' => $gpio[3],
					'Mode' => null,
					'Value' => null,
				);
		}
		return false;
	}
	
	public static function convert($pin, $from, $to) {
	}
	
	public function readall() {
		$oCmd = new Command();
		$rawResponse = $oCmd->response('gpioreadall');
		
		if ($rawResponse['status'] == 'error' || 
			$rawResponse['response'][0][0] != '+') {
			return $this->formatErrorResponse($rawResponse['response']);			
		} else {
			$rawResponse = $rawResponse['response'];
		}
		
		$gpio_readall_pattern = '/\|\s(?<wiringPi>\d+)\s\|\s(?<GPIO>\d+)\s\|\s(?<Phys>\d+)\s\|\s(?<Name>.+)\s\|\s(?<Mode>.+)\s\|\s(?<Value>.+)\s\|/';
		for($i=2;$i<=23;$i++) {
			$rawData = preg_replace('/\s+/', ' ',$rawResponse[$i]);
			$r = preg_match_all($gpio_readall_pattern, $rawData, $matches);
			if ($r && array_key_exists('Value', $matches)) {
				$response[] = array(
					'id' => $matches['wiringPi'][0],
					'wiringPi' => $matches['wiringPi'][0],
					'GPIO' => $matches['GPIO'][0],
					'Phys' => $matches['Phys'][0],
					'Name' => $matches['Name'][0],
					'Mode' => $matches['Mode'][0],
					'Value' => $matches['Value'][0] =='High'?1:0,
				);
			}	
		}
		
		return $response;
	}

	public function resetall() {
		$cmd = sprintf("gpio reset");
		exec($cmd, $output, $return);
		if ($output || $return) return $this->formatErrorResponse('Failed to reset!');
		return $this->readall();
	}

	public function mode($pin, $mode, $numbering = DEFAULT_PIN_NUMBERING) {
		$pin = $this->get($pin, $numbering);
		if(!$pin) return $this->formatErrorResponse('This pin does not exist!');
		$cmd = sprintf("gpio mode %u %s", $pin['GPIO'], $mode);
		exec($cmd, $output, $return);		
		if ($return) return $this->formatErrorResponse($cmd, $output);
				
		return $this->formatSuccessResponse($pin, null, $mode);
	}

	public function read($pin, $numbering = DEFAULT_PIN_NUMBERING) {
		$pin = $this->get($pin, $numbering);
		if(!$pin) return $this->formatErrorResponse('This pin does not exist!');
		$cmd = sprintf("gpio mode %u in && gpio read %u",$pin['GPIO'], $pin['GPIO']);
		exec($cmd, $output, $return);		
		if (!$output || $return) return $this->formatErrorResponse($cmd, $output);
		$value = $output[0];
		
		return $this->formatSuccessResponse($pin, $value, IN);
	}
	
	public function write($pin, $value, $numbering = DEFAULT_PIN_NUMBERING) {
		$pin = $this->get($pin, $numbering);
		if(!$pin) return $this->formatErrorResponse('This pin does not exist!');
		$cmd = sprintf("gpio mode %u out && gpio write %u %u && gpio read %u",$pin['GPIO'], $pin['GPIO'], $value, $pin['GPIO']);
		exec($cmd, $output, $return);		
		if (!$output || $return) return $this->formatErrorResponse($cmd, $output);
		$value = $output[0];
		
		return $this->formatSuccessResponse($pin, $value, OUT);
	}
	
	private function formatErrorResponse($output, $msg='') {
		return array(
			'status' => 'error',
			'response' => (empty($msg)?'cmd: '.$output.' failed!':$msg) 
		);
	}
	
	private function formatSuccessResponse($pin, $value, $mode) {
		$pin['status'] = 'success';
		$pin['Mode'] = $mode;
		$pin['Value'] = $value;
		
		return $pin;
	}
}
?>