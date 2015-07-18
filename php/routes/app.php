<?php
$app->get('/', function () use ($app) {
	$file = DEBUG_MODE?'index.view.debug.php':'index.view.php';
	 $template = file_get_contents(VIEWS_DIR.$file);
	 echo $template;
});
$app->get('/results/:id', function ($id) use ($app) {
	$result = R::findOne('results', 'result_id=?', [$id]);
	echo $result->html;
});
?>