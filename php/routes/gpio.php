<?php
require_once(ROOT_DIR.'/php/components/gpio.php');

$app->get('/gpio', function () use ($app) {
	$oGPIO = new GPIO();
	$response = $oGPIO->readall();
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/gpio/:pin(/:mode)', function ($pin, $numbering = DEFAULT_PIN_NUMBERING) use ($app) {
	$oGPIO = new GPIO();
	$response = $oGPIO->read($pin,$numbering);
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->put('/gpio/:pin/:value(/:mode)', function ($pin, $value, $numbering = DEFAULT_PIN_NUMBERING) use ($app) {
	$oGPIO = new GPIO();
	$response = $oGPIO->write($pin, $value, $numbering);
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/gpiomode/:pin/:mode', function ($pin, $mode, $numbering = DEFAULT_PIN_NUMBERING) use ($app) {
	$oGPIO = new GPIO();
	$response = $oGPIO->mode($pin,$mode, $numbering);
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/gpioreset', function () use ($app) {
	$oGPIO = new GPIO();
	$response = $oGPIO->resetall();
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

?>