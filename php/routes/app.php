<?php
$app->get('/', function () use ($app) {
	$file = DEBUG_MODE?'index.view.debug.php':'index.view.php';
	$template = file_get_contents(VIEWS_DIR.$file);
	$globalsJs = json_encode(array('DEBUG_MODE' => DEBUG_MODE,'rootUri' => $app->request->getRootUri()));
	$template = str_replace('{common.js}', $globalsJs, $template);
	echo $template;
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