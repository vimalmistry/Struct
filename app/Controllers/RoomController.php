<?php

namespace App\Controllers;

class RoomController extends \Controller {

    public function index_get()
    {
        //
    }

    public function index_put()
    {
        //
    }

    public function add_post()
    {
        //
    }

    public function city($arg)
    {

        return 'city and' . $arg;
    }

    public function index()
    {
        return 'index';
    }

    public function create()
    {
        return 'create';
    }

    public function update($id)
    {
        return 'update .' . $id;
    }


//    public function __call($name, $arguments) {
//        if ($name == 'area') {
//            $fun = $arguments[0];
//            if (method_exists($this, $fun)) {
//
//                unset($arguments[0]);
//                $arg = $arguments;
//                if (empty($arg)) {
//                    $this->$fun();
//                } else {
//                    call_user_func_array($this->$fun, $arg);
//                }
//            }
//        }
//    }
}
