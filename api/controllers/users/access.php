<?php

/**
 * Description of User
 *
 * @author admin
 */
use werx\Validation\Engine as Validator;

class access {

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    public function login($params)
    {
        $r['status'] = false;


        if (Auth::check())
        {
            $r['status'] = true;
            $r['message'] = 'You are already logged';
            return $r;
        }


        $v = new Validator();
        $v->addRule('username', 'User Name', 'required');
        $v->addRule('password', 'Password', 'required');

        $valid = $v->validate($params);
        if (!$valid)
        {
            $r['errors'] = $v->getErrorSummary();
            return $r;
        }



        $email = $params['username'];
        $password = md5($params['password']);

        $data = $this->db->run("SELECT * FROM login where username = '$email' AND password='$password' LIMIT 1");


        if ($data->rowCount() > 0)
        {

            $r['status'] = true;
            if (forApi())
            {
                $access_key = $this->genAccessKey($data->fetch()['id']);
                $r['access_key'] = $access_key;
            }
            return $r;
        }

        $r['message'] = 'No user Found';
        return $r;
    }

    /**
     * 
     * @param type $params
     */
    public function register($params)
    {
        $r['status'] = false;

        $v = new Validator();
        $v->addRule('name', 'User Name', 'required');
        $v->addRule('mobile', 'Mobile', 'required');
        $v->addRule('email', 'Email', 'required|email');
        $v->addRule('password', 'Password', 'required');

        $valid = $v->validate($params);
        if (!$valid)
        {
            $r['errors'] = $v->getErrorSummary();
            return $r;
        }

        $err = [];

        if ($this->emailExist($params['email']))
        {
            $err[] = 'Email Already Used';
            $r['error'] = $err;
            return $r;
        }

        if ($this->mobileExist($params['mobile']))
        {
            $err[] = 'Mobile Already Used';
            $r['error'] = $err;
            return $r;
        }

        $name = $params['name'];
        $mobile = $params['mobile'];
        $email = $params['email'];
        $password = md5($params['password']);

        $query = "INSERT INTO customer_details(customer_name,email,mobile,password)"
            . "VALUES(:name,:email,:mobile,:password)";

        $bind = [
                ':name' => $name,
                ':email' => $email,
                ':mobile' => $mobile,
                ':password' => $params['password']
        ];

        $success = $this->db->run($query, $bind);
        if ($success)
        {
            $lastID = $this->db->lastInsertId();

            $query = "INSERT INTO login(username,mobile,password,user_id,user_type)"
                . "VALUES(:username,:mobile,:password,:user_id,:user_type)";
            $bind = [
                    ':username' => $name,
                    ':mobile' => $mobile,
                    ':password' => $password,
                    ':user_id' => $lastID,
                    ':user_type' => 9
            ];

            $done = $this->db->run($query, $bind);
            if ($done)
            {
                $r['status'] = true;
                $r['message'] = "Successfully registered";
                return $r;
            }
        }
        $r['error'] = 'Something Wrong please try again.';
        return $r;
    }

    /**
     * 
     * @param type $mobile
     * @return boolean
     */
    protected function emailExist($email)
    {
        $sql = "SELECT * FROM customer_details where email='$email'";
        $response = $this->db->run($sql);
        if ($response->rowCount() > 0)
        {
            return true;
        }
        return false;
    }

    protected function mobileExist($mobile)
    {
        $sql = "SELECT * FROM customer_details where mobile='$mobile'";
        $response = $this->db->run($sql);
        if ($response->rowCount() > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * 
     * 
     * @param type $userid
     * @return boolean
     */
    protected function genAccessKey($userid)
    {
        $access_key = md5(uniqid($userid, true));

        $done = $this->db->run('UPDATE login SET access_key= :key WHERE id=:id', [':key' => $access_key, ':id' => $userid]);

        if ($done)
        {
            return $access_key;
        }

        return FALSE;
    }

}
