<?php

define('DS', DIRECTORY_SEPARATOR);

define('API_PATH', __DIR__);

define('LIB_PATH', __DIR__ . DS . 'libs');


require_once API_PATH . DS . 'vendor' . DS . 'autoload.php';

require_once LIB_PATH . DS . 'helpers.php';

require_once API_PATH . DS . 'call.php';

require_once LIB_PATH . DS . 'DB.php';
require_once LIB_PATH . DS . 'Auth-api.php';



//
//
//$exclude = [
//        LIB_PATH,
//        API_PATH . DS . 'vendor'
//];
//
//
//
//$directory = API_PATH . DS;







if ($_POST)
{

    Auth::init(isset($_GET['access_key']) ? $_GET['access_key'] : null);

    $handler = new Call();
    $handler->_setClass($_GET['c']);
    $handler->_setFunction($_GET['f']);
    $handler->_setParams($_POST);




    if (forApi())
    {
        $data = $handler->run();
        toJson($data);
    }
    else
    {
        toJson(['success' => false, 'message' => 'call should be from mobile']);
    }
}
else
{
    toJson(['success' => false, 'message' => 'request method must be post']);
}