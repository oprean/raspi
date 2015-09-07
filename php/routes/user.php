<?php
$app->get('/user', function () use ($app) {
	$items = R::findAll(USER_BEAN);
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode(R::exportAll($items));	
});

$app->get('/user/:id', function ($id) use ($app) {
    	
    $item = R::findOne(USER_BEAN, 'id=?', array($id));
    if ($item) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($item->export());
    } else {
        $app->response()->status(404);
    }	
});

$app->post('/user/changepwd', function () use ($app) { 
	$post = $app->request()->post();
	$user = User::validateUser($post['username'], $post['oldpassword']); 
	if (!empty($user)) {
		$user->password = md5($post['newpassword']);
		R::store($user);
		$auth = User::login($post['username'], $post['newpassword']);
		
    	$auth = json_encode($auth);		
		$app->response()->header('Content-Type', 'application/json');
		echo $auth;
	} else {
		$app->response()->status(403);
	}
	
});
?>