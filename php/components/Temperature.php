<?php
defined('TEMPERATURE_BEAN') or define('TEMPERATURE_BEAN', 'temperature');

define('CPU_TEMPERATURE', 0);
define('ROOM_TEMPERATURE', 1);

define('SOURCE_SENSOR', 0);
define('SOURCE_CALCULATED', 1);

class Temperature  {

	function __construct() {}
	
	public static function readSensorAndLog() {
		$temperature = new Command('tempsensor');
		$val = $temperature->response();
		
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
	
	public static function getStatValue($statDescription = DESCRIPTION_MAX, $type = ROOM_TEMPERATURE) {
		$item = R::findOne(TEMPERATURE_BEAN, ' type = ? AND source = ? AND description = ?', 
			array($type, SOURCE_CALCULATED, $statDescription));
			
		if (empty($item)) {
			$stats = new TemperatureStatistics($type);
			$stats->generateStatistics();
			$item = self::getStatValue($statDescription, $type);
		}
		
		return $item;
	}
	
	public static function getMin($type = ROOM_TEMPERATURE) {
		return self::getStatValue(DESCRIPTION_MIN, $type);
	}
	
	public static function getMax($type = ROOM_TEMPERATURE) {
		return self::getStatValue(DESCRIPTION_MAX, $type);
	}

	public static function getAvg($type = ROOM_TEMPERATURE) {
		return self::getStatValue(DESCRIPTION_AVG, $type);
	}	
	
	public static function getDate($date, $type = ROOM_TEMPERATURE, $bIncludeValues = false) {
		$values = null;
		if (in_array($date,array(DESCRIPTION_MIN_DATE, DESCRIPTION_MAX_DATE) )) {
			$data = self::getStatValue($date, $type);$date = $data->date;			
		}

		if ($bIncludeValues) {
 			$values = R::find(TEMPERATURE_BEAN, ' source = ? AND date(date) = date(?) ', array($type, $date));	
		}
		
		return array(
			'data' => $data,
			'values' => $values
		);		
	}
	
	public static function getMinDate($type = ROOM_TEMPERATURE, $bIncludeValues = false) {
		return self::getDate(DESCRIPTION_MIN_DATE, $type, $bIncludeValues);
	}

	public static function getMaxDate($type = ROOM_TEMPERATURE, $bIncludeValues = false) {
		return self::getDate(DESCRIPTION_MAX_DATE, $type, $bIncludeValues);
	}

	public static function getAvgDate($type = ROOM_TEMPERATURE, $date = null) {
		return R::find(TEMPERATURE_BEAN, ' source = ? AND date(date) = date(?) AND description LIKE ? ', array($type, $date, DESCRIPTION_AVG_DATE.'%'));
	}

	public static function getAvgDates($type = ROOM_TEMPERATURE) {
		return R::find(TEMPERATURE_BEAN, ' source = ? AND description LIKE ? ', array($type, DESCRIPTION_AVG_DATE.'%'));
	}
	
	public static function getAvgHours($type = ROOM_TEMPERATURE) {
		return R::find(TEMPERATURE_BEAN, ' source = ? AND description LIKE ? ', array($type, DESCRIPTION_AVG_HOUR.'%'));
	}

}

?>