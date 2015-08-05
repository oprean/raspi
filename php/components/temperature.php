<?php      
define('DEVICE_FILE', '/w1_slave');
define('RETRY_NUMBER', 10);
define('RETRY_INTERVAL', 200);
define('BASE_W1_DIR', '/sys/bus/w1/devices/');
define('LOAD_W1_KERNEL_MODULE_CMD', 'sudo modprobe w1-gpio && sudo modprobe w1-therm');

class TemperatureSensor {
	private $_device_file;
	
	function __construct() {
		$result = $this->init();
		if ($result !== true) {
			throw new Exception($result);
		}
	}
	
	private function init() {
		$result = true;
		exec(LOAD_W1_KERNEL_MODULE_CMD, $output, $return);
		if ($output || $return) {
			$result = 'W1 kernel module could not loaded!';
		} else {
			$this->_device_file = $this->getDeviceFile();
			if (!is_file($this->_device_file)) {
				$result = 'DS18B20 sensor device file could not found!';
			}
		}
		return $result;
	}
	
	private function getDeviceFile() {
		$device_folder = glob(BASE_W1_DIR.'28*');
		if (empty($device_folder)) return false;
		return $device_folder[0].DEVICE_FILE;
	}
	
	function readRaw() {
		return file($this->_device_file);
	}
	
	function read() {
		$output = $this->readRaw();
		$retry = 0;
		$result = '';
		while (strpos($output[0], 'YES')== false && $retry < RETRY_NUMBER) {
			$output = $this->readRaw();
			$retry++;	
		}
		if (strpos($output[1], 't=') !== false) {
			$temp = substr($output[1], strpos($output[1], 't=') + 2);
			$tempCelsius = (float)$temp/1000; 
			$tempFahrenheit = $tempCelsius * 9 / 5 + 32;
						
			$result = 'celsius='.$tempCelsius.'|fahrenheit='.$tempFahrenheit;
		} else {
			$result = 'DS18B20 sensor could not be read!';
		}

		return $result;
	}
}

/*
 https://learn.adafruit.com/adafruits-raspberry-pi-lesson-11-ds18b20-temperature-sensing/ds18b20 
    import os
    import glob
    import time
     
    os.system('modprobe w1-gpio')
    os.system('modprobe w1-therm')
     
    base_dir = '/sys/bus/w1/devices/'
    device_folder = glob.glob(base_dir + '28*')[0]
    device_file = device_folder + '/w1_slave'
     
    def read_temp_raw():
        f = open(device_file, 'r')
        lines = f.readlines()
        f.close()
        return lines
     
    def read_temp():
        lines = read_temp_raw()
        while lines[0].strip()[-3:] != 'YES':
            time.sleep(0.2)
            lines = read_temp_raw()
        equals_pos = lines[1].find('t=')
        if equals_pos != -1:
            temp_string = lines[1][equals_pos+2:]
            temp_c = float(temp_string) / 1000.0
            temp_f = temp_c * 9.0 / 5.0 + 32.0
            return temp_c, temp_f
    	
    while True:
    	print(read_temp())	
    	time.sleep(1)*/

?>