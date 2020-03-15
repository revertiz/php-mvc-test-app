<?php
require __DIR__ . '/../vendor/autoload.php';

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'src' . DIRECTORY_SEPARATOR);
define('VIEW', ROOT . 'src' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
define('MODEL', ROOT . 'src' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR);
define('CONTROLLER', ROOT . 'src' . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR);
define('DATA', ROOT . 'src' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);
define('CORE', ROOT . 'src' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR);

//$modules = [ROOT,APP,CORE,CONTROLLER,DATA];
//set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));

new \Kodas\Core\Application();

