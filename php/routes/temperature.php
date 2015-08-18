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


$app->get('/temperature/last/:type', function ($type = ROOM_TEMPERATURE) use ($app) {
    	
    $item = R::findOne(TEMPERATURE_BEAN, ' WHERE type= ? ORDER BY date DESC LIMIT 1', array($type));
    if ($item) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($item->export());
    } else {
        $app->response()->status(503);
    }	
});

$app->get('/temperature/now/:type', function ($type = ROOM_TEMPERATURE) use ($app) {
	$value = null;
	
	try {
		if ($type == ROOM_TEMPERATURE) {
			$tempSensor = new TemperatureSensor();
			$value = $tempSensor->getValue('c');				
		} else {
			$oCmd = new Command();
			$response = $oCmd->response('temp');
			$value = ($response['status'] == 'success')
				?$response['response']
				:null;
		}			
	} catch (Exception $e) {}	

    if ($value !== null) {
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode(array(
        	'type' => $type,
        	'value' => $value,
        	'date' => date('Y-m-d H:i:s')
		));
    } else {
        $app->response()->status(503);
    }	
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