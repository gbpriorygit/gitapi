<?php

class Model
{

    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
////////////////////////////////////////////////////////////////////
//                  administrator
//////////////////////////////////////////////////////////////////

    public function getUser($user_id){
        $sql="SELECT * FROM users WHERE user_id=:user_id";
        $query=$this->db->prepare($sql);
        $query->execute(array(':user_id' => $user_id));
        return $query->fetch();
    }

    public function getCallLog(){
      $sql="SELECT * FROM call_log order by calltime desc limit 200";
      $query=$this->db->prepare($sql);
      $query->execute();
      return $query->fetchAll();
    }


    public function editEvent($event_id){
	    $sql="UPDATE events SET content=:content,start=:start,seen=0,status='Pending' where event_id=:event_id limit 1";
	    $query=$this->db->prepare($sql);
	    $query->execute(array('event_id'=>$event_id,'content'=>$_POST['content'],'start'=>date("Y-m-d H:i:s", strtotime($_POST['start']))));
    }
    public function getEventsAdmin($lead_id){
        $sql='SELECT events.*,users.first_name,users.last_name FROM events LEFT JOIN users ON users.user_id = events.user_id where events.lead_id=:lead_id  order by events.event_id desc limit 3';
        $query = $this->db->prepare($sql);
        $query->execute(array(':lead_id'=>$lead_id));
        return $query->fetchAll();
    }

    public function getEvents($lead_id){
	    $sql='SELECT events.*,users.first_name,users.last_name FROM events LEFT JOIN users ON users.user_id = events.user_id where events.lead_id=:lead_id and events.user_id=:user_id order by events.event_id desc limit 3';
	    $query = $this->db->prepare($sql);
	    $query->execute(array(':lead_id'=>$lead_id,':user_id'=>$_SESSION['user_id']));
	    return $query->fetchAll();
	}


      public function getReminders($lead_id){
          $sql='SELECT reminders.*,users.first_name,users.last_name FROM reminders LEFT JOIN users ON users.user_id = reminders.user_id where reminders.lead_id=:lead_id  order by reminders.reminder_id desc limit 3';
          $query = $this->db->prepare($sql);
          $query->execute(array(':lead_id'=>$lead_id));
          return $query->fetchAll();
      }

      public function editReminder($reminder_id){
        $sql="UPDATE reminders SET content=:content,start=:start,seen=0,status='Pending' where reminder_id=:reminder_id limit 1";
        $query=$this->db->prepare($sql);
        $query->execute(array('reminder_id'=>$reminder_id,'content'=>$_POST['content'],'start'=>date("Y-m-d H:i:s", strtotime($_POST['start']))));
      }

      public function setSeenReminder($event_id){
        $sql="UPDATE reminders set seen=1 where reminder_id=:reminder_id";
        $query=$this->db->prepare($sql);
        $query->execute(array('reminder_id'=>$event_id));
      }

      public function addReminder($lead_id){
          $sql="INSERT INTO reminders(title,content,start,user_id,lead_id,description,color) VALUES(:title,:content,:start,:user_id,:lead_id,'',:color)";
          $query = $this->db->prepare($sql);
          $parameters=array(
                        ':title' => $_POST['title'],
                        ':content' => $_POST['content'],
                        ':start' => date("Y-m-d H:i:s", strtotime($_POST['start'])),
                        ':lead_id' => $_POST['lead_id'],
                        ':user_id' => $_SESSION['user_id'],
                        ':color'  => $_POST['color']
                          );
          if($query->execute($parameters)){
            //new task log
              if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                  $ip = $_SERVER['HTTP_CLIENT_IP'];
              } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
              } else {
                  $ip = $_SERVER['REMOTE_ADDR'];
              }

          //log cheanges
              $sql="INSERT INTO log(user_id,lead_id,diff,ip) VALUES(:user_id,:lead_id,:diff,:ip)";
              $query=$this->db->prepare($sql);
              $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
              $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
              $query->bindValue(':diff',"New Reminder : ".$_POST['content']." | ".$_POST['start']);
              $query->bindParam(':ip', $ip);
              $query->execute();

