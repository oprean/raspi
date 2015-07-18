<?php
require_once '../php/components/commands.php';

$app->get('/cmd/:cmd', function ($cmd) use ($app) {
	$oCmd = new Command();
	$response = $oCmd->response($cmd);
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

$app->get('/cmd', function () use ($app) {
	$oCmd = new Command();
	foreach ($oCmd->all() as $cmdId => $command) {
		$response[] = $oCmd->response($cmdId);
	}
	
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode($response);	
});

?>