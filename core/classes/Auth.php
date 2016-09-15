<?php

use App\Models\User;

class Auth {

    protected static $user = null;

    /**
     * Check user logged or not
     * 
     * @return boolean
     */
    public static function check()
    {
        if (isset($_SESSION['user_id']))
        {
            return true;
        }

        return FALSE;
    }

    /**
     * Get the user as array
     */
    public static function user()
    {
        $id = \Session::get('user_id');
        if (self::$user == null)
        {
            $user = new User();
            self::$user = $user->get($id);
        }
        return (object) self::$user;
    }

    /**
     *  Log to User In
     * @param string $email
     * @param string $password
     * @param bool $remember
     * @return array
     */
    public static function login($email, $password, $remember = FALSE)
    {
        $user = new User();
        $data = $user->getByEmail($email);
        $auth = new Self;
        if ($data && $auth->checkPass($password, $data['password']))
        {
            \Session::set('user_id', $data['id']);
            return [
                    'status' => true,
                    'message' => 'Login Successful'
            ];
        }
        return [
                'status' => false,
                'message' => 'Login Fail. Incorrect email or password'
        ];
    }

    /**
     * Log the User Out
     */
    public static function logout()
    {
        \Session::delete('user_id');
    }

    /**
     * Compare the password 
     * 
     * @param string $newPass
     * @param string $dbPass
     * @return bool
     */
    protected function checkPass($newPass, $dbPass)
    {
        return $newPass == $dbPass;
    }

}
