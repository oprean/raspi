<?php

/*include('wiringpi.php');

$s1s = wiringpi::digitalRead(17);
$s2s = wiringpi::digitalRead(11); 
*/

class GPIOPin {
	
	const ON = 1;
	const OFF = 0;
	const OUT = 1;
	const IN = 0;
	const UK = 2; // unknown
	public $ppin;
	public $bpin;
	public $wpin;
	public $mode;
	public $state;
	public $name;
	
	public function __construct($pin, $name = null, $state = null) {
		$this->ppin = $pin;
		$this->bpin = $pin;
		$this->wpin = $pin;
		$this->mode = self::UK;
		$this->name = $name;
		$this->state = ($state === null)?wiringpi::digitalRead($this->pin):$state;
	}
	
	// for testing only!
	public function _toggleState() {
		$state = wiringpi::digitalRead($this->pin);
		$newState = ($state == Socket::ON)?Socket::OFF:Socket::ON;
		$this->state = wiringpi::digitalWrite($newState);
		return true;
	}
	
	public function toggleState() {
		$this->state = ($this->state == Socket::ON)?Socket::OFF:Socket::ON;
		return true;
	}
}

class SocketCtrl {
	const SOCKET_CONFIG_JSON = 'gpio.json';
	public $sockets;

	public function __construct() {
		$this->init();
		$this->run();
	}
	
	private function init() {
		$sockets = json_decode(file_get_contents(SocketCtrl::SOCKET_CONFIG_JSON));
		foreach ($sockets as $socketCfg) {
			$s = new GPIOPin($socketCfg->ppin, $socketCfg->name, $socketCfg->state);					// remove ', $socketCfg->state' on production
			$this->sockets[] = $s;
		}
	}
	
	private function getSocketByPin($pin) {
		foreach ($this->sockets as $s) {
			if ($s->pin == $pin) return $s;
		}
		return false;
	}
	
	public function actionSockets() {
		echo json_encode($this->sockets);
	}
	
	//$socket int (GPIO pin)
	public function actionToogle($socketPin) {
		$socket = $this->getSocketByPin($socketPin);
		if (!empty($socket)) $socket->toggleState();
		file_put_contents(SocketCtrl::SOCKET_CONFIG_JSON, json_encode($this->sockets));				// remove / comment on production
		echo json_encode($socket);
	}
	
	public function run() {
		
		if (!isset($_GET['action'])) {
			$this->actionSockets();
			return true;
		}
		switch ($_GET['action']) {
			case 'toggle':
				$this->actionToogle($_GET['pin']);				
				break;
			default:
				$this->actionSockets();					
				break;
		}		
	}
}
// ================ main program starts here! ================
$ctrl = new SocketCtrl();
?>