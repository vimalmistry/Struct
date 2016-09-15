<?php

class Session {

    /**
     * 
     * Start the session
     * 
     * @return bool
     */
    public static function start() {

        return session_start();
    }

    public static function delete($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * 
     * @param mix $key
     * @param mix $value
     * @return bool
     */
    public static function set($key, $value) {
        return $_SESSION[$key] = $value;
    }

    /**
     * 
     * @param mix $key
     * @return mix
     */
    public static function get($key = null) {
        if (is_null($key)) {
            return (object) $_SESSION;
        }

        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * 
     * @return obj
     */
    public static function all() {
        return self::get();
    }

}
