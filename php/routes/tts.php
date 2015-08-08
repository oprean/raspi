<?php
$app->post('/tts', function () use ($app) {
	$espeak = new Espeak();
	$post = $app->request()->post();
	if (!empty($post['text'])) {
		$espeak->speak($post['text']);		
	}
});

function _time() {
	
}

$app->get('/tts/:cmd', function ($cmd) use ($app) {
	switch ($cmd) {
		case 'time':
			$tts = 'Este ora: {H} și {i} minute';
			$tts = str_replace(
				array('{H}', '{i}'), 
				array(date('H'), date('i')), 
				$tts
			);			
			break;
		case 'temp':
			$sensor = new TemperatureSensor();
			$temp = $sensor->read();
			$r = preg_match_all('/celsius=(?<value>.*)\|fahrenheit=(?<fahrenheit>.*)/', $temp, $matches);
			if (!empty($r) && !empty($matches['value'])) {
				$tts = 'În cameră sunt: '.$matches['value'][0].' grade.';
			} else {
				$tts = 'Nu am putut citi temperatura';
			}			
			break;
		default:
			$tts = 'comandă necunoscută';
			break;
	}
	
	$espeak = new Espeak();	
	$espeak->speak($tts);
	echo $tts;
});
?>