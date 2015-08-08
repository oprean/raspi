<?php

define('TTS_COMAAND', 'sudo espeak -a500 -vro+m4 -k20 -s120 ');

$app->get('/request', function () use ($app) {
	//echo RUNTIME_DIR;
	$req = $app->request;

	//Get root URI
	$rootUri = $req->getRootUri();
	
	//Get resource URI
	$resourceUri = $req->getResourceUri();
	
	//echo $rootUri;
	echo $resourceUri;
	//echo str_replace('/api', '/', $req->getUrl().$req->getRootUri());
	
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