<?php
require_once '../php/bootstrap.php';
$tempSensor = new TemperatureSensor();
echo $tempSensor->read()
?>