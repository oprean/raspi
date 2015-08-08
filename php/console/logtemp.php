<?php
require_once('../bootstrap.php');

define('CPU_TEMPERATURE', 0);
define('ROOM_TEMPERATURE', 1);

R::setup( 'sqlite:'.ROOT_DIR.'/data/raspi.sqlite' );

$temperature = new Command('tempsensor');
$val = $temperature->response();
//$val = array('status' => 'success', 'response' => 28.00);

if ($val['status'] == 'success') {
	$item = R::dispense('temperature'); 
	$item->type = ROOM_TEMPERATURE;
	$item->date = date('Y-m-d H:i:s');
	$item->value = $val['response'];
 
    R::store($item);		
} else {
	return $val['response'];
}
R::close();
?>