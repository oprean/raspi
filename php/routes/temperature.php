<?php
defined('TEMPERATURE_BEAN') or define('TEMPERATURE_BEAN', 'temperature');

$app->get('/temperatures(/:days)', function ($days=null) use ($app) {
	$days = empty($days)?356:$days;
	$sql = "SELECT * FROM temperature where date >= date('now', '-$days day') ORDER BY date desc";
    $items = R::getAll($sql);
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($items);
});

/*$app->get('/temperatures(/:day)', function ($day=null) use ($app) {
	$days = empty($days)?356:$days;
	$sql = "SELECT * FROM temperature where date >= date('now', '-$days day') ORDER BY date desc";
    $items = R::getAll($sql);
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($items);
});*/

$app->get('/dates', function () use ($app) {
    	
	$sql = "SELECT DISTINCT date(date) FROM temperature";
	$items = R::getCol($sql);
	$items[] = 'min';
	$items[] = 'max';
	$items[] = 'average';
	
    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($items);	
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