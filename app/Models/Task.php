<?php

namespace App\Models;

class Task extends \Model {

    protected $table = 'tasks';
    protected $users = 'users';

//    public function rules() {
//        return 
//    }

    /**
     * Return all task
     * if id 0 than return all task other wise return one
     */
    public function getTask($id = 0)
    {
        if ($id == 0)
        {
            $data = $this->db->prepare("SELECT * FROM $this->table ORDER BY created_at DESC");
            $data->execute();
            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            $data = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
            $data->bindParam(':id', $id);
            $data->execute();
            return $data->fetch(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Return All task with all users join
     */
    public function getTaskWithUser($id = 0)
    {
        if ($id == 0)
        {
            $data = $this->db->prepare("SELECT * FROM $this->table");
            $data->execute();
            return $data->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            $data = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
            $data->bindParam(':id', $id);
            $data->execute();

            return $data->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getTaskWithLog($id = 0)
    {
        
    }

    public function getTaskWithUserLog($id = 0)
    {
        
    }

    /**
     * 
     * @param type $data
     */
    public function setNewTask($data)
    {

        //set an date and time to work with
        $now = dateNow();

//display the converted time
        $hours = $data['hours'];
        $next = date('Y-m-d H:i', strtotime("+{$hours} hour", strtotime($now)));



        $sql = "INSERT INTO $this->table(from_user,to_user,title,description,hours,created_at,status,next_reminder)";
        $sql.= "VALUES(:from_user,:to_user,:title,:description,:hours,'$now',:status,'$next')";

        $insert = $this->db->prepare($sql);

        $array = array(
                ':from_user' => $data['from_user'],
                ':to_user' => $data['to_user'],
                ':title' => $data['title'],
                ':description' => $data['description'],
                ':hours' => $data['hours'],
//            ':created_at' => $now,
                ':status' => 'enabled',
//            ':next_reminder' => $next//date("Y-m-d H:i:s", strtotime('+5 hours'))//"timestamp(DATE_ADD(NOW(), INTERVAL " . ($data['hours'] * 60) . " MINUTE))"
        );

        $done = $insert->execute($array);

        if ($done)
        {

            $taskID = $this->db->lastInsertId();
            $task = $this->getTask($taskID);
            $user = (new User())->getUser($task['to_user']);
            $notification = new Notify();
            $notification->sendSms($user['mobile'], 'New Task : ' . substr($task['title'], 0, 140));
            $notification->sendMail($user['email'], $task['title'], $task['description']);

            $now = date('Y-m-d H:i:s');
            $this->setLog($task['id'], $task['to_user'], $now);

            return $taskID;
        }
        return FALSE;
    }

    public function setLog($taskId, $userId, $time)
    {
        $insert = $this->db->query("INSERT INTO message_log(task_id,user_id,message_send_time)"
            . "values('$taskId','$userId','$time')");
        return $insert;
    }

    public function setEnable($id)
    {
        $task = $this->getTask($id);
        $now = date('Y-m-d H:i');
        $next = date('Y-m-d H:i', strtotime("+{$task['hours']} hour", strtotime($now)));
        $update = $this->db->prepare("UPDATE tasks SET status = 'enabled',next_reminder = '$next' WHERE id = :id ");
        return $update->execute([':id' => $id]);
    }

    public function setDesable($id)
    {
        $update = $this->db->prepare('UPDATE tasks SET status = "disabled" WHERE id = :id ');
        return $update->execute([':id' => $id]);
    }

    /**
     * 
     * @return type
     */
    public function getForRemind()
    {
        $now = date('Y-m-d H:i');
//        select data from between now()-30 and now()+30;
//        $now = dateNow();
//        $from = strtotime('+ 30 minute', $now);
//        $to = strtotime('- 30 minute', $now);
//        $get = $this->db->prepare("SELECT * from tasks WHERE next_reminder BETWEEN '$from' AND '$to'");
//        $get = $this->db->prepare("SELECT * FROM tasks WHERE (status='enabled') AND (next_reminder = '0000-00-00 00:00:00' OR next_reminder BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 30 MINUTE)) AND timestamp(DATE_ADD(NOW(), INTERVAL 30 MINUTE)))");
        $get = $this->db->prepare("SELECT * FROM tasks WHERE status='enabled' AND next_reminder = :now");

        $get->execute([':now' => $now]);
        return $get->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @param type $id
     * @param type $hours
     * @return type
     */
    public function setNextRemind($taskId, $hours)
    {
//        $num = ($hours * 60);

        $now = date('Y-m-d H:i');
        $next = date('Y-m-d H:i', strtotime("+{$hours} hour", strtotime($now)));

        $get = $this->db->prepare("UPDATE tasks SET next_reminder = '$next' WHERE id = :id ");

//        $get = $this->db->prepare("UPDATE tasks SET next_reminder = timestamp(DATE_ADD(NOW(), INTERVAL '$next' MINUTE))");
        return $get->execute([':id' => $taskId]);
    }

    public function getMessageLog()
    {
        $sql = "SELECT users.name,COUNT(message_log.user_id) AS sendMessage FROM users
                LEFT JOIN message_log
                ON users.id=message_log.user_id
                GROUP BY users.name;";
        $data = $this->db->query($sql);
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countMessage($taskID)
    {
        $m = new Task();
        $data = $m->db->query("SELECT COUNT(*) as total FROM message_log WHERE task_id ='$taskID' ");
        return $data->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getHistory($taskID)
    {
        $data = $this->db->query("SELECT * FROM message_log WHERE task_id = '$taskID' ORDER BY message_send_time DESC");
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

}
