<?php
include('wiringpi.php');

$s1s = wiringpi::digitalRead(17);
$s2s = wiringpi::digitalRead(11); 

$status = array(
	array(
		'id' => 'socket1',
		'status' => $s1s
	),
	array(
		'id' => 'socket2',
		'status' => $s2s
	)
);

echo json_encode($status);
?>