<?php
require_once('../bootstrap.php');

define('CPU_TEMPERATURE', 0);

R::setup( 'sqlite:'.ROOT_DIR.'/data/raspi.sqlite' );

$temperature = new Command('temp');
$val = $temperature->response();
//$val = array('status' => 'success', 'response' => 50.00);

if ($val['status'] == 'success') {
	$item = R::dispense('teperature'); 
	$item->type = CPU_TEMPERATURE;
	$item->date = date('Y-m-d H:i:s');
	$item->value = $val['response'];
 
    R::store($item);		
} else {
	return $val['response'];
}
R::close();
?>