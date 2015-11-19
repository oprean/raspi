<?php
$app->post('/ledstrip', function () use ($app) {
	$post = $app->request()->post();
	if (!empty($post['cmd'])) {
		$cmd = 'sudo python ../py/ledstrip.py '.$post['r'].' '.$post['g'].' '.$post['b'];
		exec($cmd,$output, $return);		
	}
});