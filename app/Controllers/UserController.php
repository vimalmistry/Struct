<?php

namespace App\Controllers;

use Controller;

class UserController extends Controller {

    public function index()
    {

        return config('smsapi.key');
    }

    public function update($id)
    {
        return 'update for' . $id;
    }

}
