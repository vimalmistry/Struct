<?php

namespace App\Controllers;

use Controller;
use Auth;
use Request;
use Validator;

class AuthController extends Controller {

    public function __construct()
    {
        
    }

    /**
     * Login
     * @return html
     */
    public function login()
    {

        if (Auth::check())
        {
            redirect();
        }

        $error = FALSE;

        if (Request::post())
        {
            $validator = new Validator();
            $validator->addRule('email', 'Email', 'required|email');
            $validator->addRule('password', 'Password', 'required');

            $valid = $validator->validate(Request::post());

            if (!$valid)
            {
                $error = $validator->getErrorSummary();
            }
            else
            {
                $email = Request::post('email');
                $password = Request::post('password');
                $login = Auth::login($email, $password);
                if ($login['status'])
                {
                    redirect();
                }
                $error[] = $login['message'];
            }
        }

        return view('auth.login', ['error' => $error]);
    }

    /**
     * /auth/logout
     * LogOut
     */
    public function logout()
    {
        if (Auth::check())
        {
            Auth::logout();
        }
        redirect();
    }

}
