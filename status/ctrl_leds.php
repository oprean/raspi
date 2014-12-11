<?php
ini_set("enable_dl","On");
include('wiringpi.php');

class Socket {
	
	const ON = 1;
	const OFF = 0;
	public $id;
	public $pin;
	public $state;
	public $name;
	
	public function __construct($pin, $name = null) {
		$this->id = $pin;
		$this->pin = $pin;
		$this->name = $name;
		//wiringpi::digitalWrite($this->pin, 1);
		//echo $this->pin.'->'.wiringpi::digitalRead($this->pin);
		$this->state = wiringpi::digitalRead($this->pin);

	}
	
	// for testing only!
	public function toggleState() {
		$state = wiringpi::digitalRead($this->pin);
		$newState = ($state == Socket::ON)?Socket::OFF:Socket::ON;
		wiringpi::digitalWrite($this->pin, $newState);
		$this->state = wiringpi::digitalRead($this->pin);
		return true;
	}
	
	public function _toggleState() {
		$this->state = ($this->state == Socket::ON)?Socket::OFF:Socket::ON;
		return true;
	}
}

class SocketCtrl {
	const SOCKET_CONFIG_JSON = 'sockets.json';
	public $sockets;

	public function __construct() {
		$this->init();
		$this->run();
	}
	
	private function init() {
		$sockets = json_decode(file_get_contents(SocketCtrl::SOCKET_CONFIG_JSON));
		foreach ($sockets as $socketCfg) {
			$s = new Socket($socketCfg->pin, $socketCfg->name);					// remove ', $socketCfg->state' on production
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
		if (!empty($socket)) {
			$socket->toggleState();
			echo json_encode($socket);
		}		
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