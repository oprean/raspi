<?php
require_once('../bootstrap.php');

defined('CPU_TEMPERATURE') or define('CPU_TEMPERATURE', 0);
defined('ROOM_TEMPERATURE') or define('ROOM_TEMPERATURE', 1);

R::setup( 'sqlite:'.ROOT_DIR.'/data/raspi.sqlite' );

$temperature = new Command('tempsensor');
$val = $temperature->response();
//$val = array('status' => 'success', 'response' => 38.00);

if ($val['status'] == 'success') {
	$item = R::dispense('temperature'); 
	$item->type = ROOM_TEMPERATURE;
	$item->date = date('Y-m-d H:i:s');
	$item->value = $val['response'];
 	if (floatval($item->value) > 28 || floatval($item->value) <= 19) {
 		Utils::pushalot('In camera: '. $item->value.' C ('.date('Y-m-d H:i:s').')');
 	}
    R::store($item);		
} else {
	return $val['response'];
}

R::close();
?>