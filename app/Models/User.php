<?php

namespace App\Models;

class User extends \Model {

    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = 0)
    {

        if ($id != 0)
        {
            $users = $this->run('SELECT * FROM users WHERE id=:id', [':id' => $id]);

            if ($users)
            {
                return $users->fetch(\PDO::FETCH_ASSOC);
            }
        }
        else
        {
            $users = $this->run('SELECT * FROM users');
            return $users;
        }
    }

    public function getByEmail($email)
    {
        //first result
        //write full query
        $result = $this->run("SELECT * FROM users WHERE email=:email", [':email' => $email]);

        if ($result)
        {
            return $result->fetch(\PDO::FETCH_ASSOC);
        }
        return FALSE;
    }

}
