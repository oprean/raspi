<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(dirname(__FILE__)));
define('RUNTIME_DIR', ROOT_DIR.DS.'runtime'.DS);
define('VIEWS_DIR', ROOT_DIR.DS.'php/views'.DS);

require_once(ROOT_DIR.'/php/Slim/Slim.php');
require_once(ROOT_DIR.'/php/redbean/rb.php');
require_once(ROOT_DIR.'/php/config.php');

require_once(ROOT_DIR.'/php/components/user.php');
require_once(ROOT_DIR.'/php/components/auth.php');
require_once(ROOT_DIR.'/php/components/commands.php');
require_once(ROOT_DIR.'/php/components/gpio.php');
require_once(ROOT_DIR.'/php/components/Temperature.php');
require_once(ROOT_DIR.'/php/components/TemperatureSensor.php');
require_once(ROOT_DIR.'/php/components/espeak.php');

require_once(ROOT_DIR.'/php/models/Tile.php');

?>