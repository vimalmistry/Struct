<?php

class Call {

    protected $className;
    protected $function;
    protected $params = [];
    protected $file = null;

    //

    /**
     * 
     * @param type $directory
     * @param type $excludePath
     */
    public function __construct()
    {
        
    }

    /**
     * c=users/access
     * 
     * 
     * @param type $class
     */
    public function _setClass($class)
    {
        $class = str_replace('/', DS, $class);

        $this->file = API_PATH . DS . 'controllers' . DS . $class . '.php';

        $a = explode(DS, $class);
        $this->className = end($a);
    }

    /**
     * 
     * @param type $function
     */
    public function _setFunction($function)
    {
        $this->function = $function;
    }

    /**
     * 
     * @param type $params
     */
    public function _setParams($params)
    {
        $this->params = [$params];
    }

    public function run()
    {
        require_once $this->file;
        return call_user_func_array([new $this->className, $this->function], $this->params);
    }

}
