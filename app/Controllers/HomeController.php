<?php

namespace App\Controllers;

use App\Models\User;

class HomeController extends \Controller {

    public function __construct()
    {
        parent::__construct();

        if (!\Auth::check())
        {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $user = \Auth::user();
        return view('index', ['user' => $user]);
    }

    public function work($name)
    {
        echo 'Works and name is ' . $name;
    }

}
