<?php

define('TTS_COMAAND', 'espeak -vro+m1 -k2 -s150 ');

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

$app->get('/temps', function () use ($app) {
    	
    // get all items
    $items = R::find('teperature');
	
    // create JSON response
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode(R::exportAll($items));	
});

$app->get('/speak(/:text)', function ($text = 'te iubesc cami') use ($app) {
	$cmd = TTS_COMAAND.'"'.$text.'"';
    exec($cmd, $output, $return);
	
    // create JSON response
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode(array(
    	'status' => 'success',
    	'cmd' => $cmd
		)
	);	
});

?>