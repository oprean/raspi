<?php
require_once '../php/bootstrap.php';

R::setup( 'sqlite:'.ROOT_DIR.'/data/raspi.sqlite' );
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->config('debug', DEBUG_MODE);

require_once(ROOT_DIR.'/php/routes/command.php');
require_once(ROOT_DIR.'/php/routes/gpio.php');
require_once(ROOT_DIR.'/php/routes/temperature.php');
require_once(ROOT_DIR.'/php/routes/tts.php');
require_once(ROOT_DIR.'/php/routes/test.php');

$app->run();
R::close();