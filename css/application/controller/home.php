<?php
header("Access-Control-Allow-Origin: *");
class Home extends Controller{

    public function index(){
        if (isset($_SESSION['username'])) {//if logged in
            header('location:'.URL.$_SESSION['role']);
        } else{//if not logged in
            require APP.'view/login/index.php';
        }
    }


  public function login(){
                unset($_SESSION['username']);
                unset($_SESSION['role']);
                if (isset($_POST['username']) && isset($_POST['password']) ) { //check if all parameters are set
                      $sql= "SELECT  * FROM users WHERE username = :username and password = :password LIMIT 1";
                      $query = $this->db->prepare($sql);
                      $query->execute(array(':username'=>$_POST['username'],':password'=>$_POST['password']));
                      $row=$query->fetch(PDO::FETCH_ASSOC);
                      $num=$query->rowCount();
                    if($num > 0){ ///if login success
                        ///
                        session_regenerate_id();
                        $_SESSION['username']=$row['username'];
                        $_SESSION['full_name']=$row['first_name'].' '.$row['last_name'];
                        $_SESSION['user_id']=$row['user_id'];
                        $_SESSION['role']=$row['role'];
                        $_SESSION['supervisor']=$row['supervisor'];
                        $_SESSION['user_email']=$row['user_email'];
                        $_SESSION['user_sip']=$row['user_sip'];

                        $sql1="INSERT INTO access_logs(`user_id`,`type`) VALUES (:user_id, :type)";
                        $query1 = $this->db->prepare($sql1);
                        $parameters=array(
                            ':user_id' => $row['user_id'],
                            ':type' => 'login',
                        );
                        $query1->execute($parameters);

                        if (isset($_POST['external_url'])) {
                            echo 'success'; //echo success on external login
                        }else {
                            header('location:'.URL.$_SESSION['role']);
                        }

                        $sql2="INSERT INTO user_sessions(`session_id`,`user_id`) VALUES (:session_id, :user_id)";
                        $query2 = $this->db->prepare($sql2);
                        $parameters=array(
                            ':session_id' => session_id(),
                            ':user_id' => $_SESSION['user_id'],
                        );
                        $query2->execute($parameters);

                    }else{//if error
                        if (isset($_POST['external_url'])) {//go back if its external login
                           echo '<script>javascript:history.back();</script>';
                        }else{
                           header('location:'.URL.'?status=fail');
                        }

                    }
            } else echo "Please set all parameters!";//if parameters are not set
    }


      public function logout(){
        if (isset($_SESSION['oldsession'])) {
          $_SESSION['username']=$_SESSION['old_username'];
          $_SESSION['full_name']=$_SESSION['old_full_name'];
          $_SESSION['role']=$_SESSION['old_role'];
          $_SESSION['user_id']=$_SESSION['old_user_id'];
          $_SESSION['supervisor']=$_SESSION['old_supervisor'];
          $_SESSION['user_email']=$_SESSION['old_user_email'];
          $_SESSION['user_sip']=$_SESSION['old_user_sip'];

            $sql1="INSERT INTO access_logs(`user_id`,`type`) VALUES (:user_id, :type)";
            $query1 = $this->db->prepare($sql1);
            $parameters=array(
                ':user_id' => $_SESSION['user_id'],
                ':type' => 'logout',
            );
            $query1->execute($parameters);

          unset($_SESSION['old_username']);
          unset($_SESSION['old_full_name']);
          unset($_SESSION['old_role']);
          unset($_SESSION['old_user_id']);
          unset($_SESSION['old_supervisor']);
          unset($_SESSION['old_user_email']);
          unset($_SESSION['old_user_sip']);
          unset($_SESSION['oldsession']);

          header('location:'.URL);
        }else{

            $sql1="INSERT INTO access_logs(`user_id`,`type`) VALUES (:user_id, :type)";
            $query1 = $this->db->prepare($sql1);
            $parameters=array(
                ':user_id' => $_SESSION['user_id'],
                ':type' => 'logout',
            );
            $query1->execute($parameters);


            $sql2="DELETE FROM user_sessions WHERE session_id=:session_id";
            $query2 = $this->db->prepare($sql2);
            $parameters=array(
                ':session_id' => session_id(),
            );
            $query2->execute($parameters);

          unset($_SESSION['username']);
          unset($_SESSION['role']);
          unset($_SESSION['user_id']);
          unset($_SESSION);

          session_destroy();
          header('location:'.URL.'?status=logout');
        }

    }
}
