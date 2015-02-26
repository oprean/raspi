<?php
// Reporting E_NOTICE can be good too (to report uninitialized
// variables or catch variable name misspellings ...)

ini_set("enable_dl","On");
require_once('library/wiringpi.php');
require_once('library/php-serial.php');
require_once('models/Constants.php');
require_once('models/GPIO.php');
require_once('models/Led.php');
require_once('models/LedStrip.php');
require_once('models/process.php');
//$H$9MD7CIF2xVvPir9mbCX4SRIOHK89cI.
class LedStripCtrl {
	public $serialConnectionCmd;
	public $ledStrip;

	public function __construct() {
		$this->init();
		$this->run();
	}
	
	private function init() {
		$this->serialConnectionCmd = 'python /var/www/raspi/iot/py/connect.py '.ARDUINO_TTY.' 9600 Raspi connected!';
		$this->ledStrip = new LedStrip();
	}
	
	public function actionTTYInit() {
		if (!BackgroundProcess::isStarted('Raspi')) {
			$process = new BackgroundProcess($this->serialConnectionCmd);
			$process->run();
		}
	}
	
	public function actionLedStrip() {
		
		$putdata = file_get_contents("php://input");
		if (!empty($putdata)) {
			$this->ledStrip->saveCfg($putdata);
		};
		echo json_encode($this->ledStrip);
	}
	
	//$pin int (GPIO pin)
	public function actionToogle() {
		$this->ledStrip->pinObj->toggleValue();
		$this->ledStrip->state = $this->ledStrip->pinObj->value; 
		if ($this->ledStrip->state == 0) {
			$this->ledStrip->sendCmd('p!0');
			$this->ledStrip->sendCmd('i!0');
		} else {
			$this->ledStrip->sendCmd('i!'.$this->ledStrip->intensity);
			$this->ledStrip->sendCmd('c!'.$this->ledStrip->color);
			$this->ledStrip->sendCmd('p!'.$this->ledStrip->program);
		}
		echo json_encode($this->ledStrip);	
	}

	public function actionChangeColor($color) {
		if (!BackgroundProcess::isStarted('Raspi')) {
			$process = new BackgroundProcess($this->serialConnectionCmd);
			$process->run();		
		}
		$this->ledStrip->setColor($color);
	}
	
	public function actionSendCommand($cmd) {
		if (!BackgroundProcess::isStarted('Raspi')) {
			$process = new BackgroundProcess($this->serialConnectionCmd);
			$process->run();		
		}
		$this->ledStrip->sendCmd($cmd);
	}
	
	public function run() {
		
		if (!isset($_GET['action'])) {
			$this->actionLedStrip();
			return true;
		}
		switch ($_GET['action']) {
			case 'toggle':
				$this->actionToogle();				
				break;
			case 'ttyInit':
				$this->actionTTYInit();
				break;
			case 'sendCommand':
				$this->actionSendCommand($_GET['cmd']);
				break;
			default:
				$this->actionLedStrip();					
				break;
		}		
	}
}
// ================ main program starts here! ================
$ctrl = new LedStripCtrl();
?>