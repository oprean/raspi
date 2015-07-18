<?php
require_once '../php/components/commands.php';
require_once '../php/components/gpio.php';

$app->get('/gpio/:cmd', function ($cmd) use ($app) {
	$oCmd = new Command();
	$response = $oCmd->response($cmd);
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/gpio', function () use ($app) {
	$oCmd = new Command();
	$response = $oCmd->response('gpioreadall');
	$gpio_readall_pattern = '/\|\s(?<wiringPi>\d+)\s\|\s(?<GPIO>\d+)\s\|\s(?<Phys>\d+)\s\|\s(?<Name>.+)\s\|\s(?<Mode>.+)\s\|\s(?<Value>.+)\s\|/';
	for($i=2;$i<=22;$i++) {
		$rawData = preg_replace('/\s+/', ' ',$response[$i]);
		$r = preg_match_all($gpio_readall_pattern, $rawData, $matches);
		if ($r && array_key_exists('Value', $matches)) {
			$response[] = array(
				'wiringPi' => $matches['wiringPi'],
				'GPIO' => $matches['GPIO'],
				'Phys' => $matches['Phys'],
				'Name' => $matches['Name'],
				'Mode' => $matches['Mode'],
				'Value' => $matches['Value'],
			);
		}	
	}
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

?>