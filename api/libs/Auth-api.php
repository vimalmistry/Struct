<?php
/**
 * For API only
 */
class Auth {

    protected static $access_key = null;
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
        return (bool) self::$login;
    }

    //
    public static function init($access_key = null)
    {
        if (is_null($access_key))
        {
            return;
        }
        //
        self::$access_key = $access_key;
        //
        if (!empty(Auth::user()))
        {
            self::setLogin(true);
        }
    }

    public static function getAccessKey()
    {
        return self::$access_key;
    }

    //
    public static function setLogin($bool)
    {
        self::$login = (bool) $bool;
    }

    /**
     * 
     * @return type
     */
    public static function user()
    {
        if (empty(self::$user))
        {
            $user = DB::getInstance()->run('SELECT * FROM login WHERE access_key=:id', [':id'=> self::$access_key]);
            if ($user)
            {
                self::$user = $user->fetch();
            }
        }

        return self::$user;
    }

}
