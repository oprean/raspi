<?php   
//http://espeak.sourceforge.net/commands.html
//http://diyhacking.com/best-voice-recognition-software-for-raspberry-pi/
//http://stevenhickson.blogspot.in/2013/04/voice-control-on-raspberry-pi.html
//http://blog.oscarliang.net/raspberry-pi-voice-recognition-works-like-siri/ 
//https://wolfpaulus.com/about/  
define('TTS_COMMAND', 'sudo espeak -a{vol} -v{lang}+{gender}{voice} -k{capital} -s{speed} ');

// defaults
define('DEFAULT_LANGUAGE', 'ro');
define('DEFAULT_VOLUME', 500);
define('DEFAULT_VOICE', 4);
define('DEFAULT_GENDER', 'm');
define('DEFAULT_CAPITAL', 20);
define('DEFAULT_SPEED', 120);
define('DEFAULT_TEXT', '1 2 3 Test');

class Espeak {
	
	private $_language = DEFAULT_LANGUAGE;
	private $_voice = DEFAULT_VOICE;
	private $_gender = DEFAULT_GENDER;
	private $_volume = DEFAULT_VOLUME;
	private $_speed = DEFAULT_SPEED;
	private $_capital = DEFAULT_CAPITAL;

	private $_tts_cmd;
	
	function __construct($lang = DEFAULT_LANGUAGE, $gender = DEFAULT_GENDER, $voice = DEFAULT_VOICE, $speed = DEFAULT_SPEED ) {
		$this->_language = $lang;
		$this->_gender = $gender;
		$this->_voice = $voice;
		$this->_speed = $speed;
		$this->init();
	}
	
	public static function voices($gender = DEFAULT_GENDER ) {
		return array(
			array('id' => 'm1', 'gender' => 'm', 'name' => 'male voice 1'),
			array('id' => 'm2', 'gender' => 'm', 'name' => 'male voice 2'),
		);
	}
	
	private function init() {
		$search = array('{lang}', '{vol}', '{gender}' , '{voice}', '{speed}', '{capital}');
		$replace = array($this->_language, $this->_volume, $this->_gender, $this->_voice, $this->_speed, $this->_capital);
		
		$this->_tts_cmd = str_replace($search, $replace, TTS_COMMAND);
	}
	
	public function speak($text = DEFAULT_TEXT) {
		$cmd = $this->_tts_cmd.'"'.$text.'"';
		echo $cmd;
		exec($cmd, $output, $return);
	}
	
	public static function talk($text) {
		exec($cmd, $output, $return);
	}
}

?>