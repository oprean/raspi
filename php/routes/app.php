<?php
$app->get('/', function () use ($app) {
	$file = DEBUG_MODE?'index.view.debug.php':'index.view.php';
	$template = file_get_contents(VIEWS_DIR.$file);
	$globalsJs = json_encode(array('DEBUG_MODE' => DEBUG_MODE,'rootUri' => $app->request->getRootUri()));
	$template = str_replace('{common.js}', $globalsJs, $template);
	echo $template;
});

$app->get('/login', function () use ($app) {

	$head = file_get_contents(VIEWS_DIR.'head.common.php');
	$head = str_replace('{title}', $app->request->getResourceUri(), $head);
	
	$globalsjs = json_encode(array('DEBUG_MODE' => DEBUG_MODE,'rootUri' => $app->request->getRootUri()));

	$page = file_get_contents(VIEWS_DIR.'login.view.php');
	$page = str_replace('{head.common}', $head, $page);
	$page = str_replace('{common.js}', $globalsjs, $page);
	
	echo $page;
});

$app->post('/login', function () use ($app) { 
	$post = $app->request()->post();
	if (User::validateUser($post['username'], $post['password'])) {
		$auth = User::login($post['username'], $post['password']);
		
    	$auth = json_encode($auth);		
		$app->response()->header('Content-Type', 'application/json');
		echo $auth;
	} else {
		$app->response()->status(401);
	}
	
});

?>