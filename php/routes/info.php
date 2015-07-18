<?php
require_once '../php/components/RaspiInfo.php';

$app->get('/info/:cmd', function ($cmd) use ($app) {
	$raspi = new RaspiInfo();
	$response = $raspi->get($cmd);
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/info', function () use ($app) {
	$raspi = new RaspiInfo();
	foreach ($raspi->all() as $cmdid => $command) {
		$response[] = $raspi->get($cmdid);
	}
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

?>