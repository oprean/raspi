<?php
require_once('../bootstrap.php');
$tempSensor = new TemperatureSensor();
echo $tempSensor->read()
?>