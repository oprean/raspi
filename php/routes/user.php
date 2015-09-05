<?php
$app->get('/user/:id', function ($id) use ($app) {
    	
    $item = R::findOne(USER_BEAN, 'id=?', array($id));
    if ($item) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode(R::exportAll($item));
    } else {
        $app->response()->status(404);
    }	
});
?>