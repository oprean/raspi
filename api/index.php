<?php
require_once '../php/bootstrap.php';

R::setup( 'sqlite:'.ROOT_DIR.'/assets/data/quizzes.sqlite' );
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->config('debug', DEBUG_MODE);

require_once(ROOT_DIR.'/php/routes/results.php');
require_once(ROOT_DIR.'/php/routes/mail.php');
require_once(ROOT_DIR.'/php/routes/pdf.php');
require_once(ROOT_DIR.'/php/routes/info.php');

$app->run();
R::close();