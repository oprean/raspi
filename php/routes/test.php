<?php
$app->get('/request', function () use ($app) {
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

$app->get('/gpiomode/:pin', function ($pin) use ($app) {
	echo file_get_contents('/sys/class/gpio/gpio'.($pin + 0).'/direction');	
});

$app->get('/temp', function () use ($app) {
	try	{
		$tempSensor = new TemperatureSensor();
		echo $tempSensor->read();
	} catch(Exception $e) {
		echo $e->getMessage();
	}
});

?>