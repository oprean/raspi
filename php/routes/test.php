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
?>