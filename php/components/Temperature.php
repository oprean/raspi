<?php
defined('TEMPERATURE_BEAN') or define('TEMPERATURE_BEAN', 'temperature');

define('CPU_TEMPERATURE', 0);
define('ROOM_TEMPERATURE', 1);

define('SOURCE_SENSOR', 0);
define('SOURCE_CALCULATED', 1);

define('DESCRIPTION_MIN', 'min');
define('DESCRIPTION_MAX', 'max');
define('DESCRIPTION_AVG', 'avg');

class Temperature  {

	function __construct() {}
	
	public static function readSensorAndLog() {
		$temperature = new Command('tempsensor');
		$val = $temperature->response();
		//$val = array('status' => 'success', 'response' => 28.00);
		
		if ($val['status'] == 'success') {
			$item = R::dispense(TEMPERATURE_BEAN); 
			$item->type = ROOM_TEMPERATURE;
			$item->date = date('Y-m-d H:i:s');
			$item->value = $val['response'];
		 
		    R::store($item);		
		} else {
			return $val['response'];
		}		
	}
	
	public static function getMin() {
		$item = R::findOne(TEMPERATURE_BEAN, ' type = ? AND source = ? AND description = ?', 
			array(ROOM_TEMPERATURE, SOURCE_CALCULATED, DESCRIPTION_MIN));
		if (empty($item)) {
			// generate and return min
			generateStats();
			return getMin();
		}
	}

	public static function getMax() {
		$item = R::findOne(TEMPERATURE_BEAN, ' type = ? AND source = ? AND description = ?', 
			array(ROOM_TEMPERATURE, SOURCE_CALCULATED, DESCRIPTION_MAX));
		if (empty($item)) {
			// generate and return min
			generateStats();
			return getMin();
		}
	}

	public static function getAvg() {
		$item = R::findOne(TEMPERATURE_BEAN, ' type = ? AND source = ? AND description = ?', 
			array(ROOM_TEMPERATURE, SOURCE_CALCULATED, DESCRIPTION_AVG));
		if (empty($item)) {
			// generate and return min
			generateStats();
			return self::getAvg();
		}
	}

	public static function generateStats() {
		$sql = "SELECT DISTINCT date(date) FROM temperature";
		$dates = R::getCol($sql);
		
		//1 delete old stats
		$statistics = R::find(TEMPERATURE_BEAN, ' source = ? ', SOURCE_CALCULATEDu );
		R::trashAll($statistics);
		
		//2 generate date avg
		foreach ($dates as $date) {
			$sql = "SELECT AVG(value) FROM temperature WHERE '$date' = date(date)";
			$value = R::getCell($sql);
	
			$item = R::dispense('temperature'); 
			$item->type = ROOM_TEMPERATURE;
			$item->source = SOURCE_CALCULATED;
			$item->description = DESCRIPTION_AVG;
			$item->date = $date;
			$item->value = $value;
		 
		    R::store($item);
		}	
		
		//calc min
		$sql = "SELECT * FROM temperature WHERE source=".SOURCE_CALCULATED." AND description='".DESCRIPTION_AVG."' ORDER BY value asc LIMIT 1";
		$max = R::getRow($sql);
		$item = R::dispense('temperature'); 
		$item->type = ROOM_TEMPERATURE;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_MIN;
		$item->date = $min['date'];
		$item->value = $min['value'];
			 
	    R::store($item);
	
		//calc max
		$sql = "SELECT * FROM temperature WHERE source=".SOURCE_CALCULATED." AND description='".DESCRIPTION_AVG."' ORDER BY value desc LIMIT 1";
		$max = R::getRow($sql);
		$item = R::dispense('temperature'); 
		$item->type = ROOM_TEMPERATURE;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_MIN;
		$item->date = $max['date'];
		$item->value = $max['value'];
			 
	    R::store($item);	
		
	}
}

?>