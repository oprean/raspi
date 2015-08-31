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

$app->patch('/gpio/:pin(/:mode)', function ($pin, $numbering = DEFAULT_PIN_NUMBERING) use ($app) {
	
	$request = $app->request();
	$body = $request->getBody(); 
	$input = json_decode($body);
	$oGPIO = new GPIO();
		
	if (isset($input->Mode)) {
		$response = $oGPIO->mode($pin,$input->Mode, $numbering);
	} else if (isset($input->Value)) {
		$response = $oGPIO->write($pin, $input->Value, $numbering);
	}
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/gpioreset', function () use ($app) {
	$oGPIO = new GPIO();
	$response = $oGPIO->resetall();
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/toggle/gpio/:pin', function ($pin) use ($app) {
	$oGPIO = new GPIO();
	$data = $oGPIO->read($pin, DEFAULT_PIN_NUMBERING);
	if ($data['status'] == 'success') {
		$value = $data['Value']?1:0;
		$response = $oGPIO->write($pin, $value, DEFAULT_PIN_NUMBERING);
	}
	
	Utils::pushalot('Pin '.$pin.' value is now '.$value);	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

?>