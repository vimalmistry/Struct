<?php

class DB extends PDO {
    /*     * * Declare instance ** */

    private static $instance = NULL;

    /**
     *
     * the constructor is set to private so
     * so nobody can create a new instance using new
     *
     */
    public function __construct()
    {
        /*         * * maybe set the db name here later ** */
//        $host = 'localhost';
//        $username = 'namastej_dbuser';
//        $password = '';
//        $database = ',TE.BD*#sxih';
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'booth';
        parent::__construct("mysql:host=" . $host . ";dbname=" . $database . ";", $username, $password);
    }

    /**
     *
     * Return DB instance or create intitial connection
     *
     * @return object (PDO)
     *
     * @access public
     *
     */
    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self; //PDO("mysql:host=" . $host . ";dbname=" . $database . ";", $username, $password);

            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        return self:: $instance;
    }

    /**
     *
     * Like the constructor, we make __clone private
     * so nobody can clone the instance
     *
     */
    private function __clone()
    {
        
    }

    /**
     * Simple Wrapper for run query if error than inform in log and sms email
     * 
     * @param  $query
     * @param  $params
     * @return all
     */
    public function run($query, $params = [])
    {
        try {
//            $this->db->exec($query);

            $exec = self::$instance->prepare($query);
            $exec->execute($params);
        }
        catch (PDOException $e) {
//            dump(debug_backtrace());
//            $called = debug_backtrace()[1];
//            $text = 'File:' . $called['file'] . " LINE " . $called['line'] . "\n"
//                . "Method:" . $called['class'] . '::' . $called['function'] . "\n";

            $error = 'Error:' . $e->getMessage();
//            $msg = $text . $error;
            $this->onError($error);
        }
        return $exec;
    }

    /**
     * 
     * @param type $text
     */
    protected function onError($text)
    {

        error_log(date('Y-m-d H:i:s') . "\n" . $text . "\n\n", 3, "./query-exec.log");
//        if (config('error.send_log'))
//        {
//            $num = config('error.send_log_mobile');
//            $email = config('error.send_log_email');
//
//            $notification = new Notify();
//            $notification->sendSms($num, $text);
//            $notification->sendMail($email, 'ERROR :: FollowUp', $text);
//        }
    }

}

/* * * end of class ** */

