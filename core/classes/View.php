<?php

class View {

    protected $master = null;

    public function __construct($master = null) {
        if (!is_null($master)) {
            $this->master = $master;
        }
    }

    /**
     * 
     * @param type $template
     * @param type $data
     * @return type
     */
    public function make($template, $data = []) {

        $content = null;
        try {
            $file = VIEW_PATH . str_replace('.', DIRECTORY_SEPARATOR, $template) . '.php';

            if (file_exists($file)) {

                if (!empty($data)) {
                    extract($data);
                }

                if (is_file($file)) {
                    ob_start();
                    include $file;
                    $con = ob_get_clean();
                }
            } else {
//                throw new customException('Template ' . $template . ' not found!');
                echo('Template ' . $template . ' not found!<br/> File Name is : '.$file);
            }
        } catch (customException $e) {
            echo $e->errorMessage();
        }
        return $con;
    }

    /**
     * 
     * @param type $master
     * @return types
     */
    public function setMaster($master) {
        return $this->master = $master;
    }

    /**
     * 
     * @param type $template
     * @param type $data
     * @return type
     */
    public function render($template, $data = []) {
//        $view = new View();
        if ($this->master !== null) {
            $data['content'] = $this->make($template, $data);
            return $this->make($this->master, $data);
        }

        return $this->make($template, $data);
    }

}
