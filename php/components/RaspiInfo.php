<?php
class RaspiInfo {
	function __construct() {}
	public function all() {
		return array(
			'temp' => array(
					'id' => 'temp',
					'txt' => 'vcgencmd measure_temp',
					'regexp' => '(temp)=(?<value>.*)\'C'	
					),
			'clock' => array(
					'id' => 'clock',
					'txt' => 'vcgencmd measure_clock arm',
					'regexp' => '(frequency.*)=(?<value>.*)000000'		
					),
			'volts' => array(
					'id' => 'volts',
					'txt' => 'vcgencmd measure_volts core',
					'regexp' => '(volt)=(?<value>.*)V'		
					),
			'meminfo' => array(
					'id' => 'volts',
					'txt' => 'cat /proc/meminfo',
					'regexp' => false		
					),
			'date' => array(
					'id' => 'date',
					'txt' => 'date',
					'regexp' => '/(?<value>.*)/'		
					),
			'dir' => array(
					'id' => 'dir',
					'txt' => 'dir',
					'regexp' => false		
					),
		);
	}
	
	private function cmd($id) {
		$all = $this->all();
		return array_key_exists($id, $all)?$all[$id]:null;
	}
	
	public function get($id) {
		$cmd = $this->cmd($id);
		if (empty($cmd)) return $this->formatErrorResponse($cmd, array('Unknown command.'));
		exec($cmd['txt'], $output, $return);
			
		if (!$output || $return) return $this->formatErrorResponse($cmd, $output);
		
		if (!empty($cmd['regexp'])) { // scalar value
			$r = preg_match_all('/'.$cmd['regexp'].'/', $output[0], $matches);
			if (!empty($r) && !empty($matches['value'])) {
				$result = $this->formatSuccessResponse($cmd, $matches['value'][0]);	
			} else { // command failed
				$result = $this->formatErrorResponse($cmd, $output);
			}	
		} else { // array response
			$result = $this->formatSuccessResponse($cmd, $output);				
		}
		
		return $result;
	}
	
	private function formatErrorResponse($cmd, $output, $msg='') {
		return array(
			'status' => 'error',
			'data' => array(
				'message' => 'Failed to execute command "'. $cmd['txt'].'". Error: '. (empty($msg)?implode("\n", $output):$msg) 
			)
		);
	}
	
	private function formatSuccessResponse($cmd, $response) {
		return array(
			'status' => 'success',
			'data' => array(
				'cmd' => $cmd['txt'],
				'response' => $response,  
			)
		);	
	}
}

?>