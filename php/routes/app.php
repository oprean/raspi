<?php
$app->get('/', function () use ($app) {
	$file = DEBUG_MODE?'index.view.debug.php':'index.view.php';
	 $template = file_get_contents(VIEWS_DIR.$file);
	 echo $template;
});

$app->get('/login', function () use ($app) {
	$head = file_get_contents(VIEWS_DIR.'head.common.php');
	$head = str_replace('{title}', $app->request->getResourceUri(), $head);
	$page = file_get_contents(VIEWS_DIR.'login.view.php');
	$page = str_replace('{head.common}', $head, $page);
	echo $page;
});

$app->post('/login', function () use ($app) { 
	$post = $app->request()->post();
	if (User::validateUser($post['username'], $post['password'])) {
		User::login($post['username'], $post['password']);
		$app->redirect('/raspi');		
	} else {
		echo 'login failed';
	}
	
});

$app->get('/logout', function () use ($app) {
	
});

?>