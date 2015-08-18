<?php
defined('TEMPERATURE_BEAN') or define('TEMPERATURE_BEAN', 'temperature');

define('DESCRIPTION_MIN', 		'min');
define('DESCRIPTION_MIN_DATE', 	'min.date');

define('DESCRIPTION_MAX', 		'max');
define('DESCRIPTION_MAX_DATE', 	'max.date');

define('DESCRIPTION_AVG', 		'avg');
define('DESCRIPTION_AVG_DATE', 	'avg.date');
define('DESCRIPTION_AVG_HOUR', 	'avg.hour');

class TemperatureStatistics  {

	private $_type;
	
	function __construct($type) {
		$this->_type = $type;
	}

	// get all available dates
	public function dates() {
		$sql = "SELECT DISTINCT date(date) FROM ".TEMPERATURE_BEAN." WHERE type = ".$this->_type." AND source = ".SOURCE_CALCULATED;
		$dates = R::getCol($sql);
	}
	
	public function lastRun() {
		$statistic = R::findOne(TEMPERATURE_BEAN, " source = ? AND description = ? AND type = ? ", SOURCE_CALCULATED, DESCRIPTION_AVG, $this->_type );
		return empty($statistic)?FALSE:$statistic->date;		
	}
	
	public function updateStats($newT) {
		// if stats does not exists generate
		$lastRun = $this->lastRun(); 
		if ($lastRun === FALSE) {
			 $this->generateStatistics(); 
		} else {
			
		}	
	}

	private function _generateMin() {
		$sql = "SELECT date, MIN(value) AS value FROM ".TEMPERATURE_BEAN." WHERE source <> ".SOURCE_CALCULATED." AND source = ".$this->_type;
		$min = R::getRow($sql);
		$item = R::dispense(TEMPERATURE_BEAN); 
		$item->type = $this->_type;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_MIN;
		$item->date = $min['date'];
		$item->value = $min['value'];
			 
	    R::store($item);		
	}
	
	private function _generateMax() {
		$sql = "SELECT date, MAX(value) AS value FROM ".TEMPERATURE_BEAN." WHERE source <> ".SOURCE_CALCULATED." AND source = ".$this->_type;
		$min = R::getRow($sql);
		$item = R::dispense(TEMPERATURE_BEAN); 
		$item->type = $this->_type;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_MAX;
		$item->date = $min['date'];
		$item->value = $min['value'];
			 
	    R::store($item);		
	}
	
	private function _generateAvg() {
		$sql = "SELECT AVG(value) AS value, COUNT() AS count FROM ".TEMPERATURE_BEAN." WHERE source <> ".SOURCE_CALCULATED." AND source = ".$this->_type;
		$min = R::getRow($sql);
		$item = R::dispense(TEMPERATURE_BEAN); 
		$item->type = $this->_type;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_AVG.':'.$avg['count'];
		$item->date = date('Y-m-d H:i:s');
		$item->value = $min['value'];
			 
	    R::store($item);
	}

	private function _generateAvgDate($date) {
		$sql = "SELECT AVG(value) AS value, COUNT() AS count FROM ".TEMPERATURE_BEAN." WHERE '$date' = date(date) AND source = ".$this->_type;
		$avg = R::getRow($sql);

		$item = R::dispense(TEMPERATURE_BEAN); 
		$item->type = $this->_type;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_AVG_DATE.':'.$avg['count'];
		$item->date = date('Y-m-d H:i:s');
		$item->value = $avg['value'];
	 
	    R::store($item);		
	}
	
	private function _generateAvgHour($hour) {
		$sql = "SELECT AVG(value) AS value, COUNT() AS count FROM ".TEMPERATURE_BEAN." WHERE strftime('%H',date) = '$hour' AND source = ".$this->_type;
		$avg = R::getRow($sql);

		$item = R::dispense(TEMPERATURE_BEAN); 
		$item->type = $this->_type;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_HOUR_AVG.':'.$avg['count'];
		$item->date = date('Y-m-d H:i:s');
		$item->value = $avg['value'];
	 
	    R::store($item);	
	}

	private function _generateMinDate() {
		$sql = "SELECT * FROM ".TEMPERATURE_BEAN." WHERE source = ".SOURCE_CALCULATED." AND description = '".DESCRIPTION_AVG_DATE."' ORDER BY value asc LIMIT 1";
		$max = R::getRow($sql);
		$item = R::dispense(TEMPERATURE_BEAN); 
		$item->type = $this->_type;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_MIN_DATE;
		$item->date = $min['date'];
		$item->value = $min['value'];
			 
	    R::store($item);		
	}
	
	private function _generateMaxDate() {
	$sql = "SELECT * FROM ".TEMPERATURE_BEAN." WHERE source = ".SOURCE_CALCULATED." AND description = '".DESCRIPTION_AVG_DATE."' ORDER BY value desc LIMIT 1";
		$max = R::getRow($sql);
		$item = R::dispense(TEMPERATURE_BEAN); 
		$item->type = $this->_type;
		$item->source = SOURCE_CALCULATED;
		$item->description = DESCRIPTION_MAX_DATE;
		$item->date = $max['date'];
		$item->value = $max['value'];
			 
	    R::store($item);		
	}

	public function generateStatistics() {
	
		// delete old stats
		$statistics = R::find(TEMPERATURE_BEAN, ' source = ? ', SOURCE_CALCULATED );
		R::trashAll($statistics);

		// generate absolute values
		$this->_generateMax();
		$this->_generateMin();
		$this->_generateAvg();

		// generate dates values
		$dates = $this->dates();	
		foreach ($dates as $date) {
			$this->_generateAvgDate($date);
		}			
		$this->_generateMinDate();
		$this->_generateMaxDate();
	
		// generate hourly average values
		for ($hour=0; $hour <= 23; $hour++) { 
			$this->_generateAvgHour($hour);
		}
	}
}

?>