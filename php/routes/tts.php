<?php
$app->post('/tts', function () use ($app) {
	$post = $app->request()->post();
	if (!empty($post['tts'])) {
		$espeak = new Espeak($post['lang'], $post['gender'], $post['voice'], $post['speed']);		
		$espeak->speak($post['tts']);		
	}
});

$app->get('/tts/:cmd', function ($cmd) use ($app) {
	switch ($cmd) {
		case 'time':
			$tts = 'Este ora: {G} și {i} minute';
			$tts = str_replace(
				array('{G}', '{i}'), 
				array(date('G'), date('i')), 
				$tts
			);			
			break;
		case 'temp':
			$sensor = new TemperatureSensor();
			$temp = $sensor->read();
			$r = preg_match_all('/celsius=(?<value>.*)\|fahrenheit=(?<fahrenheit>.*)/', $temp, $matches);
			if (!empty($r) && !empty($matches['value'])) {
				$tts = 'În cameră sunt: '.str_replace('.', ' virgulă ', $matches['value'][0]).' grade.';
			} else {
				$tts = 'Nu am putut citi temperatura';
			}			
			break;
		default:
			break;
	}
	
	$espeak = new Espeak();	
	$espeak->speak($tts);
	echo $tts;
});
?>