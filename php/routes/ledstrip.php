<?php
$app->post('/ledstrip', function () use ($app) {
	$post = $app->request()->post();
	if (!empty($post['cmd'])) {
		$cmd = 'python ../py/ledstrip.py '.$post['r'].' '.$post['g'].' '.$post['b'];
		exec($cmd,$output, $return);
		print_r($output);
		
		
	$req = $app->request;

	//Get root URI
	$rootUri = $req->getRootUri();
	
	//Get resource URI
	$resourceUri = $req->getResourceUri();
	
	echo $rootUri.'<br>';
	echo $resourceUri.'<br>';
	echo str_replace('/api', '/', $req->getUrl().$req->getRootUri()).'<br>';
	
	echo __FILE__;		
	}
});