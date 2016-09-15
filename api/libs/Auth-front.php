<?php

/**
 * For API only
 */
class Auth {

//    protected static $access_key = null;
    //
    protected static $user = [];
    //
    protected static $login = false;

    /**
     * 
     * @return type
     */
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

//    //
//    public static function init($access_key = null)
//    {
//        if (is_null($access_key))
//        {
//            return;
//        }
//        //
//        self::$access_key = $access_key;
//        //
//        if (!empty(Auth::user()))
//        {
//            self::setLogin(true);
//        }
//    }
//    public static function getAccessKey()
//    {
//        return self::$access_key;
//    }
//    //
//    public static function setLogin($bool)
//    {
//        self::$login = (bool) $bool;
//    }

    /**
     * 
     * @return type
     */
    public static function user()
    {
        if (empty(self::$user))
        {
            $user = DB::getInstance()->run('SELECT * FROM login WHERE id=:id', [':id' => $_SESSION['user_id']]);
            if ($user)
            {
                self::$user = $user->fetch();
            }
        }

        return self::$user;
    }

}
