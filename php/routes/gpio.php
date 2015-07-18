<?php
require_once '../php/components/gpio.php';

$app->get('/gpio/:cmd', function ($cmd) use ($app) {
	$oCmd = new Command();
	$response = $oCmd->response($cmd);
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/gpio', function () use ($app) {
	$gpio = new GPIO();
	$response = $gpio->readall();
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

?>