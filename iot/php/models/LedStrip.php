<?php
/*
{
	"id":17,
	"pin":17,
	"state":0,
	"color":"#FFFFFF",
	"name":"RGB LED Strip",
	"leds_number":4,
	"leds":
		[
			{"id":0,"color":"#FFFFFF"},
			{"id":1,"color":"#FFFFFF"},
			{"id":2,"color":"#FFFFFF"},
			{"id":3,"color":"#FFFFFF"},
		]
}
*/
class LedStrip {
	public $id;
	public $name;
	public $led_number;
	public $pin;
	public $state;
	public $color;
	public $leds;

	public function __construct($jsonCfg = null) {
		if (!empty($jsonCfg)) $this->loadCfg($jsonCfg);
		else 'cfg not found!';
	}

	public function loadCfg($jsonCfg) {
		if (file_exists($jsonCfg)) {
			$cfg = json_decode(file_get_contents($jsonCfg));
			
			$this->id = $cfg->id;
			$this->name = $cfg->name;
			$this->led_number = $cfg->led_number;
			$this->pin = new GPIO($cfg->pin);
			$this->state = $cfg->state;
			$this->color = $cfg->color;
			$this->leds = $this->loadLEDs($cfg->leds);
		}
	}

	public function setColor($color) {
		//wiringpi::wiringPiSetup();
		$fd = wiringpi::serialOpen('/dev/ttyACM0', 9600);
		//wiringpi::serialPrintf($fd,'Set ledstrip color to: '.$color);
		//wiringpi::serialPrintf($fd,'led');
		echo 'data sent to serial';
		wiringpi::serialClose($fd);
	}

	public function setColor1($color) {
		$serial = new PhpSerial;
		$serial->deviceSet("/dev/ttyACM2");

		// We can change the baud rate, parity, length, stop bits, flow control
		$serial->confBaudRate(9600);
		$serial->confParity("none");
		$serial->confCharacterLength(8);
		$serial->confStopBits(1);
		$serial->confFlowControl("none");

		// Then we need to open it
		$serial->deviceOpen();

		// To write into
		$serial->sendMessage("Hello !");
	}

	public function loadLEDs($cfgData) {
		foreach ($cfgData as $led) {
			$leds[] = $led;
		}

		return $leds;
	}
}
?>