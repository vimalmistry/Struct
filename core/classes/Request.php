<?php

class Request {

    public static function init()
    {
        //get initial
    }

    /**
     * 
     * @param mix $key
     * @return mix
     */
    public static function get($key = null)
    {
        if (is_null($key))
        {
            return filter_input_array(INPUT_GET);
        }
        return trim(filter_input(INPUT_POST, $key));
    }

    /**
     * 
     * @param mix $key
     * @return mix
     */
    public static function post($key = null)
    {
        if (is_null($key))
        {
            return filter_input_array(INPUT_POST);
        }
        return trim(filter_input(INPUT_POST, $key));
    }

    /**
     * 
     * @param mix $key
     * @return mix
     */
    public static function server($key = null)
    {
        if (is_null($key))
        {
            return filter_input_array(INPUT_SERVER);
        }
        return filter_input(INPUT_SERVER, $key);
    }

    /**
     * 
     * @param mix $key
     * @return mix
     */
    public static function cookie($key = null)
    {
        if (is_null($key))
        {
            return filter_input_array(INPUT_COOKIE);
        }

        return filter_input(INPUT_COOKIE, $key);
    }

    /**
     * 
     * @return string
     */
    public static function method()
    {
        return strtoupper(self::server('REQUEST_METHOD'));
    }

    /**
     * 
     * @return string
     */
    public static function url()
    {
        return self::server('REQUEST_URI');
    }

}
