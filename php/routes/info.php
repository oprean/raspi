<?php
$app->get('/test', function () use ($app) {
	//echo RUNTIME_DIR;
	$req = $app->request;

	//Get root URI
	$rootUri = $req->getRootUri();
	
	//Get resource URI
	$resourceUri = $req->getResourceUri();
	
	//echo $resourceUri;
	//echo $rootUri;
	echo str_replace('/api', '/', $req->getUrl().$req->getRootUri());
	
});

$app->get('/vcgencmd/:cmd', function ($cmd) use ($app) {
	switch($cmd) {
		case 'temp':	
			$cmd = 'vcgencmd measure_temp';
			break;
		case 'clock':	
			$cmd = 'vcgencmd measure_clock arm';
			break;
		case 'volts':	
			$cmd = 'vcgencmd measure_volts core';
			break;
	}
	$result = exec($cmd); 
	$result = split('=', $result);
	
	return (count($result) == 2)?$result[1]:'Commad failed!';
	
});
?>