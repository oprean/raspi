<?php
/*
{
	"id":17,
	"pin":17,
	"state":0,
	"color":"#FFFFFF",
	"name":"RGB LED Strip",
}
*/
class LedStrip {
	
	const LEDSTRIP_CONFIG_JSON = '../data/ledstrip.json';
	
	public $id;
	public $name;
	public $pin;
	public $pinObj;
	public $state;
	public $color;
	public $intensity;
	public $step;
	public $program;
	
	public function __construct() {
		$this->loadCfg(self::LEDSTRIP_CONFIG_JSON);
	}

	public function loadCfg($jsonCfgFile) {
		if (file_exists($jsonCfgFile)) {
			$cfg = json_decode(file_get_contents($jsonCfgFile));
			
			$this->id = $cfg->id;
			$this->name = $cfg->name;
			
			$this->pin = $cfg->pin;
			$this->pinObj = new GPIO($cfg->pin);
			$this->state = $this->pinObj->value;
			
			$this->color = $cfg->color;
			$this->intensity = $cfg->intensity;
			$this->step = empty($cfg->step)?1:$cfg->step;
			$this->program = $cfg->program;
		}
	}
	
	public function saveCfg($jsonData) {
		file_put_contents(self::LEDSTRIP_CONFIG_JSON, $jsonData);
		$this->loadCfg(self::LEDSTRIP_CONFIG_JSON);
	}
	
	public function sendCmd($cmd) {
		$fd = wiringpi::serialOpen(ARDUINO_TTY, 9600);
		wiringpi::serialPrintf($fd,"$cmd;");
		wiringpi::serialClose($fd);
	}
}
?>