<?php
define('RED', 7);
define('BLUE', 11);
define('GREEN', 14);

define('ON', 'on');
define('OFF', 'off');
define('RESET', 'reset');

$leds = array( 'Red' => RED, 'Blue' => BLUE, 'Green' => GREEN );

if (!empty($_GET)) {
	$led = isset($_GET['led'])?$_GET['led']:'';
	$action = isset($_GET['action'])?$_GET['action']:'';
	$cmd = 'sudo python ../led3.py '.$led.' '.$action;
	exec($cmd);
}
?>