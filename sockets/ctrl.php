<?php 
$status = array(
	array(
		'id' => 'socket1',
		'status' => 'on'
	),
	array(
		'id' => 'socket2',
		'status' => 'off'
	)
);

echo json_encode($status);
?>