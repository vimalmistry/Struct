<?php

define('DS', DIRECTORY_SEPARATOR);

define('API_PATH', __DIR__);

define('LIB_PATH', __DIR__ . DS . 'libs');


require_once API_PATH . DS . 'vendor' . DS . 'autoload.php';

require_once LIB_PATH . DS . 'helpers.php';

require_once API_PATH . DS . 'call.php';

require_once LIB_PATH . DS . 'DB.php';
require_once LIB_PATH . DS . 'Auth-front.php';
//
//
//
//
//$handler = new Call();
//
//$handler->_setClass($_GET['c']);
//$handler->_setFunction($_GET['f']);
//$handler->_setParams($_POST);
//
//
//$data = $handler->run();
//
//if (forApi())
//{
//    echo json_encode($data);
//}
