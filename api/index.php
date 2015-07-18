<?php
require_once '../php/bootstrap.php';

R::setup( 'sqlite:'.ROOT_DIR.'/assets/data/raspi.sqlite' );
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->config('debug', DEBUG_MODE);

require_once(ROOT_DIR.'/php/routes/info.php');

$app->run();
R::close();