<?php
$app->get('/tiles', function () use ($app) {
	$app->response()->header('Content-Type', 'application/json');
	echo json_encode(Tile::getList());
});
?>