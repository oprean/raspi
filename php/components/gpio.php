<?php
require_once '../php/components/commands.php';
class GPIO {
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
		for($i=2;$i<=22;$i++) {
			$rawData = preg_replace('/\s+/', ' ',$rawResponse[$i]);
			$r = preg_match_all($gpio_readall_pattern, $rawData, $matches);
			if ($r && array_key_exists('Value', $matches)) {
				$response[] = array(
					'id' => $matches['GPIO'][0],
					'wiringPi' => $matches['wiringPi'][0],
					'GPIO' => $matches['GPIO'][0],
					'Phys' => $matches['Phys'][0],
					'Name' => $matches['Name'][0],
					'Mode' => $matches['Mode'][0],
					'Value' => $matches['Value'][0],
				);
			}	
		}
		
		return $response;
	}
	
	private function formatErrorResponse($output, $msg='') {
		return array(
			'status' => 'error',
			'response' => (empty($msg)?$output:$msg) 
		);
	}
	
	private function formatSuccessResponse($cmd, $response) {
		return array(
			'status' => 'success',
			'id' => $cmd['id'],
			'cmd' => $cmd['txt'],
			'response' => $response,
		);	
	}
}
?>