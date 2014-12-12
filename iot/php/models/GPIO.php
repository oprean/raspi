<?php
class GPIO {
	
	//gpio values
	const HIGH = 1;
	const LOW = 0;

	//gpio modes
	const IN = 0;
	const OUT = 1;
	const ALT0 = 2;
	const ALT2 = 3;

	const GPIO_JSON = '../data/gpio.json';
	
	public $id;
	public $pin;
	public $mode;
	public $value;
	public $name;
	public $altname;
	
	public function __construct($pin) {
		$this->id = $pin;
		$this->pin = $pin;

		$jsonInfo = self::info($pin);
		$this->name = $jsonInfo->name;
		$this->altname = $jsonInfo->altname;

		$this->value = wiringpi::digitalRead($this->pin);

	}
	
	public static function info($pin) {
		if (file_exists(self::GPIO_JSON)) {
			$cfg = json_decode(file_get_contents(self::GPIO_JSON));
			foreach ($cfg as $gpio) {
				if ($gpio->pin == $pin) return $gpio;
			}
		}
	}

	public function toggleValue() {
		$value = wiringpi::digitalRead($this->pin);
		$newValue = ($value == self::HIGH)?self::LOW:self::HIGH;
		wiringpi::digitalWrite($this->pin, $newValue);
		$this->value = wiringpi::digitalRead($this->pin);
		return true;
	}

	public function setMode($mode) {
		wiringpi::pinMode($this->pin, $mode);
		return true;
	}
}
?>