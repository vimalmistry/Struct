<?php

//http://www.imavex.com/php-pdo-wrapper-class/
abstract class Model {

    protected $db = null;
    private static $instance = NULL;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

//    protected static function getInstance()
//    {
//        if (!self::$instance)
//        {
//
//            $host = config('database.host');
////            $port = config('database.port');
//            $dbname = config('database.name');
//            $dbuser = config('database.user');
//            $dbpass = config('database.password');
//            self::$instance = new DB("mysql:host=" . $host . ";dbname=" . $dbname, $dbuser, $dbpass);
//
////            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        }
//        return self:: $instance;
//    }

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

            $exec = $this->db->prepare($query);
            $exec->execute($params);
        }
        catch (PDOException $e) {
//            dump(debug_backtrace());
            $called = debug_backtrace()[1];
            $text = 'File:' . $called['file'] . " LINE " . $called['line'] . "\n"
                . "Method:" . $called['class'] . '::' . $called['function'] . "\n";

            $error = 'Error:' . $e->getMessage();
            $msg = $text . $error;

            if ($this->error)
            {
                $this->onError($msg);
            }
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
        if (config('error.send_log'))
        {
            $num = config('error.send_log_mobile');
            $email = config('error.send_log_email');

            $notification = new Notify();
            $notification->sendSms($num, $text);
            $notification->sendMail($email, 'ERROR :: FollowUp', $text);
        }
    }

    public function __clone()
    {
        
    }

    public function __destruct()
    {
        $this->db = null;
    }

}
