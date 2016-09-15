<?php

$starttime = microtime(true);


session_name('vX6jDklnFIKlhnzDsduihg');
session_start();

date_default_timezone_set('Asia/Calcutta');


/* * * error reporting on ** */
error_reporting(E_ALL);

/* * * define the site path ** */
$site_path = realpath(dirname(__FILE__));

//DIRECTORY_SEPARATOR
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

$site_path = str_replace(DIRECTORY_SEPARATOR . 'www', '', FCPATH);

define('ROOT', $site_path);
define('APP_PATH', ROOT . 'app/');
define('PUBLIC_PATH', ROOT . 'www/');


//define('SYSTEM_PATH', APP_PATH . 'System');
define('CORE_PATH', ROOT . 'core');

//define('PATH', 'http://' . $_SERVER['HTTP_HOST'] . '/followup');

define('VIEW_PATH', APP_PATH . 'views/');

/**
 * Load Composer AutoLoader
 */
require_once ROOT . 'vendor/autoload.php';


require_once ROOT . 'core/handle.php';