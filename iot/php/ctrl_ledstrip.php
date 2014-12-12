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
	const LEDSTRIP_CONFIG_JSON = '../data/ledstrip.json';
	public $serialConnectionCmd;
	public $ledStrip;

	public function __construct() {
		$this->init();
		$this->run();
	}
	
	private function init() {
		$this->serialConnectionCmd = 'python /var/www/raspi/iot/py/connect.py '.ARDUINO_TTY.' 9600 Raspi connected!';
		$this->ledStrip = new LedStrip(self::LEDSTRIP_CONFIG_JSON);
	}
	
	public function actionTTYInit() {
		if (!BackgroundProcess::isStarted('Raspi')) {
			$process = new BackgroundProcess($this->serialConnectionCmd);
			$process->run();
		}
	}
	
	public function actionLedStrip() {
		echo json_encode($this->ledStrip);
	}
	
	//$pin int (GPIO pin)
	public function actionToogle() {
		$this->ledStrip->pin->toggleValue();
		$this->ledStrip->state = $this->ledStrip->pin->value; 
		echo json_encode($this->ledStrip);	
	}

	public function actionChangeColor($color) {
		if (!BackgroundProcess::isStarted('Raspi')) {
			$process = new BackgroundProcess($this->serialConnectionCmd);
			$process->run();		
		}
		$this->ledStrip->setColor($color);
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
			case 'cchange':
				$this->actionChangeColor($_GET['color']);
			default:
				$this->actionLedStrip();					
				break;
		}		
	}
}
// ================ main program starts here! ================
$ctrl = new LedStripCtrl();
?>