<?php
class Utils {
	static function pushalot($message) {
		$pushalot = new Pushalot('c18c8a1f95eb47c0bf3202582d001491');
		$success = $pushalot->sendMessage(array(
			'Title'=>'Raspi notification!',
			'Body'=> $message,
			'LinkTitle'=>'Raspi',
			'Link'=>'http://oprean.ddns.net/raspi/',
			'IsImportant'=>true,
			'IsSilent'=>true,
			'Image'=>'http://oprean.ddns.net/raspi/assets/img/logo.png',
			'Source'=>'raspi'
		));
		echo $success?'The message was submitted.':$pushalot->getError();		
	}
}

?>