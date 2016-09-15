<?php

/**
 * function ___getFileNameFromUrl() {
  // $route = (empty($_GET['rt'])) ? 'index' : $_GET['rt'];
  // //    if ($route == 'index.php') {
  // //        return PUBLIC_PATH . '/' . $route;
  // //    }
  //
  // $name = APP_PATH . '/Modules/' . $route;
  //
  //
  // $case1 = $name . '.php';
  // if (file_exists($case1)) {
  // return $case1;
  // }
  // $case2 = $name . '/index.php';
  // if (file_exists($case2)) {
  // return $case2;
  // }
  // return;
  // }
 */

/**
 * $filename = ___getFileNameFromUrl();


  //if file exist call

  if (file_exists($filename)) {
  require_once ($filename);
  exit();
  }

 */
class Router {

    protected $default_controller = 'home/index';

    /**
     * 
     * @param type $default_controller
     */
    public function setDefault($default_controller)
    {
        $this->default_controller = strtolower($default_controller);
    }

    /**
     * 
     * @return type
     */
    public function fetch()
    {
        $segments = $this->getArray();
//        dump($segments);
        if (count($segments) == 0)
        {
            $this->runDefault();
            return;
        }

        return $this->execute($segments);
    }

    /**
     * 
     * @return type
     */
    protected function getDefault()
    {
        return $this->default_controller;
    }

    /**
     * 
     * @param type $segments
     * @return type
     * @throws Exception
     */
    protected function execute($segments)
    {
        $index = 0;

        $isDir = false;
        $dirName = strtolower($segments[$index]);

        $possibleDirName = APP_PATH . 'Controllers/' . $dirName;

        if (is_dir($possibleDirName))
        {
            $index++;
            $isDir = true;
            if (!isset($segments[$index]))
            {
                throw new Exception('No Controller in Directory');
//                show404();
            }
        }

        $class = ucfirst($segments[$index]) . 'Controller';

        $index++;

        $function = isset($segments[$index]) ? $segments[$index] : 'index';

//        $fullClass = '\\App\\Controllers\\' . $class;

        $dir = $isDir == true ? "$dirName\\" : ''; //if dir than extend namespace

        $fullClass = "\\App\\Controllers\\$dir" . $class;

        $handler = new $fullClass();

        if (!method_exists($handler, $function))
        {
            throw new Exception('Method not found : ' . $function . ' in ' . $fullClass);
        }

        if (count($segments) > 2)
        {
            unset($segments[0]);
            unset($segments[1]);
            $output = call_user_func_array([$handler, $function], $segments);
            $this->finalOutput($output);
            return;
        }

        $output = $handler->{$function}();
        $this->finalOutput($output);
        return;
    }

    /**
     * 
     * @param type $output
     * @return type
     */
    protected function finalOutput($output)
    {
        if (is_array($output) or is_object($output))
        {
            header('Content-Type: application/json');
            echo json_encode($output);
            return;
        }

        echo $output;
        return;
    }

    /**
     * 
     */
    protected function runDefault()
    {
        $default = $this->getDefault();
        $this->execute(explode('/', $default));
    }

    /**
     * 
     * @return type
     */
    protected function getArray()
    {
        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];
        $a = explode('/', $route);
        $b = array_filter($a);
        return $b;
    }

}
