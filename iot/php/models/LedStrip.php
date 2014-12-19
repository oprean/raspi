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
	public $id;
	public $name;
	public $pin;
	public $state;
	public $color;
	public $intensity;
	public $program;
	
	public function __construct($jsonCfg = null) {
		if (!empty($jsonCfg)) $this->loadCfg($jsonCfg);
		else 'cfg not found!';
	}

	public function loadCfg($jsonCfg) {
		if (file_exists($jsonCfg)) {
			$cfg = json_decode(file_get_contents($jsonCfg));
			$this->id = $cfg->id;
			$this->name = $cfg->name;
			$this->pin = new GPIO($cfg->pin);
			$this->state = $this->pin->value;
			$this->color = $cfg->color;
			$this->intensity = $cfg->intensity;
			$this->program = $cfg->program;
		}
	}
	
	public function sendCmd($cmd) {
		$fd = wiringpi::serialOpen(ARDUINO_TTY, 9600);
		wiringpi::serialPrintf($fd,"$cmd;");
		wiringpi::serialClose($fd);
	}
}
?>