              $_SESSION['addTask']='success';
          } else {
              $_SESSION['addTask']='fail';
          }
        //  print_r($_POST['start']);
        header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
      }



	public function getAllEvents(){
        $sql='SELECT events.*,users.first_name,users.last_name FROM events LEFT JOIN users ON users.user_id = events.user_id where events.user_id=:user_id and  MONTH(`start`) = MONTH(CURRENT_DATE()) AND YEAR(`start`) = YEAR(CURRENT_DATE())  order by `event_id` desc limit 15';
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_id'=>$_SESSION['user_id']));
        return $query->fetchAll();
    }

    public function getLastEvents($lead_id){
        $sql='SELECT * FROM events  where lead_id=:lead_id and user_id=:user_id  order by event_id desc limit 1';
        $query = $this->db->prepare($sql);
        $query->execute(array(':lead_id'=>$lead_id,':user_id'=>$_SESSION['user_id']));
        $start=$query->fetch();
        if (isset($start->start)) {
            return "Event: ".date('d-m-Y   H:i',strtotime($start->start));
        }
    }

    public function addEvent($lead_id){
            $sql="INSERT INTO events(title,content,start,user_id,lead_id,description,color) VALUES(:title,:content,:start,:user_id,:lead_id,'',:color)";
            $query = $this->db->prepare($sql);
            $parameters=array(
                          ':title' => $_POST['title'],
                          ':content' => $_POST['content'],
                          ':start' => date("Y-m-d H:i:s", strtotime($_POST['start'])),
                          ':lead_id' => $_POST['lead_id'],
                          ':user_id' => $_SESSION['user_id'],
                          ':color'  => $_POST['color']
                            );
            if($query->execute($parameters)){
              //new task log
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
            //log cheanges
                $sql="INSERT INTO log(user_id,lead_id,diff,ip) VALUES(:user_id,:lead_id,:diff,:ip)";
                $query=$this->db->prepare($sql);
                $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
                $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
                $query->bindValue(':diff',"New Event : ".$_POST['content']." | ".$_POST['start']);
                $query->bindParam(':ip', $ip);
                $query->execute();
                $_SESSION['addTask']='success';
            } else {
                $_SESSION['addTask']='fail';
            }
          //  print_r($_POST['start']);
          header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
        }

       public function setSeenEvent($event_id){
	      $sql="UPDATE events set seen=1 where event_id=:event_id";
	      $query=$this->db->prepare($sql);
	      $query->execute(array('event_id'=>$event_id));
	    }

    public function getDocuments($user_id){
    	$sql="SELECT * FROM documents WHERE `user_id`=:user_id ORDER BY document_id DESC";
    	$query=$this->db->prepare($sql);
    	$query->execute(array(':user_id' =>$user_id));
    	$documents=$query->fetchAll();
        //header('Content-type: application/json');
        //echo json_encode($documents);
        return $documents;
    }

    public function countByur($user_id){
        $sql='SELECT count(lead_id) as c FROM leads where assigned_to like :user_id';
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_id'=>$user_id));
        $c=$query->fetch();
        return $c->c;
    }

    public function getUserImage($user_id){
        $sql="SELECT image FROM users WHERE user_id=:user_id";
        $query=$this->db->prepare($sql);
        $query->execute(array(':user_id' => $user_id));
        return $query->fetch();
    }

    public function getUncheckedLeads(){
        $sql="SELECT * FROM leads WHERE checked='false'";
        $query=$this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getUsers(){
        $sql="SELECT * FROM users  order by first_name asc";
        $query=$this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getInactiveUsers(){
        $sql="SELECT * FROM users where active='no' order by first_name asc";
        $query=$this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getUsersByRole($role){
        $sql="SELECT * FROM users where role = :role  order by first_name asc";
        $query=$this->db->prepare($sql);
        $query->execute(array(':role' =>$role));
        return $query->fetchAll();
    }

    public function getUsersRecycle($role){
        $sql="SELECT * FROM users where role = :role and recycle=1  order by first_name asc";
        $query=$this->db->prepare($sql);
        $query->execute(array(':role' =>$role));
        return $query->fetchAll();
    }

    public function getUsersByRoleAll($role){
        $sql="SELECT * FROM users where role = :role  order by first_name asc";
        $query=$this->db->prepare($sql);
        $query->execute(array(':role' =>$role));
        return $query->fetchAll();
    }

    public function uploadImage($user_id){
      print_r($_POST);
      print_r($_FILES);
      $file = file_get_contents($_FILES["image"]["tmp_name"]);
      $query = "UPDATE users set image=:image where user_id=:user_id";
      $query = $this->db->prepare($query);
      $query->execute(array(':image' => $file,':user_id' => $user_id));
      header("location:".URL.$_SESSION['role'].'/editUser/'.$user_id);
    }

    public function addEvolution($lead_id){
        $sql="INSERT INTO evolutions(content,user_id,lead_id) VALUES(:content,:user_id,:lead_id)";
        $query = $this->db->prepare($sql);
        $parameters=array(
                      ':content' => $_POST['content'],
                      ':lead_id' => $_POST['lead_id'],
                      ':user_id' => $_SESSION['user_id'],
                        );
        if($query->execute($parameters)){
          //new task log
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            //log cheanges
            $sql="INSERT INTO log(user_id,lead_id,diff,ip) VALUES(:user_id,:lead_id,:diff,:ip)";
            $query=$this->db->prepare($sql);
            $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
            $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
            $query->bindValue(':diff',"New Evolution : ".$_POST['content']);
            $query->bindParam(':ip', $ip);
            $query->execute();
            $_SESSION['addNote']='success';
        } else {
            $_SESSION['addNote']='fail';
        }
      //  print_r($_POST['start']);
      header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
    }

    public function getUsersBySupervisor($supervisor){
        $sql="SELECT * FROM users where role='operator' AND supervisor = :supervisor  order by first_name asc";
        $query=$this->db->prepare($sql);
        $query->execute(array(':supervisor' =>$supervisor));
        return $query->fetchAll();
    }
    public function getSupervisorByOperator($user_id){
        $sql="SELECT * FROM users where user_id= :user_id LIMIT 1";
        $query=$this->db->prepare($sql);
        $query->execute(array(':user_id' =>$user_id));
        $supervisor=$query->fetch();
        if ($supervisor) {
            return $supervisor->first_name.' '.$supervisor->last_name;
        }else{
            return '';
        }
    }

    public function createUser(){
        if ($_POST['username']=='' || $_POST['password']=='' || $_POST['first_name']=='' || $_POST['last_name']=='') {
            $_SESSION['create_user']='fail';
            header("location:".URL.$_SESSION['role'].'/users');
            return;
        }
        $sql="SELECT user_id  FROM users WHERE username=:username";
        $query = $this->db->prepare($sql);
        $query->execute(array(':username' => $_POST['username']));

        if ($query->rowCount()>0) {
            $_SESSION['create_user']='fail';
            header("location:".URL.$_SESSION['role'].'/users');
            return;
        }
        if (!isset($_POST['supervisor'])) {
            $supervisor=0;
        }else{
            $supervisor=$_POST['supervisor'];
        }
        $sql="INSERT INTO users(username,password,first_name,last_name,role,supervisor,recycle) VALUES (:username,:password,:first_name,:last_name,:role,:supervisor,:recycle)";
        $query = $this->db->prepare($sql);
        $parameters=array(':username' => $_POST['username'],
                      ':password' => $_POST['password'],
                      ':first_name' => $_POST['first_name'],
                      ':last_name' => $_POST['last_name'],
                      ':role' => $_POST['role'],
                      ':recycle' => $_POST['recycle'],
                      ':supervisor' => $supervisor,
                        );
        if($query->execute($parameters)){
            $_SESSION['create_user']='success';
        } else {
            $_SESSION['create_user']='fail';
        }
        header("location:".URL.$_SESSION['role'].'/users');
    }

    public function editUser($user_id){
        if ($_POST['username']=='' || $_POST['password']=='' || $_POST['first_name']=='' || $_POST['last_name']=='') {
            $_SESSION['create_user']='fail';
            header("location:".URL.$_SESSION['role'].'/users');
            return;
        }
        if (!isset($_POST['supervisor'])) {
            $supervisor=0;
        }else{
            $supervisor=$_POST['supervisor'];
        }
        $sql="UPDATE users SET username=:username,password=:password,first_name=:first_name,last_name=:last_name,role=:role,recycle=:recycle WHERE user_id=:user_id";
        $query = $this->db->prepare($sql);
        $parameters=array(':username' => $_POST['username'],
                      ':password' => $_POST['password'],
                      ':first_name' => $_POST['first_name'],
                      ':last_name' => $_POST['last_name'],
                      ':role' => $_POST['role'],
                      ':recycle' => $_POST['recycle'],
                      ':user_id' => $user_id
                        );
        if($query->execute($parameters)){
            $_SESSION['edit_user']='success';
        } else {
            $_SESSION['edit_user']='fail';
        }
        header("location:".URL.$_SESSION['role'].'/users');
    }

    public function deleteUser($user_id){
        $sql="DELETE FROM users WHERE user_id=:user_id";
        $query = $this->db->prepare($sql);
        if($query->execute(array(':user_id' => $user_id))){
            $_SESSION['delete_user']='success';
        } else {
            $_SESSION['delete_user']='fail';
        }
        header("location:".URL.$_SESSION['role'].'/users');
    }

    public function getContractsByUser($user_id ){
        $page=(int)(isset($_GET['page'])? $_GET['page']:0);
        $limiter=100;
        $pager=$limiter*$page;
        $sql='SELECT * FROM contracts WHERE operator=:user_id LIMIT :pager, :limiter ';
        $query = $this->db->prepare($sql);
        $query->bindParam(':pager', $pager, PDO::PARAM_INT);
        $query->bindParam(':limiter', $limiter, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }
    public function getContractsBySupervisor($supervisor_id){
        $page=(int)(isset($_GET['page'])? $_GET['page']:0);
        $limiter=100;
        $pager=$limiter*$page;
        $sql='SELECT * FROM contracts WHERE supervisor=:supervisor LIMIT :pager, :limiter ';
        $query = $this->db->prepare($sql);
        $query->bindParam(':pager', $pager, PDO::PARAM_INT);
        $query->bindParam(':limiter', $limiter, PDO::PARAM_INT);
        $query->bindParam(':supervisor', $supervisor, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

    public function getLeadById($lead_id ){
      $sql='SELECT leads.*,users.first_name as afn,users.last_name as aln ,status.status_name FROM leads
                LEFT JOIN users ON users.user_id = leads.assigned_to
                LEFT JOIN status ON status.status_id = leads.status
                WHERE lead_id=:lead_id ';
        $query = $this->db->prepare($sql);
        $query->execute(array(':lead_id'=>$lead_id));
        return $query->fetch();
    }
///////////////////////////////////////////////////////////////////
    public function getStatuses(){
        $sql='SELECT * FROM status order by orderby asc';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function getStatusById($id){
        $sql='SELECT * FROM status where status_id=:id limit 1';
        $query = $this->db->prepare($sql);
        $query->execute(array(':id'=>$id));
        return $query->fetchAll();
    }

    public function getSources(){
        $sql='SELECT DISTINCT source FROM leads';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAssignedFroms(){
        $sql='SELECT DISTINCT assigned_from FROM leads';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function countBy($user_id='%',$status_id='%',$source_id='%',$assigned_from='%'){
      //////////////////user////////////////////////
      //print_r($assigned_from);
     if ($user_id!='%') {
       if (is_array($user_id)) {
          if ($user_id[0]!='%') {
            $user_ids=array();
            foreach ($user_id as $value) {
              array_push($user_ids,$value);
            }
            $user_ids1=implode(',', array_map('intval', $user_ids));
            $user_ids1='in('.$user_ids1.')';
          }else{
            $user_ids1="like '%'";
          }
        }else{
          $user_ids1="like ".$user_id;
        }
      }else{
        $user_ids1="like '%'";
      }
      //////////////////user////////////////////////
        //////////////////status////////////////////////
       if ($status_id!='%') {
         if (is_array($status_id)) {
            if ($status_id[0]!='%') {
              $status_ids=array();
              foreach ($status_id as $value) {
                array_push($status_ids,$value);
              }
              $status_ids1=implode(',', array_map('intval', $status_ids));
              $status_ids1='in('.$status_ids1.')';
            }else{
              $status_ids1="like '%'";
            }
          }else{
            $status_ids1="like ".$status_id;
          }
        }else{
          $status_ids1="like '%'";
        }
        //////////////////status////////////////////////
        //////////////////source////////////////////////
       if ($source_id!='%') {
         if (is_array($source_id)) {
            if ($source_id[0]!='%') {
              $source_ids=array();
              foreach ($source_id as $value) {
                array_push($source_ids,$value);
              }
              $source_ids1=implode('","',$source_ids);
              $source_ids1='in("'.$source_ids1.'")';
              //print_r($source_ids1);
            }else{
              $source_ids1="like '%'";
            }
          }else{
            $source_ids1="like '%".$source_id."%'";
          }
        }else{
          $source_ids1="like '%'";
        }
        //////////////////status////////////////////////

        ///////////////////assigned_from/////////////////////
        if ($assigned_from!='%') {
          if (is_array($assigned_from)) {
             if ($assigned_from[0]!='%') {
               $assigned_froms=array();
               foreach ($assigned_from as $value) {
                 array_push($assigned_froms,$value);
               }
               $assigned_froms1=implode('","',$assigned_froms);
               $assigned_froms1='in("'.$assigned_froms1.'")';
               //print_r($assigned_froms1);
             }else{
               $assigned_froms1="like '%'";
             }
           }else{
             $assigned_froms1="like '%".$assigned_from."%'";
           }
         }else{
           $assigned_froms1="like '%'";
         }

        $sql='SELECT count(lead_id) as c FROM leads
                LEFT JOIN users  ON users.user_id = leads.assigned_to
                where (users.recycle =0 OR leads.assigned_to=0) and source '.$source_ids1.' and status '.$status_ids1.' and assigned_to '.$user_ids1.' and assigned_from '.$assigned_froms1;///
                //print_r($sql);
        $query = $this->db->prepare($sql);
        $query->execute();
        $c=$query->fetch();

        //print_r($user_id.$status_id.$source);
        return $c->c;
    }

    public function countByR($user_id='%',$status_id='%',$source_id='%'){
      //////////////////user////////////////////////
     if ($user_id!='%') {
       if (is_array($user_id)) {
          if ($user_id[0]!='%') {
            $user_ids=array();
            foreach ($user_id as $value) {
              array_push($user_ids,$value);
            }
            $user_ids1=implode(',', array_map('intval', $user_ids));
            $user_ids1='in('.$user_ids1.')';
          }else{
            $user_ids1="like '%'";
          }
        }else{
          $user_ids1="like ".$user_id;
        }
      }else{
        $user_ids1="like '%'";
      }
      //////////////////user////////////////////////
        //////////////////status////////////////////////
       if ($status_id!='%') {
         if (is_array($status_id)) {
            if ($status_id[0]!='%') {
              $status_ids=array();
              foreach ($status_id as $value) {
                array_push($status_ids,$value);
              }
              $status_ids1=implode(',', array_map('intval', $status_ids));
              $status_ids1='in('.$status_ids1.')';
            }else{
              $status_ids1="like '%'";
            }
          }else{
            $status_ids1="like ".$status_id;
          }
        }else{
          $status_ids1="like '%'";
        }
        //////////////////status////////////////////////
        //////////////////source////////////////////////
       if ($source_id!='%') {
         if (is_array($source_id)) {
            if ($source_id[0]!='%') {
              $source_ids=array();
              foreach ($source_id as $value) {
                array_push($source_ids,$value);
              }
              $source_ids1=implode('","',$source_ids);
              $source_ids1='in("'.$source_ids1.'")';
              //print_r($source_ids1);
            }else{
              $source_ids1="like '%'";
            }
          }else{
            $source_ids1="like '%".$source_id."%'";
          }
        }else{
          $source_ids1="like '%'";
        }
        //////////////////status////////////////////////

        $sql='SELECT count(lead_id) as c FROM leads
                LEFT JOIN users  ON users.user_id = leads.assigned_to
                where users.recycle =1 and source '.$source_ids1.' and status '.$status_ids1.' and assigned_to '.$user_ids1;
        $query = $this->db->prepare($sql);
        $query->execute();
        $c=$query->fetch();

        //print_r($user_id.$status_id.$source);
        return $c->c;
    }

    public function countBySource($user_id='%',$status_id='%',$source='%'){
        $sql='SELECT count(lead_id) as c FROM leads where source like :source and status like :status_id and assigned_to like :user_id';
        $query = $this->db->prepare($sql);
        $query->execute(array(':source'=>$source,':status_id'=>$status_id,':user_id'=>$user_id));
        $c=$query->fetch();
        return $c->c;
    }

    public function countByUser($user_id='%',$status_id='%',$source='%'){
        $sql='SELECT count(lead_id) as c FROM leads where source like :source and status like :status_id and assigned_to like :user_id';
        $query = $this->db->prepare($sql);
        $query->execute(array(':source'=>$source,':status_id'=>$status_id,':user_id'=>$user_id));
        $c=$query->fetch();
        return $c->c;
    }

      public function countByStatus($status_id='%'){
          $sql='SELECT count(lead_id) as c FROM leads where  status like :status_id';
          $query = $this->db->prepare($sql);
          $query->execute(array(':status_id'=>$status_id));
          $c=$query->fetch();
          return $c->c;
      }

    public function getNotesAdmin($lead_id){
        $sql='SELECT notes.*,users.first_name,users.last_name FROM notes LEFT JOIN users ON users.user_id = notes.user_id where notes.lead_id=:lead_id  order by `note_id` desc';
        $query = $this->db->prepare($sql);
        $query->execute(array(':lead_id'=>$lead_id));
        return $query->fetchAll();
    }
    public function getEvolutions($lead_id){
        $sql='SELECT evolutions.*,users.first_name,users.last_name FROM evolutions LEFT JOIN users ON users.user_id = evolutions.user_id where evolutions.lead_id=:lead_id  order by `evolution_id` desc';
        $query = $this->db->prepare($sql);
        $query->execute(array(':lead_id'=>$lead_id));
        return $query->fetchAll();
    }
    public function getTasksAdmin($lead_id){
        $sql='SELECT tasks.*,users.first_name,users.last_name FROM tasks LEFT JOIN users ON users.user_id = tasks.user_id where tasks.lead_id=:lead_id  order by tasks.task_id desc limit 3';
        $query = $this->db->prepare($sql);
        $query->execute(array(':lead_id'=>$lead_id));
        return $query->fetchAll();
    }
    public function getLastTasksAdmin($lead_id){
        $sql='SELECT * FROM tasks  where lead_id=:lead_id  order by task_id desc limit 1';
        $query = $this->db->prepare($sql);
        $query->execute(array(':lead_id'=>$lead_id));
        $start=$query->fetch();
        if (isset($start->start)) {
            return "Task: ".date('d-m-Y   H:i',strtotime($start->start));
        }

    }
    public function getAllTasksAdmin(){
        $sql='SELECT tasks.*,users.first_name,users.last_name FROM tasks LEFT JOIN users ON users.user_id = tasks.user_id where  MONTH(`start`) = MONTH(CURRENT_DATE()) AND YEAR(`start`) = YEAR(CURRENT_DATE())  order by `task_id` desc limit 30';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function addNote($lead_id){
        $sql="INSERT INTO notes(content,user_id,lead_id) VALUES(:content,:user_id,:lead_id)";
        $query = $this->db->prepare($sql);
        $parameters=array(
                      ':content' => $_POST['content'],
                      ':lead_id' => $_POST['lead_id'],
                      ':user_id' => $_SESSION['user_id'],
                        );
        if($query->execute($parameters)){
          //new task log

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            //log cheanges
            $sql="INSERT INTO log(user_id,lead_id,diff,ip) VALUES(:user_id,:lead_id,:diff,:ip)";
            $query=$this->db->prepare($sql);
            $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
            $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
            $query->bindValue(':diff',"New Comment : ".$_POST['content']);
            $query->bindParam(':ip', $ip);
            $query->execute();

            $_SESSION['addNote']='success';
        } else {
            $_SESSION['addNote']='fail';
        }
      //  print_r($_POST['start']);
      header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
    }

    public function createStatus(){
        $sql="SELECT status_id  FROM status WHERE status_name=:status_name";
        $query = $this->db->prepare($sql);
        $query->execute(array(':status_name' => $_POST['status_name']));

        if ($query->rowCount()>0) {
            $_SESSION['create_status']='fail';
            header("location:".URL.$_SESSION['role'].'/statuses');
            return;
        }

        if ($_POST['status_name']=='') {
            $_SESSION['create_status']='fail';
            header("location:".URL.$_SESSION['role'].'/statuses');
            return;
        }
        $sql="INSERT INTO status(status_name,status_description) VALUES (:status_name,:status_description)";
        $query = $this->db->prepare($sql);
        $parameters=array(
                      ':status_name' => $_POST['status_name'],
                      ':status_description' => $_POST['status_description'],
                        );
        if($query->execute($parameters)){
            $_SESSION['create_status']='success';
        } else {
            $_SESSION['create_status']='fail';
        }
        header("location:".URL.$_SESSION['role'].'/statuses');
    }

    public function editTask($task_id){
      $sql="UPDATE tasks SET content=:content,start=:start,seen=0,status='Pending' where task_id=:task_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('task_id'=>$task_id,'content'=>$_POST['content'],'start'=>date("Y-m-d H:i:s", strtotime($_POST['start']))));
    }

    public function editStatus($status_id){
        $sql="UPDATE status SET status_name=:status_name,status_description=:status_description WHERE status_id=:status_id";
        $query = $this->db->prepare($sql);
        $parameters=array(
                      ':status_name' => $_POST['status_name'],
                      ':status_description' => $_POST['status_description'],
                      ':status_id' => $status_id
                        );
        if($query->execute($parameters)){
            $_SESSION['edit_status']='success';
        } else {
            $_SESSION['edit_status']='fail';
        }
        header("Location:".URL.$_SESSION['role'].'/statuses');
    }

    public function getStatus($status_id){
        $sql="SELECT * FROM status WHERE status_id=:status_id";
        $query=$this->db->prepare($sql);
        $query->execute(array(':status_id' => $status_id));
        return $query->fetch();
    }

    public function getNotes($lead_id){
        $sql='SELECT notes.*,users.first_name,users.last_name FROM notes LEFT JOIN users ON users.user_id = notes.user_id where notes.lead_id=:lead_id  order by `note_id` desc';
        $query = $this->db->prepare($sql);
        $query->execute(array(':lead_id'=>$lead_id));
        return $query->fetchAll();
    }

//////////////////////////////////////////////////////////////////////
    public function createList(){
        $sql="SELECT list_id  FROM lists WHERE list_name=:list_name";
        $query = $this->db->prepare($sql);
        $query->execute(array(':list_name' => $_POST['list_name']));

        if ($query->rowCount()>0) {
            $_SESSION['list_status']='fail';
            header("location:".URL.$_SESSION['role'].'/lists');
            return;
        }
        if ($_POST['list_name']=='') {
            $_SESSION['list_status']='fail';
            header("location:".URL.$_SESSION['role'].'/lists');
            return;
        }
        $sql="INSERT INTO lists (list_name,source,list_description) VALUES (:list_name,:source,:list_description)";
        $query = $this->db->prepare($sql);
        $parameters=array(
                      ':list_name' => $_POST['list_name'],
                      ':source' => $_POST['source'],
                      ':list_description' => $_POST['list_description']
                        );
        if($query->execute($parameters)){
            $_SESSION['create_list']='success';
        } else {
            $_SESSION['create_list']='fail';
        }
        header("location:".URL.$_SESSION['role'].'/lists');
    }

    public function editCampaign($list_id){
        $sql="UPDATE campaigns SET list_name=:campaign_name,campaign_description=:campaign_description WHERE campaign_id=:campaign_id";
        $query = $this->db->prepare($sql);
        $parameters=array(
                      ':campaign_name' => $_POST['campaign_name'],
                      ':campaign_description' => $_POST['campaign_description'],
                      ':campaign_id' => $campaign_id
                        );
        if($query->execute($parameters)){
            $_SESSION['edit_campaign']='success';
        } else {
            $_SESSION['edit_campaign']='fail';
        }
        header("Location:".URL.$_SESSION['role'].'/campaigns');
    }

    public function getList($list_id){
        $sql="SELECT * FROM lists WHERE list_id=:list_id";
        $query=$this->db->prepare($sql);
        $query->execute(array(':list_id' => $list_id));
        return $query->fetch();
    }

    public function countList($list_id){
        $sql="SELECT count(lead_id) as total FROM leads WHERE list_id=:list_id";
        $query=$this->db->prepare($sql);
        $query->execute(array(':list_id' => $list_id));
        $r=$query->fetch();
        return $r->total;
    }

    public function deleteList($list_id){
        $sql="DELETE FROM lists WHERE list_id=:list_id";
        $query = $this->db->prepare($sql);
        if($query->execute(array(':list_id' => $list_id))){
            $sql="SELECT lead_id FROM leads WHERE list_id=:list_id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':list_id' => $list_id));
            $leads=$query->fetchAll();
            foreach ($leads as $lead) {
              $sql="DELETE FROM notes WHERE lead_id=:lead_id";
              $query = $this->db->prepare($sql);
              $query->execute(array(':lead_id' => $lead->lead_id));

              $sql="DELETE FROM tasks WHERE lead_id=:lead_id";
              $query = $this->db->prepare($sql);
              $query->execute(array(':lead_id' => $lead->lead_id));

              $sql="DELETE FROM `log` WHERE lead_id=:lead_id";
              $query = $this->db->prepare($sql);
              $query->execute(array(':lead_id' => $lead->lead_id));
            }
            $sql="DELETE FROM leads WHERE list_id=:list_id";
            $query = $this->db->prepare($sql);
            $query->execute(array(':list_id' => $list_id));

            $_SESSION['delete_list']='success';
        } else {
            $_SESSION['delete_list']='fail';
        }
        header("location:".URL.$_SESSION['role'].'/lists');
    }

    public function getLists(){
        $sql='SELECT * FROM lists order by list_id desc';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function uploadLeads($list_id,$source){


      if (isset($_POST["import"])) {

          $fileName = $_FILES["file"]["tmp_name"];

          if ($_FILES["file"]["size"] > 0) {

              $file = fopen($fileName, "r");

              $header=array();
              $values=array();

              foreach ($_POST as $key => $value) {
                if ($value!="" && $value!="empty") {
                  array_push($header,$key);
                  array_push($values,$value);
                }
              }
              // $_POST['phone_number']=trim($_POST['phone_number']);
              if ($_POST['first_name']=="" || $_POST['phone_number']=="" || count($header)<2 ) {
                    echo "At least First Name and Phone Number required!";
                return;
              }

              function build_sql_insert($table, $header,$values,$column,$list_id,$source) {
                  $key = array_values($header);
                  $val = array_values($values);
                  $col=  array_values($column);
                  $sql = "INSERT INTO $table (" . implode(', ', $key) . ",list_id,source) ";
                       //. "VALUES ('" . implode("', '", $col[$val]) . "')";

                  $sql.="VALUES(";
                  foreach ($values as $k=> $v) {
                    if ($key[$k]=="status") {
                      $sql.='"'.$_POST['status'].'",';
                    }elseif ($key[$k]=="assigned_to") {
                      $sql.='"'.$_POST['assigned_to'].'",';
                    }else{
                      $sql.='"'.$column[$v].'",';
                    }

                  }
                  //$sql=rtrim($sql, ",");
                  $sql.=$list_id.",'".$source."')";

                  return($sql);
              }

              //print_r($_POST);
              while (($column = fgetcsv($file, 50000, ",")) !== FALSE) {
                $twoNumbers = substr($column[$_POST['phone_number']], 0, 2);
                  $phoneNr=$column[$_POST['phone_number']];
                  if ($twoNumbers==='39'){
                      $check_sql="SELECT count(lead_id) as total FROM leads WHERE phone_number=:phone_number";
                  }
                  else{
                      if (!is_numeric($twoNumbers))
                      {
                          $check_sql="SELECT count(lead_id) as total FROM leads WHERE phone_number=:phone_number";
                      }
                      else {
                          $fullNr = '39' . $phoneNr;
                          $check_sql = "SELECT count(lead_id) as total FROM leads WHERE phone_number='$fullNr'";
                      }
                  }
                  $check_query = $this->db->prepare($check_sql);
                  $check_query->execute(array(':phone_number' => $column[$_POST['phone_number']]));
                  $check=$check_query->fetch();

                if ($check->total<1) {
                  $sql=build_sql_insert("leads",$header,$values,$column,$list_id,$source);

                   $query = $this->db->prepare($sql);
                   if ($query->execute()) {
                     $_SESSION['import_list']="success";
                   }else {
                     $_SESSION['import_list']="fail";
                   }
                }



             header("location:".URL.$_SESSION['role'].'/lists');


                  //$sqlInsert = "INSERT into users (first_name,last_name,phone_number,email,country)
                         //values ('" . $column[$_POST["first_name"]] . "','" . $column[$_POST["last_name"]] . "','" . $column[$_POST["phone_number"]] . "','" . $column[$_POST["email"]] . "','" . $column[$_POST["country"]] . "')";
                  //  $result = mysqli_query($conn, $sqlInsert);
                  // if (! empty($result)) {
                  //     $type = "success";
                  //     $message = "CSV Data Imported into the Database";
                  // } else {
                  //     $type = "error";
                  //     $message = "Problem in Importing CSV Data";
                  // }
              }
          }
      }
    }



    public function getChangelog($lead_id){
        $sql='SELECT * FROM log WHERE lead_id=:lead_id  ORDER BY id DESC';
        $query = $this->db->prepare($sql);
        $query->bindParam(':lead_id', $lead_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllChangelog(){
        $sql='SELECT * FROM log  ORDER BY id DESC limit 50';
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


////////////////////////////////////////////////////
    public function getWorkhours($user_id,$date=null){
        if (!$date) {
           $date=date('Y-m');
        }
        $date.='-01';
        $sql = "SELECT SUM(hours) as totalhours FROM workhours where `workhours`.user_id='$user_id' and MONTH(`workhours`.`date`) =MONTH('$date') and YEAR(`workhours`.`date`) =YEAR('$date')";
        $query = $this->db->prepare($sql);
        $query->execute();
        $workhours=$query->fetch();
        $workhours=$workhours->totalhours;
        if (!$workhours) {
            $workhours=0;
        }
        return $workhours;
    }

    public function getContractsNumber($user_id,$date=null){
        if (!$date) {
           $date=date('Y-m');
        }
        $date.='-01';
        $sql = "SELECT COUNT(contract_id) as totalContracts FROM contracts where `contracts`.contract_type!='dual' AND `contracts`.operator='$user_id' and MONTH(`contracts`.`date`) =MONTH('$date') and YEAR(`contracts`.`date`) =YEAR('$date')";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contractsNumber=$query->fetch();
        $contractsNumber=$contractsNumber->totalContracts;

        $sql = "SELECT COUNT(contract_id) as totalContracts FROM contracts where `contracts`.contract_type='dual' AND `contracts`.operator='$user_id' and MONTH(`contracts`.`date`) =MONTH('$date') and YEAR(`contracts`.`date`) =YEAR('$date')";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contractsNumberDual=$query->fetch();
        $contractsNumberDual=(int)$contractsNumberDual->totalContracts*2;

        $contractsNumber+=$contractsNumberDual;
        if (!$contractsNumber) {
            $contractsNumber=0;
        }
        return $contractsNumber;
    }

    public function getContractsNumberOkInserito($user_id,$date=null){
        if (!$date) {
           $date=date('Y-m');
        }
        $date.='-01';

       $sql = "SELECT COUNT(contract_id) as totalContracts FROM contracts where `contracts`.contract_type!='dual' AND `contracts`.operator='$user_id' and MONTH(`contracts`.`date`) =MONTH('$date') and YEAR(`contracts`.`date`) =YEAR('$date') and (`contracts`.status=2 OR `contracts`.status=4) ";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contractsNumber=$query->fetch();
        $contractsNumber=$contractsNumber->totalContracts;

        $sql = "SELECT COUNT(contract_id) as totalContracts FROM contracts where `contracts`.contract_type='dual' AND `contracts`.operator='$user_id' and MONTH(`contracts`.`date`) =MONTH('$date') and YEAR(`contracts`.`date`) =YEAR('$date') and (`contracts`.status=2 OR `contracts`.status=4) ";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contractsNumberDual=$query->fetch();
        $contractsNumberDual=(int)$contractsNumberDual->totalContracts*2;

        $contractsNumber+=$contractsNumberDual;
        if (!$contractsNumber) {
            $contractsNumber=0;
        }
        return $contractsNumber;
    }

    public function getContractsNumberSupervisor($user_id,$date=null){
        if (!$date) {
           $date=date('Y-m');
        }
        $date.='-01';
        $sql = "SELECT COUNT(contract_id) as totalContracts FROM contracts where `contracts`.contract_type!='dual' AND `contracts`.supervisor='$user_id' and MONTH(`contracts`.`date`) =MONTH('$date') and YEAR(`contracts`.`date`) =YEAR('$date')";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contractsNumber=$query->fetch();
        $contractsNumber=$contractsNumber->totalContracts;

        $sql = "SELECT COUNT(contract_id) as totalContracts FROM contracts where `contracts`.contract_type='dual' AND `contracts`.supervisor='$user_id' and MONTH(`contracts`.`date`) =MONTH('$date') and YEAR(`contracts`.`date`) =YEAR('$date')";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contractsNumberDual=$query->fetch();
        $contractsNumberDual=(int)$contractsNumberDual->totalContracts*2;

        $contractsNumber+=$contractsNumberDual;
        if (!$contractsNumber) {
            $contractsNumber=0;
        }
        return $contractsNumber;
    }

    public function getContractsNumberOkInseritoSupervisor($user_id,$date=null){
        if (!$date) {
           $date=date('Y-m');
        }
        $date.='-01';

       $sql = "SELECT COUNT(contract_id) as totalContracts FROM contracts where `contracts`.contract_type!='dual' AND `contracts`.supervisor='$user_id' and MONTH(`contracts`.`date`) =MONTH('$date') and YEAR(`contracts`.`date`) =YEAR('$date') and (`contracts`.status=2 OR `contracts`.status=4) ";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contractsNumber=$query->fetch();
        $contractsNumber=$contractsNumber->totalContracts;

        $sql = "SELECT COUNT(contract_id) as totalContracts FROM contracts where `contracts`.contract_type='dual' AND `contracts`.supervisor='$user_id' and MONTH(`contracts`.`date`) =MONTH('$date') and YEAR(`contracts`.`date`) =YEAR('$date') and (`contracts`.status=2 OR `contracts`.status=4) ";
        $query = $this->db->prepare($sql);
        $query->execute();
        $contractsNumberDual=$query->fetch();
        $contractsNumberDual=(int)$contractsNumberDual->totalContracts*2;

        $contractsNumber+=$contractsNumberDual;
        if (!$contractsNumber) {
            $contractsNumber=0;
        }
        return $contractsNumber;
    }

    public function getActivity(){
        $vars=array();
        $vars['page']           = (int)(isset($_REQUEST['page'])? $_REQUEST['page']:0);
        $vars['user']    = (isset($_REQUEST['user'])?$_REQUEST['user']:'%');
        $vars['lead']    = (isset($_REQUEST['lead'])?$_REQUEST['lead']:'%');
        $vars['limiter']    = 100;
        $vars['pager']      = (int)$vars['limiter']*(int)$vars['page'];

        $sql='SELECT * FROM log where lead_id like :lead_id and user_id like :user_id ORDER BY id DESC  LIMIT :pager , :limiter';
        $query = $this->db->prepare($sql);
        $query->bindParam(':user_id', $vars['user']);
        $query->bindParam(':lead_id', $vars['lead']);
        $query->bindParam(':pager', $vars['pager'], PDO::PARAM_INT);
        $query->bindParam(':limiter', $vars['limiter'], PDO::PARAM_INT);
        $query->execute();

        $sql='SELECT * FROM log where lead_id like :lead_id and user_id like :user_id ORDER BY id DESC ';
        $query_count = $this->db->prepare($sql);
        $query_count->bindParam(':user_id', $vars['user']);
        $query_count->bindParam(':lead_id', $vars['lead']);
        $query_count->execute();

        //$query->debugDumpParams();
        $activity=$query->fetchAll(PDO::FETCH_ASSOC);
        $allpages=$query_count->rowCount();
        //print_r($allpages);
        $output=array();
        array_push($output,$allpages);
        array_push($output,$activity);
        //print_r($leads);
        return $output;
    }

    public function getLeads($export=null){
            if (isset($_REQUEST['search_'])) {
              if ($_REQUEST['search_']=='') {
                unset($_REQUEST['search_']);
              }
            }

            $vars=array();
            if (!isset($_REQUEST['search_'])) {//if filter
              //full_name
              //phone_number
              //email
              //status
              //source
              //brand
              //assigned_to
                $vars['full_name']          = (isset($_REQUEST['full_name'])?$_REQUEST['full_name']:'%');
                $vars['first_name']     = explode(" ",$vars['full_name'])[0].'%';
                $vars['last_name']      = substr(strstr($vars['full_name']," "), 1).'%';
                $vars['phone_number']   = (isset($_REQUEST['phone_number'])?$_REQUEST['phone_number']:'%');
                $vars['email']          = (isset($_REQUEST['email'])?$_REQUEST['email']:'%');
                $vars['status']    = (isset($_REQUEST['status'])?$_REQUEST['status']:'%');
                $vars['source']    = (isset($_REQUEST['source'])?$_REQUEST['source']:'%');
                $vars['brand']    = (isset($_REQUEST['brand'])?$_REQUEST['brand']:'%');
                $vars['assigned_to']    = (isset($_REQUEST['assigned_to'])?$_REQUEST['assigned_to']:'%');
                $vars['date_created']    = (isset($_REQUEST['date_created'])?$_REQUEST['date_created']:'%');
                $vars['last_change']    = (isset($_REQUEST['last_change'])?$_REQUEST['last_change']:'%');
                $vars['note']    = (isset($_REQUEST['note'])?$_REQUEST['note']:'%');
                $vars['lasttask']    = (isset($_REQUEST['lasttask'])?$_REQUEST['lasttask']:'%');
                $vars['assigned_from']    = (isset($_REQUEST['assigned_from'])?$_REQUEST['assigned_from']:'%');
                $vars['level']          = (isset($_REQUEST['level'])?$_REQUEST['level']:'%');
                $vars['mental']          = (isset($_REQUEST['mental'])?$_REQUEST['mental']:'%');

                if ($vars['date_created']=='%' || $vars['date_created']=='') {
                  $vars['date_created']='1970-01-01 - '.date("Y-m-d");
                }
                $reg=explode(' - ',$vars['date_created']);
                $vars['date_created_min']=date("Y-m-d", strtotime($reg[0]));
                $vars['date_created_max']=date("Y-m-d", strtotime($reg[1]));
                //print_r($vars);

                if ($vars['last_change']=='%' || $vars['last_change']=='') {
                  $vars['last_change']='1970-01-01 - '.date("Y-m-d");
                }
                $reg=explode(' - ',$vars['last_change']);
                $vars['last_change_min']=date("Y-m-d", strtotime($reg[0]));
                $vars['last_change_max']=date("Y-m-d", strtotime($reg[1]));

                if ($vars['lasttask']=='%' || $vars['lasttask']=='') {
                  $vars['lasttask']='1970-01-01 - 2025-01-01';
                  $vars['lasttask']='%';
                }else{
                 $reg=explode(' - ',$vars['lasttask']);
                 $vars['lasttask_min']=date("Y-m-d", strtotime($reg[0]));
                 $vars['lasttask_max']=date("Y-m-d", strtotime($reg[1]));
               }

                $note=$vars['note'];
            }else{//if search
              $vars['search_']           = (isset($_REQUEST['search_'])?$_REQUEST['search_']:'%');
              $vars['first_name']     = explode(" ",$vars['search_'])[0].'%';
              $vars['last_name']      = substr(strstr($vars['search_']," "), 1).'%';
              $vars['status']    = (isset($_REQUEST['status'])?$_REQUEST['status']:'%');
              $vars['source']    = (isset($_REQUEST['source'])?$_REQUEST['source']:'%');
              $vars['assigned_to']    = (isset($_REQUEST['assigned_to'])?$_REQUEST['assigned_to']:'%');
            }
            $vars['list_id']    = (isset($_REQUEST['list_id'])?$_REQUEST['list_id']:'%');
            $vars['page']           = (int)(isset($_REQUEST['page'])? $_REQUEST['page']:0);
            $vars['orderby']    = (isset($_REQUEST['orderby'])?$_REQUEST['orderby']:'lead_id');
            $vars['orderdir']    = (isset($_REQUEST['orderdir'])?$_REQUEST['orderdir']:'DESC');



            //$vars['assigned_to']=(isset($_REQUEST['assigned_to'])?$_REQUEST['assigned_to']:'%');
            //if var empty convert to %

            foreach ($vars as $h => $v) {
                if ($v=='') {
                    $vars[$h]='%';
                }
            }

//print_r($_REQUEST['search_']);
//if (!isset($_REQUEST['search_'])) {//if filter
  //echo "filter";
////////////////////////////////////////////////////////
            if ($vars['status']!='%') {
              if ($vars['status'][0]!='%') {
                  $status_ids=array();
                  foreach ($vars['status'] as $value) {
                    array_push($status_ids,$value);
                  }
                  $status_ids1=implode(',', array_map('intval', $status_ids));
                  $status_ids1='in('.$status_ids1.')';
              }else{
                  $status_ids1="like '%'";
              }
            }else{
              $status_ids1="like '%'";
            }

////////////////////////////////////////////////////////
            if ($vars['assigned_to']!='%') {
                if ($vars['assigned_to'][0]!='%') {
                    $assigned_to_ids=array();
                    foreach ($vars['assigned_to'] as $value) {
                      array_push($assigned_to_ids,$value);
                    }
                    $assigned_to_ids1=implode(',', array_map('intval', $assigned_to_ids));
                    $assigned_to_ids1='in('.$assigned_to_ids1.')';
                }else{
                  $assigned_to_ids1="like '%'";
                }
            }else{
              $assigned_to_ids1="like '%'";
            }
            /////////////////////////////////////////////////////////
                      if ($vars['level']!='%') {
                        if (is_array($vars['level'])) {
                            if ($vars['level'][0]!='%') {
                                $level_ids=array();
                                foreach ($vars['level'] as $value) {
                                  array_push($level_ids,$value);
                                }
                                $level_ids1=implode("','",$level_ids);
                                $level_ids1="in('".$level_ids1."')";
                                //print_r($level_ids1);
                            }else{
                              $level_ids1="like '%'";
                            }
                        }else{
                          $level_ids1="like '%".$vars['level']."%'";
                        }
                      }else{
                        $level_ids1="like '%'";
                      }
            //////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
          if ($vars['source']!='%') {
            if (is_array($vars['source'])) {
                if ($vars['source'][0]!='%') {
                    $source_ids=array();
                    foreach ($vars['source'] as $value) {
                      array_push($source_ids,$value);
                    }
                    $source_ids1=implode("','",$source_ids);
                    $source_ids1="in('".$source_ids1."')";
                    //print_r($source_ids1);
                }else{
                  $source_ids1="like '%'";
                }
            }else{
              $source_ids1="like '%".$vars['source']."%'";
            }
          }else{
            $source_ids1="like '%'";
          }
          //print_r($source_ids1);
//////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
          if ($vars['assigned_from']!='%') {
            if (is_array($vars['assigned_from'])) {
                if ($vars['assigned_from'][0]!='%') {
                    $assigned_from_ids=array();
                    foreach ($vars['assigned_from'] as $value) {
                      array_push($assigned_from_ids,$value);
                    }
                    $assigned_from_ids1=implode("','",$assigned_from_ids);
                    $assigned_from_ids1="in('".$assigned_from_ids1."')";
                    //print_r($assigned_from_ids1);
                }else{
                  $assigned_from_ids1="like '%'";
                }
            }else{
              $assigned_from_ids1="like '%".$vars['assigned_from']."%'";
            }
          }else{
            $assigned_from_ids1="like '%'";
          }

          if ($vars['mental']!='%') {
            if (is_array($vars['mental'])) {
                if ($vars['mental'][0]!='%') {
                    $mental_ids=array();
                    foreach ($vars['mental'] as $value) {
                      array_push($mental_ids,$value);
                    }
                    $mental_ids1=implode("','",$mental_ids);
                    $mental_ids1="in('".$mental_ids1."')";
                    //print_r($mental_ids1);
                }else{
                  $mental_ids1="like '%'";
                }
            }else{
              $mental_ids1="like '%".$vars['mental']."%'";
            }
          }else{
            $mental_ids1="like '%'";
          }
          //print_r($source_ids1);
//////////////////////////////////////////////////////////

            $vars['limiter']    = 100;
            $vars['pager']      = (int)$vars['limiter']*(int)$vars['page'];
            if (isset($_REQUEST['search_'])) {//if search
                $vars['search_']=$vars['search_']."%";
            }

           // print_r($vars);
           if ($vars['orderby']=="status") {
               $vars['orderby']="status_name";
            }
            if ($vars['orderby']=="leads.first_name") {
                $vars['orderby']="left(leads.first_name,1)";
             }

            // if ($vars['orderby']="%") {
            //   $vars['orderby']="leads.lead_id";
            // }
            //print_r($vars['orderby']);
            //  AND noq.user_id=:assigned_to

            //print_r($note);

            if ($vars['lasttask']!='%') {
              $iftaskquery="AND (DATE(n.start) >= DATE('".$vars['lasttask_min']."') AND DATE(n.start) <=DATE('".$vars['lasttask_max']."'))";
            }else{
              $iftaskquery='';
            }


            if (!isset($_REQUEST['search_'])) {//if fitler
                  $sql="SELECT leads.*,status.status_name,status.status_description,n.start as lasttask FROM leads
                        LEFT JOIN status ON status.status_id = leads.status
                        LEFT JOIN users  ON users.user_id = leads.assigned_to
                        LEFT JOIN reminders AS n ON n.reminder_id =
                             ( SELECT noq.reminder_id
                               FROM reminders AS noq
                               WHERE noq.lead_id = leads.lead_id
                               ORDER BY noq.reminder_id DESC
                               LIMIT 1
                             )
                        WHERE
                        (
                          ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                            OR
                          (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                        )
                        AND (DATE(leads.date_created) >= DATE(:date_created_min) AND DATE(leads.date_created) <=DATE(:date_created_max))
                        AND (DATE(leads.last_change) >= DATE(:last_change_min) AND DATE(leads.last_change) <=DATE(:last_change_max))
                        ".$iftaskquery."
                        AND email like :email
                        AND phone_number like :phone_number
                        AND brand like :brand
                        AND assigned_from ".$assigned_from_ids1."
                        AND level ".$level_ids1."
                        AND mental ".$mental_ids1."
                        AND assigned_to ".$assigned_to_ids1."
                        AND (users.recycle =0 OR leads.assigned_to=0)
                        AND source ".$source_ids1."
                        AND list_id like :list_id
                        AND note like '%".$note."%'
                        AND leads.status ".$status_ids1."
                        ORDER BY ".$vars['orderby']." ".$vars['orderdir']."
                        LIMIT :pager , :limiter";

                        $query = $this->db->prepare($sql);
                        $query->bindParam(':first_name', $vars['first_name']);
                        $query->bindParam(':last_name', $vars['last_name']);
                        $query->bindParam(':email', $vars['email']);
                        $query->bindParam(':phone_number', $vars['phone_number']);
                        $query->bindParam(':brand', $vars['brand']);
                        $query->bindParam(':date_created_min', $vars['date_created_min']);
                        $query->bindParam(':date_created_max', $vars['date_created_max']);
                        $query->bindParam(':last_change_min', $vars['last_change_min']);
                        $query->bindParam(':last_change_max', $vars['last_change_max']);
                        //$query->bindParam(':assigned_from', $vars['assigned_from']);
                        // $query->bindParam(':lasttask_min', $vars['lasttask_min']);
                        // $query->bindParam(':lasttask_max', $vars['lasttask_max']);

                        //$query->bindParam(':source', $vars['source']);
                        //$query->bindParam(':assigned_to', $vars['assigned_to']);
                        $query->bindParam(':list_id', $vars['list_id']);
                      //  $query->bindParam(':status', $vars['status']);
                        // $query->bindParam(':source', $vars['source']);
                        $query->bindParam(':pager', $vars['pager'], PDO::PARAM_INT);
                        $query->bindParam(':limiter', $vars['limiter'], PDO::PARAM_INT);
                        if ($query->execute()){
                            //echo 'success';
                        }
                      //$query->debugDumpParams();
            }else{//if search

              $sql="SELECT leads.*,status.status_name,status.status_description,n.start as lasttask FROM leads
                      LEFT JOIN status ON status.status_id = leads.status
                      LEFT JOIN users  ON users.user_id = leads.assigned_to
                      LEFT JOIN reminders AS n ON n.reminder_id =
                           ( SELECT noq.reminder_id
                             FROM reminders AS noq
                             WHERE noq.lead_id = leads.lead_id

                             ORDER BY noq.reminder_id DESC
                             LIMIT 1
                           )
                      WHERE
                      (
                        ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                          OR
                        (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                        OR phone_number like :search_
                        OR email like :search_
                        OR source like :search_
                        OR brand like :search_
                      )
                      AND (users.recycle =0 OR leads.assigned_to=0)
                      AND list_id like :list_id
                      ORDER BY ".$vars['orderby']." ".$vars['orderdir']."
                      LIMIT :pager , :limiter";
                      //AND assigned_to ".$assigned_to_ids1."
                      //AND .leads.status ".$status_ids1."
                      $query = $this->db->prepare($sql);
                      $query->bindParam(':first_name', $vars['first_name']);
                      $query->bindParam(':last_name', $vars['last_name']);
                      $query->bindParam(':search_', $vars['search_']);
                      $query->bindParam(':list_id', $vars['list_id']);
                      $query->bindParam(':pager', $vars['pager'], PDO::PARAM_INT);
                      $query->bindParam(':limiter', $vars['limiter'], PDO::PARAM_INT);
                      if ($query->execute()){
                          //echo 'success';
                      }
              }

              if ($export) {
                  $sel=" leads.*";
              }else{
                $sel="lead_id";
              }

              if (!isset($_REQUEST['search_'])) {
                $sql_count="SELECT ".$sel." FROM leads
                            LEFT JOIN users  ON users.user_id = leads.assigned_to

                      WHERE
                      (
                        ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                          OR
                        (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                      )
                      AND (DATE(leads.date_created) >= DATE(:date_created_min) AND DATE(leads.date_created) <=DATE(:date_created_max))
                      AND (DATE(leads.last_change) >= DATE(:last_change_min) AND DATE(leads.last_change) <=DATE(:last_change_max))
                      AND email like :email
                      AND phone_number like :phone_number
                      AND brand like :brand
                      AND assigned_from ".$assigned_from_ids1."
                      AND level ".$level_ids1."
                      AND mental ".$mental_ids1."
                      AND assigned_to ".$assigned_to_ids1."
                      AND (users.recycle =0 OR leads.assigned_to=0)
                      AND source ".$source_ids1."
                      AND list_id like :list_id
                      AND note like '%".$note."%'
                      AND leads.status ".$status_ids1;

                      $query_count = $this->db->prepare($sql_count);
                      $query_count->bindParam(':first_name', $vars['first_name']);
                      $query_count->bindParam(':last_name', $vars['last_name']);
                      $query_count->bindParam(':email', $vars['email']);
                      $query_count->bindParam(':phone_number', $vars['phone_number']);
                      $query_count->bindParam(':brand', $vars['brand']);
                      $query_count->bindParam(':date_created_min', $vars['date_created_min']);
                      $query_count->bindParam(':date_created_max', $vars['date_created_max']);
                      $query_count->bindParam(':last_change_min', $vars['last_change_min']);
                      $query_count->bindParam(':last_change_max', $vars['last_change_max']);
                      //$query_count->bindParam(':assigned_from', $vars['assigned_from']);

                      //$query_count->bindParam(':source', $vars['source']);
                      //$query_count->bindParam(':assigned_to', $vars['assigned_to']);
                      $query_count->bindParam(':list_id', $vars['list_id']);
                    //  $query_count->bindParam(':status', $vars['status']);
                      // $query_count->bindParam(':source', $vars['source']);

                      if ($query_count->execute()){
                          //echo 'success';
                      }
                    //  $query_count->debugDumpParams();
              }else{//if search
                    $sql_count="SELECT ".$sel."  FROM leads
                                LEFT JOIN users  ON users.user_id = leads.assigned_to
                                WHERE
                                  (
                                    ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                                      OR
                                    (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                                    OR email like :search_
                                    OR phone_number like :search_
                                    OR source like :search_
                                    OR brand like :search_
                                  )
                                  AND list_id like :list_id
                                  AND (users.recycle =0 OR leads.assigned_to=0)
                                  AND source ".$source_ids1."
                                  AND status ".$status_ids1."
                                  AND assigned_to ".$assigned_to_ids1;

                  $query_count = $this->db->prepare($sql_count);
                  $query_count->bindParam(':first_name', $vars['first_name']);
                  $query_count->bindParam(':last_name', $vars['last_name']);
                  $query_count->bindParam(':search_', $vars['search_']);

                  $query_count->bindParam(':list_id', $vars['list_id']);
                  if ($query_count->execute()){
                      //echo 'success';
                  }
              }


            $leads=$query->fetchAll();
            $allpages=$query_count->rowCount();
            //print_r($allpages);
            $output=array();
            array_push($output,$allpages);
            array_push($output,$leads);
            if (isset($_POST['all_selected'])) {
              array_push($output,$query_count->fetchAll());
            }
            //
            if ($export) {
                  header('Content-type: text/csv');
                  header('Content-Disposition: attachment; filename=leads_export_'.date('Y-m-d').'_'.substr(str_shuffle(str_repeat($x='0987654321poiuytrewqlkjhgfdsamnbvcxz',ceil(8/strlen($x)) )),1,8).'.csv');
                  $sql_count="SELECT ".$sel."  FROM leads
                              LEFT JOIN users  ON users.user_id = leads.assigned_to
                              WHERE
                                 (users.recycle =0 OR leads.assigned_to=0)
                                AND source ".$source_ids1."
                                AND status ".$status_ids1."
                                AND assigned_to ".$assigned_to_ids1;

                                $query_count = $this->db->prepare($sql_count);

                                if ($query_count->execute()){
                                    //echo 'success';
                                }
                  $leads=$query_count->fetchAll();
                //  print_r($leads);
                  $statuses=$this->getStatuses();
                  $operators=$this->getUsers();
                  //set header
                  if (!isset($_POST['export_fields'])) {
                    $header=array();
                  }else{
                    if (($key = array_search("full_name", $_POST['export_fields'])) !== false) {
                        unset($_POST['export_fields'][$key]);
                        array_push($_POST['export_fields'],'first_name');
                        array_push($_POST['export_fields'],'last_name');
                    }
                    $header=$_POST['export_fields'];
                  }
                  //array();
                  // foreach ((array)$leads[0] as $key => $value) {
                  //     array_push($header,$key);
                  // }



                  if (isset($_POST['status'])) {
                    array_push($header,'status');
                  }
                  if (isset($_POST['assigned_to'])) {
                    array_push($header,'assigned_to');
                  }
                  if (isset($_POST['source'])) {
                    array_push($header,'source');
                  }


                  // print_r($header);
                  //loop on contracts
                  //$header=$_POST['export_fields'];
                  $output=fopen("php://output","w");
                  //fputcsv($output,$header);
                  //print_r($_POST['export_fields']);
                  foreach ($leads as $lead) {
                      $row=array();
                      foreach ($lead as $key => $value) {
                        if (!in_array($key,$header)) {
                          continue;
                        }
                          switch ($key) {
                              case 'status':
                                 foreach ($statuses as $status) {
                                      if ($value==$status->status_id) {
                                          $value=$status->status_name;
                                      }
                                  }
                                  break;
                              case 'assigned_to':
                                  foreach ($operators as $operator) {
                                      if ($value==$operator->user_id) {
                                          $value=$operator->first_name.' '.$operator->last_name;
                                      }
                                  }
                                  break;

                              default:
                                  $value=($value=='true')?'Yes':$value;
                                  $value=($value=='false')?'No':$value;
                                  break;
                          }
                         // if ($value!=null) {
                              array_push($row,$value);
                          //}
                      }
                      fputcsv($output,$row);
                  }
                // print_r($output);
              }//export else end

            return $output;
        }

        public function getRecycle($export=null){
                if (isset($_REQUEST['search_'])) {
                  if ($_REQUEST['search_']=='') {
                    unset($_REQUEST['search_']);
                  }
                }

                $vars=array();
                if (!isset($_REQUEST['search_'])) {//if filter
                  //full_name
                  //phone_number
                  //email
                  //status
                  //source
                  //brand
                  //assigned_to
                    $vars['full_name']          = (isset($_REQUEST['full_name'])?$_REQUEST['full_name']:'%');
                    $vars['first_name']     = explode(" ",$vars['full_name'])[0].'%';
                    $vars['last_name']      = substr(strstr($vars['full_name']," "), 1).'%';
                    $vars['phone_number']   = (isset($_REQUEST['phone_number'])?$_REQUEST['phone_number']:'%');
                    $vars['email']          = (isset($_REQUEST['email'])?$_REQUEST['email']:'%');
                    $vars['status']    = (isset($_REQUEST['status'])?$_REQUEST['status']:'%');
                    $vars['source']    = (isset($_REQUEST['source'])?$_REQUEST['source']:'%');
                    $vars['brand']    = (isset($_REQUEST['brand'])?$_REQUEST['brand']:'%');
                    $vars['assigned_to']    = (isset($_REQUEST['assigned_to'])?$_REQUEST['assigned_to']:'%');
                    $vars['date_created']    = (isset($_REQUEST['date_created'])?$_REQUEST['date_created']:'%');
                    $vars['last_change']    = (isset($_REQUEST['last_change'])?$_REQUEST['last_change']:'%');
                    $vars['note']    = (isset($_REQUEST['note'])?$_REQUEST['note']:'%');
                    $vars['lasttask']    = (isset($_REQUEST['lasttask'])?$_REQUEST['lasttask']:'%');
                    $vars['assigned_from']    = (isset($_REQUEST['assigned_from'])?$_REQUEST['assigned_from']:'%');

                    if ($vars['date_created']=='%' || $vars['date_created']=='') {
                      $vars['date_created']='1970-01-01 - '.date("Y-m-d");
                    }
                    $reg=explode(' - ',$vars['date_created']);
                    $vars['date_created_min']=date("Y-m-d", strtotime($reg[0]));
                    $vars['date_created_max']=date("Y-m-d", strtotime($reg[1]));
                    //print_r($vars);

                    if ($vars['last_change']=='%' || $vars['last_change']=='') {
                      $vars['last_change']='1970-01-01 - '.date("Y-m-d");
                    }
                    $reg=explode(' - ',$vars['last_change']);
                    $vars['last_change_min']=date("Y-m-d", strtotime($reg[0]));
                    $vars['last_change_max']=date("Y-m-d", strtotime($reg[1]));

                    if ($vars['lasttask']=='%' || $vars['lasttask']=='') {
                      $vars['lasttask']='1970-01-01 - '.date("Y-m-d");
                    }
                    $reg=explode(' - ',$vars['lasttask']);
                    $vars['lasttask_min']=date("Y-m-d", strtotime($reg[0]));
                    $vars['lasttask_max']=date("Y-m-d", strtotime($reg[1]));
                    $note=$vars['note'];
                }else{//if search
                  $vars['search_']           = (isset($_REQUEST['search_'])?$_REQUEST['search_']:'%');
                  $vars['first_name']     = explode(" ",$vars['search_'])[0].'%';
                  $vars['last_name']      = substr(strstr($vars['search_']," "), 1).'%';
                  $vars['status']    = (isset($_REQUEST['status'])?$_REQUEST['status']:'%');
                  $vars['source']    = (isset($_REQUEST['source'])?$_REQUEST['source']:'%');
                  $vars['assigned_to']    = (isset($_REQUEST['assigned_to'])?$_REQUEST['assigned_to']:'%');
                }
                $vars['list_id']    = (isset($_REQUEST['list_id'])?$_REQUEST['list_id']:'%');
                $vars['page']           = (int)(isset($_REQUEST['page'])? $_REQUEST['page']:0);
                $vars['orderby']    = (isset($_REQUEST['orderby'])?$_REQUEST['orderby']:'lead_id');
                $vars['orderdir']    = (isset($_REQUEST['orderdir'])?$_REQUEST['orderdir']:'DESC');



                //$vars['assigned_to']=(isset($_REQUEST['assigned_to'])?$_REQUEST['assigned_to']:'%');
                //if var empty convert to %

                foreach ($vars as $h => $v) {
                    if ($v=='') {
                        $vars[$h]='%';
                    }
                }

    //print_r($_REQUEST['search_']);
    //if (!isset($_REQUEST['search_'])) {//if filter
      //echo "filter";
    ////////////////////////////////////////////////////////
                if ($vars['status']!='%') {
                  if ($vars['status'][0]!='%') {
                      $status_ids=array();
                      foreach ($vars['status'] as $value) {
                        array_push($status_ids,$value);
                      }
                      $status_ids1=implode(',', array_map('intval', $status_ids));
                      $status_ids1='in('.$status_ids1.')';
                  }else{
                      $status_ids1="like '%'";
                  }
                }else{
                  $status_ids1="like '%'";
                }

    ////////////////////////////////////////////////////////
                if ($vars['assigned_to']!='%') {
                    if ($vars['assigned_to'][0]!='%') {
                        $assigned_to_ids=array();
                        foreach ($vars['assigned_to'] as $value) {
                          array_push($assigned_to_ids,$value);
                        }
                        $assigned_to_ids1=implode(',', array_map('intval', $assigned_to_ids));
                        $assigned_to_ids1='in('.$assigned_to_ids1.')';
                    }else{
                      $assigned_to_ids1="like '%'";
                    }
                }else{
                  $assigned_to_ids1="like '%'";
                }

    /////////////////////////////////////////////////////////
              if ($vars['source']!='%') {
                if (is_array($vars['source'])) {
                    if ($vars['source'][0]!='%') {
                        $source_ids=array();
                        foreach ($vars['source'] as $value) {
                          array_push($source_ids,$value);
                        }
                        $source_ids1=implode("','",$source_ids);
                        $source_ids1="in('".$source_ids1."')";
                        //print_r($source_ids1);
                    }else{
                      $source_ids1="like '%'";
                    }
                }else{
                  $source_ids1="like '%".$vars['source']."%'";
                }
              }else{
                $source_ids1="like '%'";
              }
              //print_r($source_ids1);
    //////////////////////////////////////////////////////////

                $vars['limiter']    = 100;
                $vars['pager']      = (int)$vars['limiter']*(int)$vars['page'];
                if (isset($_REQUEST['search_'])) {//if search
                    $vars['search_']=$vars['search_']."%";
                }

               // print_r($vars);
               if ($vars['orderby']=="status") {
                   $vars['orderby']="status_name";
                }
                if ($vars['orderby']=="leads.first_name") {
                    $vars['orderby']="left(leads.first_name,1)";
                 }

                // if ($vars['orderby']="%") {
                //   $vars['orderby']="leads.lead_id";
                // }
                //print_r($vars['orderby']);
                //  AND noq.user_id=:assigned_to

                //print_r($note);

                if (!isset($_REQUEST['search_'])) {//if fitler
                      $sql="SELECT leads.*,status.status_name,status.status_description,n.start as lasttask FROM leads
                            LEFT JOIN status ON status.status_id = leads.status
                            LEFT JOIN users  ON users.user_id = leads.assigned_to
                            LEFT JOIN reminders AS n ON n.reminder_id =
                                 ( SELECT noq.reminder_id
                                   FROM reminders AS noq
                                   WHERE noq.lead_id = leads.lead_id
                                   ORDER BY noq.reminder_id DESC
                                   LIMIT 1
                                 )
                            WHERE
                            (
                              ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                                OR
                              (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                            )
                            AND (DATE(leads.date_created) >= DATE(:date_created_min) AND DATE(leads.date_created) <=DATE(:date_created_max))
                            AND (DATE(leads.last_change) >= DATE(:last_change_min) AND DATE(leads.last_change) <=DATE(:last_change_max))
                            -- AND (DATE(n.start) >= DATE(:lasttask_min) AND DATE(n.start) <=DATE(:lasttask_max))
                            AND email like :email
                            AND phone_number like :phone_number
                            AND brand like :brand
                            AND assigned_from like :assigned_from
                            AND assigned_to ".$assigned_to_ids1."
                            AND users.recycle =1
                            AND source ".$source_ids1."
                            AND list_id like :list_id
                            AND note like '%".$note."%'
                            AND leads.status ".$status_ids1."
                            ORDER BY ".$vars['orderby']." ".$vars['orderdir']."
                            LIMIT :pager , :limiter";

                            $query = $this->db->prepare($sql);
                            $query->bindParam(':first_name', $vars['first_name']);
                            $query->bindParam(':last_name', $vars['last_name']);
                            $query->bindParam(':email', $vars['email']);
                            $query->bindParam(':phone_number', $vars['phone_number']);
                            $query->bindParam(':brand', $vars['brand']);
                            $query->bindParam(':date_created_min', $vars['date_created_min']);
                            $query->bindParam(':date_created_max', $vars['date_created_max']);
                            $query->bindParam(':last_change_min', $vars['last_change_min']);
                            $query->bindParam(':last_change_max', $vars['last_change_max']);
                            $query->bindParam(':assigned_from', $vars['assigned_from']);
                            // $query->bindParam(':lasttask_min', $vars['lasttask_min']);
                            // $query->bindParam(':lasttask_max', $vars['lasttask_max']);

                            //$query->bindParam(':source', $vars['source']);
                            //$query->bindParam(':assigned_to', $vars['assigned_to']);
                            $query->bindParam(':list_id', $vars['list_id']);
                          //  $query->bindParam(':status', $vars['status']);
                            // $query->bindParam(':source', $vars['source']);
                            $query->bindParam(':pager', $vars['pager'], PDO::PARAM_INT);
                            $query->bindParam(':limiter', $vars['limiter'], PDO::PARAM_INT);
                            if ($query->execute()){
                                //echo 'success';
                            }
                          //$query->debugDumpParams();
                }else{//if search

                  $sql="SELECT leads.*,status.status_name,status.status_description,n.start as lasttask FROM leads
                          LEFT JOIN status ON status.status_id = leads.status
                          LEFT JOIN users  ON users.user_id = leads.assigned_to
                          LEFT JOIN reminders AS n ON n.reminder_id =
                               ( SELECT noq.reminder_id
                                 FROM reminders AS noq
                                 WHERE noq.lead_id = leads.lead_id

                                 ORDER BY noq.reminder_id DESC
                                 LIMIT 1
                               )
                          WHERE
                          (
                            ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                              OR
                            (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                            OR phone_number like :search_
                            OR email like :search_
                            OR source like :search_
                            OR brand like :search_
                          )
                          AND users.recycle =1
                          AND list_id like :list_id
                          ORDER BY ".$vars['orderby']." ".$vars['orderdir']."
                          LIMIT :pager , :limiter";
                          //AND assigned_to ".$assigned_to_ids1."
                          //AND .leads.status ".$status_ids1."
                          $query = $this->db->prepare($sql);
                          $query->bindParam(':first_name', $vars['first_name']);
                          $query->bindParam(':last_name', $vars['last_name']);
                          $query->bindParam(':search_', $vars['search_']);
                          $query->bindParam(':list_id', $vars['list_id']);
                          $query->bindParam(':pager', $vars['pager'], PDO::PARAM_INT);
                          $query->bindParam(':limiter', $vars['limiter'], PDO::PARAM_INT);
                          if ($query->execute()){
                              //echo 'success';
                          }
                  }

                  if ($export) {
                      $sel=" leads.*";
                  }else{
                    $sel="lead_id";
                  }

                  if (!isset($_REQUEST['search_'])) {
                    $sql_count="SELECT ".$sel." FROM leads
                                LEFT JOIN users  ON users.user_id = leads.assigned_to

                          WHERE
                          (
                            ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                              OR
                            (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                          )
                          AND (DATE(leads.date_created) >= DATE(:date_created_min) AND DATE(leads.date_created) <=DATE(:date_created_max))
                          AND (DATE(leads.last_change) >= DATE(:last_change_min) AND DATE(leads.last_change) <=DATE(:last_change_max))
                          AND email like :email
                          AND phone_number like :phone_number
                          AND brand like :brand
                          AND assigned_from like :assigned_from
                          AND assigned_to ".$assigned_to_ids1."
                          AND users.recycle =1
                          AND source ".$source_ids1."
                          AND list_id like :list_id
                          AND note like '%".$note."%'
                          AND leads.status ".$status_ids1;

                          $query_count = $this->db->prepare($sql_count);
                          $query_count->bindParam(':first_name', $vars['first_name']);
                          $query_count->bindParam(':last_name', $vars['last_name']);
                          $query_count->bindParam(':email', $vars['email']);
                          $query_count->bindParam(':phone_number', $vars['phone_number']);
                          $query_count->bindParam(':brand', $vars['brand']);
                          $query_count->bindParam(':date_created_min', $vars['date_created_min']);
                          $query_count->bindParam(':date_created_max', $vars['date_created_max']);
                          $query_count->bindParam(':last_change_min', $vars['last_change_min']);
                          $query_count->bindParam(':last_change_max', $vars['last_change_max']);
                          $query_count->bindParam(':assigned_from', $vars['assigned_from']);
                          //$query_count->bindParam(':source', $vars['source']);
                          //$query_count->bindParam(':assigned_to', $vars['assigned_to']);
                          $query_count->bindParam(':list_id', $vars['list_id']);
                        //  $query_count->bindParam(':status', $vars['status']);
                          // $query_count->bindParam(':source', $vars['source']);

                          if ($query_count->execute()){
                              //echo 'success';
                          }
                        //  $query_count->debugDumpParams();
                  }else{//if search
                        $sql_count="SELECT ".$sel."  FROM leads
                                    LEFT JOIN users  ON users.user_id = leads.assigned_to
                                    WHERE
                                      (
                                        ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                                          OR
                                        (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                                        OR email like :search_
                                        OR phone_number like :search_
                                        OR source like :search_
                                        OR brand like :search_
                                      )
                                      AND list_id like :list_id
                                      AND users.recycle =1
                                      AND source ".$source_ids1."
                                      AND status ".$status_ids1."
                                      AND assigned_to ".$assigned_to_ids1;

                      $query_count = $this->db->prepare($sql_count);
                      $query_count->bindParam(':first_name', $vars['first_name']);
                      $query_count->bindParam(':last_name', $vars['last_name']);
                      $query_count->bindParam(':search_', $vars['search_']);

                      $query_count->bindParam(':list_id', $vars['list_id']);
                      if ($query_count->execute()){
                          //echo 'success';
                      }
                  }


                $leads=$query->fetchAll();
                $allpages=$query_count->rowCount();
                //print_r($allpages);
                $output=array();
                array_push($output,$allpages);
                array_push($output,$leads);
                if (isset($_POST['all_selected'])) {
                  array_push($output,$query_count->fetchAll());
                }
                //
                if ($export) {
                      header('Content-type: text/csv');
                      header('Content-Disposition: attachment; filename=leads_export_'.date('Y-m-d').'_'.substr(str_shuffle(str_repeat($x='0987654321poiuytrewqlkjhgfdsamnbvcxz',ceil(8/strlen($x)) )),1,8).'.csv');
                      $sql_count="SELECT ".$sel."  FROM leads
                                  LEFT JOIN users  ON users.user_id = leads.assigned_to
                                  WHERE
                                    users.recycle =1
                                    AND source ".$source_ids1."
                                    AND status ".$status_ids1."
                                    AND assigned_to ".$assigned_to_ids1;

                                    $query_count = $this->db->prepare($sql_count);

                                    if ($query_count->execute()){
                                        //echo 'success';
                                    }
                      $leads=$query_count->fetchAll();
                    //  print_r($leads);
                      $statuses=$this->getStatuses();
                      $operators=$this->getUsers();
                      //set header
                      if (!isset($_POST['export_fields'])) {
                        $header=array();
                      }else{
                        if (($key = array_search("full_name", $_POST['export_fields'])) !== false) {
                            unset($_POST['export_fields'][$key]);
                            array_push($_POST['export_fields'],'first_name');
                            array_push($_POST['export_fields'],'last_name');
                        }
                        $header=$_POST['export_fields'];
                      }
                      //array();
                      // foreach ((array)$leads[0] as $key => $value) {
                      //     array_push($header,$key);
                      // }



                      if (isset($_POST['status'])) {
                        array_push($header,'status');
                      }
                      if (isset($_POST['assigned_to'])) {
                        array_push($header,'assigned_to');
                      }
                      if (isset($_POST['source'])) {
                        array_push($header,'source');
                      }


                      // print_r($header);
                      //loop on contracts
                      //$header=$_POST['export_fields'];
                      $output=fopen("php://output","w");
                      //fputcsv($output,$header);
                      //print_r($_POST['export_fields']);
                      foreach ($leads as $lead) {
                          $row=array();
                          foreach ($lead as $key => $value) {
                            if (!in_array($key,$header)) {
                              continue;
                            }
                              switch ($key) {
                                  case 'status':
                                     foreach ($statuses as $status) {
                                          if ($value==$status->status_id) {
                                              $value=$status->status_name;
                                          }
                                      }
                                      break;
                                  case 'assigned_to':
                                      foreach ($operators as $operator) {
                                          if ($value==$operator->user_id) {
                                              $value=$operator->first_name.' '.$operator->last_name;
                                          }
                                      }
                                      break;

                                  default:
                                      $value=($value=='true')?'Yes':$value;
                                      $value=($value=='false')?'No':$value;
                                      break;
                              }
                             // if ($value!=null) {
                                  array_push($row,$value);
                              //}
                          }
                          fputcsv($output,$row);
                      }
                    // print_r($output);
                  }//export else end

                return $output;
            }

        public function getRecycle1($export=null){

                $vars=array();
                $vars['page']           = (int)(isset($_REQUEST['page'])? $_REQUEST['page']:0);
                $vars['search_']           = (isset($_REQUEST['search_'])?$_REQUEST['search_']:'%');
                // $vars['email']          = (isset($_REQUEST['email'])?$_REQUEST['email']:'%');
                // $vars['phone_number']   = (isset($_REQUEST['phone_number'])?$_REQUEST['phone_number']:'%');
                // $vars['country_by_ip']  = (isset($_REQUEST['country_by_ip'])?$_REQUEST['country_by_ip']:'%');
                // $vars['promocode']      = (isset($_REQUEST['promocode'])?$_REQUEST['promocode']:'%');
                // $vars['landing_page']   = (isset($_REQUEST['landing_page'])?$_REQUEST['landing_page']:'%');
                $vars['assigned_to']    = (isset($_REQUEST['assigned_to'])?$_REQUEST['assigned_to']:'%');
                $vars['source']    = (isset($_REQUEST['source'])?$_REQUEST['source']:'%');
                $vars['status']    = (isset($_REQUEST['status'])?$_REQUEST['status']:'%');
                $vars['list_id']    = (isset($_REQUEST['list_id'])?$_REQUEST['list_id']:'%');
                $vars['first_name']     = explode(" ",$vars['search_'])[0].'%';
                $vars['last_name']      = substr(strstr($vars['search_']," "), 1).'%';
                $vars['orderby']    = (isset($_REQUEST['orderby'])?$_REQUEST['orderby']:'lead_id');
                $vars['orderdir']    = (isset($_REQUEST['orderdir'])?$_REQUEST['orderdir']:'DESC');
                //$vars['assigned_to']=(isset($_REQUEST['assigned_to'])?$_REQUEST['assigned_to']:'%');
                //if var empty convert to %

                foreach ($vars as $h => $v) {
                    if ($v=='') {
                        $vars[$h]='%';
                    }
                }
    ////////////////////////////////////////////////////////
                if ($vars['status']!='%') {
                  if ($vars['status'][0]!='%') {
                      $status_ids=array();
                      foreach ($vars['status'] as $value) {
                        array_push($status_ids,$value);
                      }
                      $status_ids1=implode(',', array_map('intval', $status_ids));
                      $status_ids1='in('.$status_ids1.')';
                  }else{
                      $status_ids1="like '%'";
                  }
                }else{
                  $status_ids1="like '%'";
                }

    ////////////////////////////////////////////////////////
                if ($vars['assigned_to']!='%') {
                    if ($vars['assigned_to'][0]!='%') {
                        $assigned_to_ids=array();
                        foreach ($vars['assigned_to'] as $value) {
                          array_push($assigned_to_ids,$value);
                        }
                        $assigned_to_ids1=implode(',', array_map('intval', $assigned_to_ids));
                        $assigned_to_ids1='in('.$assigned_to_ids1.')';
                    }else{
                      $assigned_to_ids1="like '%'";
                    }
                }else{
                  $assigned_to_ids1="like '%'";
                }

    /////////////////////////////////////////////////////////
              if ($vars['source']!='%') {
                if (is_array($vars['source'])) {
                    if ($vars['source'][0]!='%') {
                        $source_ids=array();
                        foreach ($vars['source'] as $value) {
                          array_push($source_ids,$value);
                        }
                        $source_ids1=implode("','",$source_ids);
                        $source_ids1="in('".$source_ids1."')";
                        //print_r($source_ids1);
                    }else{
                      $source_ids1="like '%'";
                    }
                }else{
                  $source_ids1="like '%".$vars['source']."%'";
                }
              }else{
                $source_ids1="like '%'";
              }
              //print_r($source_ids1);
    //////////////////////////////////////////////////////////

                $vars['limiter']    = 100;
                $vars['pager']      = (int)$vars['limiter']*(int)$vars['page'];

                $vars['search_']=$vars['search_']."%";

               // print_r($vars);
               if ($vars['orderby']=="status") {
                   $vars['orderby']="status_name";
                }
                if ($vars['orderby']=="first_name") {
                    $vars['orderby']="left(first_name,1)";
                 }

                // if ($vars['orderby']="%") {
                //   $vars['orderby']="leads.lead_id";
                // }
                //print_r($vars['orderby']);
                //  AND noq.user_id=:assigned_to
                $sql="SELECT leads.*,status.status_name,status.status_description,n.start as lasttask FROM leads
                        LEFT JOIN status ON status.status_id = leads.status
                        LEFT JOIN users  ON users.user_id = leads.assigned_to
                        LEFT JOIN reminders AS n ON n.reminder_id =
                             ( SELECT noq.reminder_id
                               FROM reminders AS noq
                               WHERE noq.lead_id = leads.lead_id

                               ORDER BY noq.reminder_id DESC
                               LIMIT 1
                             )
                        WHERE
                        (
                          ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                            OR
                          (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                          OR email like :search_
                          OR phone_number like :search_
                          OR source like :search_
                        )
                        AND assigned_to ".$assigned_to_ids1."
                        AND users.recycle =1
                        AND source ".$source_ids1."
                        AND list_id like :list_id
                        AND .leads.status ".$status_ids1."
                        ORDER BY ".$vars['orderby']." ".$vars['orderdir']."
                        LIMIT :pager , :limiter";

                  if ($export) {
                      $sel="*";
                  }else{
                    $sel="lead_id";
                  }

                  $sql_count="SELECT ".$sel." FROM leads
                              LEFT JOIN users  ON users.user_id = leads.assigned_to
                              WHERE
                                (
                                  ((leads.first_name LIKE :first_name AND .leads.last_name LIKE :last_name)
                                    OR
                                  (leads.first_name LIKE :last_name AND leads.last_name LIKE :first_name))
                                  OR email like :search_
                                  OR phone_number like :search_
                                  OR source like :search_
                                )
                                AND list_id like :list_id
                                AND users.recycle =1
                                AND source ".$source_ids1."
                                AND status ".$status_ids1."
                                AND assigned_to ".$assigned_to_ids1;

                $query = $this->db->prepare($sql);
                $query->bindParam(':first_name', $vars['first_name']);
                $query->bindParam(':last_name', $vars['last_name']);
                $query->bindParam(':search_', $vars['search_']);
                //$query->bindParam(':assigned_to', $vars['assigned_to']);
                $query->bindParam(':list_id', $vars['list_id']);
              //  $query->bindParam(':status', $vars['status']);
                // $query->bindParam(':source', $vars['source']);
                $query->bindParam(':pager', $vars['pager'], PDO::PARAM_INT);
                $query->bindParam(':limiter', $vars['limiter'], PDO::PARAM_INT);
                if ($query->execute()){
                    //echo 'success';
                }
                $query_count = $this->db->prepare($sql_count);
                $query_count->bindParam(':first_name', $vars['first_name']);
                $query_count->bindParam(':last_name', $vars['last_name']);
                $query_count->bindParam(':search_', $vars['search_']);
                //$query_count->bindParam(':status', $vars['status']);
                // $query_count->bindParam(':source', $vars['source']);
                //$query_count->bindParam(':assigned_to', $vars['assigned_to']);
                $query_count->bindParam(':list_id', $vars['list_id']);
                if ($query_count->execute()){
                    //echo 'success';
                }

                //$query->debugDumpParams();
                $leads=$query->fetchAll();

                $allpages=$query_count->rowCount();
                //print_r($allpages);
                $output=array();
                array_push($output,$allpages);
                array_push($output,$leads);
                if (isset($_POST['all_selected'])) {
                  array_push($output,$query_count->fetchAll());
                }
                //print_r($leads);
                if ($export) {
                      header('Content-type: text/csv');
                      header('Content-Disposition: attachment; filename=leads_export_'.date('Y-m-d').'_'.substr(str_shuffle(str_repeat($x='0987654321poiuytrewqlkjhgfdsamnbvcxz',ceil(8/strlen($x)) )),1,8).'.csv');
                      $leads=$query_count->fetchAll();
                      $statuses=$this->getStatuses();
                      $operators=$this->getUsersByRole('operator');
                      //set header
                      $header=array();
                      foreach ((array)$leads[0] as $key => $value) {
                          array_push($header,$key);
                      }
                      //loop on contracts
                      $output=fopen("php://output","w");
                      fputcsv($output,$header);
                      //print_r($header);
                      foreach ($leads as $lead) {
                          $row=array();
                          foreach ($lead as $key => $value) {
                              switch ($key) {
                                  case 'status':
                                     foreach ($statuses as $status) {
                                          if ($value==$status->status_id) {
                                              $value=$status->status_name;
                                          }
                                      }
                                      break;
                                  case 'assigned_to':
                                      foreach ($operators as $operator) {
                                          if ($value==$operator->user_id) {
                                              $value=$operator->first_name.' '.$operator->last_name;
                                          }
                                      }
                                      break;

                                  default:
                                      $value=($value=='true')?'Yes':$value;
                                      $value=($value=='false')?'No':$value;
                                      break;
                              }
                             // if ($value!=null) {
                                  array_push($row,$value);
                              //}
                          }
                          fputcsv($output,$row);
                      }
                    // print_r($output);
                  }//export else end

                return $output;
            }

        public function createLead(){
          $_POST['phone_number']=trim($_POST['phone_number']);
          $sql="SELECT lead_id FROM leads WHERE phone_number=:phone_number";
          $query = $this->db->prepare($sql);
          $query->execute(array(':phone_number' =>$_POST['phone_number']));

            if ($query->rowCount()>0) {
                $_SESSION['lead_exist']='true';
                header("location:".URL.$_SESSION['role'].'/leads');
                return;
            }

              $sql = "INSERT INTO leads(`first_name`,`last_name`,`email`,`phone_number`,`source`,`assigned_to`)
                               VALUES(:first_name,:last_name,:email,:phone_number,:source,:assigned_to)";

                $query = $this->db->prepare($sql);
                $query->bindParam(':first_name', $_POST['first_name']);
                $query->bindParam(':last_name',$_POST['last_name']);
                $query->bindParam(':email',$_POST['email']);
                $query->bindParam(':phone_number', $_POST['phone_number']);
                $query->bindParam(':source', $_POST['source']);
                $query->bindParam(':assigned_to', $_POST['assigned_to']);

                //error handler
                if ($query->execute()) {
                    $lead_id=$this->db->lastInsertId();
                    header('location: viewLead/'.$this->db->lastInsertId());
                    $_SESSION['create_lead']='success';
                } else {
                    $_SESSION['create_lead']='fail';
                    header("location:".URL.$_SESSION['role'].'/leads');
                }
        }

        public function addTask($lead_id){
            $sql="INSERT INTO tasks(title,content,start,user_id,lead_id,description,color) VALUES(:title,:content,:start,:user_id,:lead_id,'',:color)";
            $query = $this->db->prepare($sql);
            $parameters=array(
                          ':title' => $_POST['title'],
                          ':content' => $_POST['content'],
                          ':start' => date("Y-m-d H:i:s", strtotime($_POST['start'])),
                          ':lead_id' => $_POST['lead_id'],
                          ':user_id' => $_SESSION['user_id'],
                          ':color'  => $_POST['color']
                            );
            if($query->execute($parameters)){
              //new task log
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }

            //log cheanges
                $sql="INSERT INTO log(user_id,lead_id,diff,ip) VALUES(:user_id,:lead_id,:diff,:ip)";
                $query=$this->db->prepare($sql);
                $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
                $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
                $query->bindValue(':diff',"New Task : ".$_POST['content']." | ".$_POST['start']);
                $query->bindParam(':ip', $ip);
                $query->execute();

                $_SESSION['addTask']='success';
            } else {
                $_SESSION['addTask']='fail';
            }
          //  print_r($_POST['start']);
          header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
        }

    public function setSeen($task_id){
      $sql="UPDATE tasks set seen=1 where task_id=:task_id";
      $query=$this->db->prepare($sql);
      $query->execute(array('task_id'=>$task_id));
    }

    public function editLead($lead_id){
      $sql="SELECT * FROM leads WHERE `lead_id`=:lead_id LIMIT 1";
      $query=$this->db->prepare($sql);
      $query->execute(array(':lead_id' =>$lead_id));
      $old_c=$query->fetch(PDO::FETCH_ASSOC);

        $sql="UPDATE leads SET first_name=:first_name,last_name=:last_name,email=:email,source=:source,brand=:brand,phone_number=:phone_number,assigned_to=:assigned_to,note=:note,status=:status,alt_number=:alt_number,data_sheets=:data_sheets,webform=:webform WHERE lead_id=:lead_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':lead_id',$lead_id,PDO::PARAM_INT);
        $query->bindParam(':first_name', $_POST['first_name']);
        $query->bindParam(':last_name',$_POST['last_name']);
        $query->bindParam(':email',$_POST['email']);
        $query->bindParam(':phone_number', $_POST['phone_number']);
        $query->bindParam(':alt_number', $_POST['alt_number']);
        $query->bindParam(':data_sheets', $_POST['data_sheets']);
        $query->bindParam(':brand', $_POST['brand']);
        $query->bindParam(':source', $_POST['source']);
        $query->bindParam(':note', $_POST['note']);
        $query->bindParam(':status', $_POST['status']);
        $query->bindParam(':assigned_to', $_POST['assigned_to']);
        $query->bindParam(':webform', $_POST['webform']);

        //error handler
        if ($query->execute()) {
          //log changes
           $sql="SELECT * FROM leads WHERE `lead_id`=:lead_id LIMIT 1";
           $query=$this->db->prepare($sql);
           $query->execute(array(':lead_id' =>$lead_id));
           $new_c=$query->fetch(PDO::FETCH_ASSOC);
           $old_a=array_diff($old_c,$new_c);
           $new_a=array_diff($new_c,$old_c);
           $diff="";
           foreach ($old_a as $index=>$value) {
               if ($index=='status') {//old status name
                   $sql='SELECT status_name FROM status where status_id=:status_id';
                   $query = $this->db->prepare($sql);
                   $query->bindParam(':status_id', $value,PDO::PARAM_INT);
                   $query->execute();
                   $oldstatus=$query->fetch();
                   //new status name
                   $sql='SELECT status_name FROM status where status_id=:status_id';
                   $query = $this->db->prepare($sql);
                   $query->bindParam(':status_id', $new_a[$index],PDO::PARAM_INT);
                   $query->execute();
                   $newstatus=$query->fetch();
                   //log status names
                   $diff.=$index."[".$oldstatus->status_name."=>".$newstatus->status_name."]|";
               }elseif($index=='assigned_to'){
                   $sql='SELECT first_name,last_name FROM users where user_id=:user_id';
                   $query = $this->db->prepare($sql);
                   $query->bindParam(':user_id', $value,PDO::PARAM_INT);
                   $query->execute();
                   $olduser=$query->fetch();
                   //new assign name
                   $sql='SELECT first_name,last_name FROM users where user_id=:user_id';
                   $query = $this->db->prepare($sql);
                   $query->bindParam(':user_id', $new_a[$index],PDO::PARAM_INT);
                   $query->execute();
                   $newuser=$query->fetch();
                   //log assgned names
                   $diff.=$index."[".$olduser->first_name." ".$olduser->last_name."=>".$newuser->first_name." ".$newuser->last_name."]|";
               }else{
                   $diff.=$index."[".$value."=>".$new_a[$index]."]|";
               }
           }

           if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
               $ip = $_SERVER['HTTP_CLIENT_IP'];
           } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
               $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
           } else {
               $ip = $_SERVER['REMOTE_ADDR'];
           }
           if (!empty($diff)) {
               $sql="INSERT INTO log(user_id,lead_id,diff,ip) VALUES(:user_id,:lead_id,:diff,:ip)";
               $query=$this->db->prepare($sql);
               $query->bindValue(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
               $query->bindValue(':lead_id',$lead_id,PDO::PARAM_INT);
               $query->bindValue(':diff',$diff);
               $query->bindValue(':ip',$ip);
               $query->execute();
           }

            header('location: ../viewLead/'.$lead_id);
            $_SESSION['edit_lead']='success';
        } else {
            //$_SESSION['edit_contract']='fail';
            echo "An error occurred!";
        }
    }

    public function setLastChange($lead_id){
      $sql="UPDATE leads SET last_change=now() WHERE lead_id=:lead_id";
      $query = $this->db->prepare($sql);
      $query->bindParam(':lead_id',$lead_id,PDO::PARAM_INT);
      $query->execute();
    }
    public function uploadDocuments(){
        $user_id=$_POST['user_id'];
        $target_dir = APP."documents/";

        $target_file = $target_dir .basename($_FILES["documents"]["name"]);
        $allow_ext = array('pdf');//,'doc','docx','csv','xls','xlsx','txt','jpg','jpeg'
        $ext = pathinfo($target_file, PATHINFO_EXTENSION);
        print_r($target_file);
        print_r($_FILES);
        if (!in_array($ext,$allow_ext)) {
            echo "ext_error";
            return;
        }
        if (move_uploaded_file($_FILES["documents"]["tmp_name"],$target_file)) {
            $sql="INSERT INTO documents(user_id,url) VALUES(:user_id,:url)";
            $query=$this->db->prepare($sql);
            $query->execute(array(':user_id' =>(int)$user_id,':url'=>$target_file));
            echo "success";
        }else{
            echo "fail";
        }

        header("Location:".URL.$_SESSION['role'].'/editUser/'.$user_id);
    }

    public function getDocument($document_id){
    	$sql="SELECT *  FROM documents WHERE `document_id`=:document_id";
    	$query=$this->db->prepare($sql);
    	$query->execute(array(':document_id' =>$document_id));
    	$document=$query->fetch();
    	if (!$document) {
    		echo  "File do not exist in database!";
    		return;
    	}
		$target_dir = APP."documents/";
      //  print_r($document);
		$target_file = $target_dir . basename($document->url);
        //print_r($target_file);
		$ext = pathinfo($target_file, PATHINFO_EXTENSION);
 		if (file_exists ($target_file)) {
			switch(strtolower($ext)){
				case "txt":
					header("Content-type: text/plain");
					readfile($target_file);
				break;
				case "jpg":
					header("Content-type: image/jpg");
					readfile($target_file);
				break;
                case "jpeg":
                    header("Content-type: image/jpeg");
                    readfile($target_file);
                break;
				case "png":
					header("content-type: image/png");
					readfile($target_file);
				break;
				case "pdf":
					header("content-type: application/pdf");
					readfile($target_file);
				break;
				case 'docx':
					//echo "not suppoted yet";
                    header('Content-Type: application/octet-stream');
                    header("Content-Disposition: attachment; filename=\"".$document->url."\"");
                    readfile($target_file);
				break;
                case 'csv':
                    header("Content-type: text/csv");
                    header('Content-disposition: attachment; filename="'.$document->url.'"');
                    readfile($target_file);
                break;
			};
		} else{
			echo "File do not exist in server!";
		}
	}

    public function uploadAudios(){

        $contract_id=$_POST['contract_id'];
        $client_name=$_POST['client_name'];
        $name=explode(' ',$client_name);
        $first_name=strtolower($name[0]);
        $last_name= strtolower($name[1]);

        $target_dir = APP."audios/";
        $allow_ext = array('mp3','wav','gsm','gsw');
        $ext = pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);
		$target_file1 = $target_dir .date('ymd').'_'.ucfirst($last_name).ucfirst($first_name).'.'.$ext;
        if (!in_array($ext,$allow_ext)) {
            echo "ext_error: ";
            echo $ext;
            return;
        }
        if (move_uploaded_file($_FILES["file"]["tmp_name"],$target_file1)) {
            $sql="INSERT INTO audios(contract_id,url) VALUES(:contract_id,:url)";
            $query=$this->db->prepare($sql);
            $query->execute(array(':contract_id' =>(int)$contract_id,':url'=>date('ymd').'_'.ucfirst($last_name).ucfirst($first_name).'.'.$ext));
            echo "success";
        }else{
            echo "fail";
        }
    }

    public function getAudios($contract_id){
    	$sql="SELECT * FROM audios WHERE `contract_id`=:contract_id ORDER BY audio_id DESC";
    	$query=$this->db->prepare($sql);
    	$query->execute(array(':contract_id' =>$contract_id));
    	$audios=$query->fetchAll(PDO::FETCH_ASSOC);
        header('Content-type: application/json');
        echo json_encode($audios);
    }

    public function getAudio($audio_id){
    	$sql="SELECT *  FROM audios WHERE `audio_id`=:audio_id";
    	$query=$this->db->prepare($sql);
    	$query->execute(array(':audio_id' =>$audio_id));
    	$audio=$query->fetch();
    	if (!$audio) {
    		echo  "File do not exist in database!";
    		return;
    	}
		$target_dir = APP."audios/";
		$target_file = $target_dir . basename($audio->url);
		$ext = pathinfo($target_file, PATHINFO_EXTENSION);
 		if (file_exists ($target_file)) {
			switch(strtolower($ext)){
				case "mp3":
					header("Content-type: audio/mp3");
					readfile($target_file);
				break;
				case "wav":
					header("Content-type: audio/wav");
					readfile($target_file);
				break;

			};
		} else{
			echo "File do not exist in server!";
		}
	}
}
