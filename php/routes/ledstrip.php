<?php
$app->post('/ledstrip', function () use ($app) {
	$post = $app->request()->post();
	if (!empty($post['cmd'])) {
		switch ($post['cmd']) {
			case 'fill':
				$cmd = 'sudo python ../py/ledstrip.py '.$post['r'].' '.$post['g'].' '.$post['b'];				
				break;
			case 'rainbow':
				$cmd = 'sudo python ../py/led_rainbow.py';				
				break;
			default:
				$cmd = 'sudo python ../py/led_clock.py '.$post['t'];
				break;
		}

		exec($cmd,$output, $return);		
	}
});