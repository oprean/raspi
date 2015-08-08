<?php
define('TEMPERATURE_BEAN', 'temperature');

$app->get('/temperature', function () use ($app) {

    $items = R::find(TEMPERATURE_BEAN, ' ORDER BY date desc'); 
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode(R::exportAll($items));
});

$app->get('/temperature/:id', function ($id) use ($app) {
    	
    $items = R::findOne(TEMPERATURE_BEAN, 'id=?', array($id));
    if ($items) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode(R::exportAll($items));
    } else {
        $app->response()->status(404);
    }	
});

?>