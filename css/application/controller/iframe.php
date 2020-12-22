<?php
header("Access-Control-Allow-Origin: *");
class iframe extends Controller{

    public function addTask($title,$content,$start,$user_id,$lead_id,$description=''){
        $sql="INSERT INTO reminders(title,content,start,user_id,lead_id,description,color) VALUES(:title,:content,:start,:user_id,:lead_id,'',:color)";
        $query = $this->db->prepare($sql);
        $parameters=array(
            ':title' => $title,
            ':content' => $content,
            ':start' => date("Y-m-d H:i:s", strtotime($start)),
            ':lead_id' => $lead_id,
            ':user_id' => $user_id,
            ':color'=>'green'
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
            $query->bindParam(':user_id',$user_id,PDO::PARAM_INT);
            $query->bindParam(':lead_id', $lead_id,PDO::PARAM_INT);
            $query->bindValue(':diff',"New Reminder : ".$content." | ".$start);
            $query->bindParam(':ip', $ip);
            $query->execute();

            //$_SESSION['addTask']='success';
        } else {
            //$_SESSION['addTask']='fail';
        }
        //  print_r($_POST['start']);
        //  header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
    }


    public function index(){
        if(isset($_POST['create_lead_iframe'])){
            // if ($_POST['me']=='null') {
            //   echo "Please check Custom Four";
            //   return;
            // }
            // $username=$_POST['me'];
            //
            // $sql="SELECT user_id FROM users WHERE username=:username";
            // $query=$this->db->prepare($sql);
            // $query->execute(array(':username' => $username));
            // $user=$query->fetch();
            //
            // if (!isset($user->user_id)) {
            //   echo "Please check Custom Four";
            //   return;
            // }
            // $assigned_to=$user->user_id;

            $assigned_to=$_POST['assigned_to'];
            $source=$_POST['source'];
            $phone_number1=trim($_POST['phone_number']);

            $sql="SELECT lead_id FROM leads WHERE phone_number=:phone_number";
            $query = $this->db->prepare($sql);
            $query->execute(array(':phone_number' =>$phone_number1));

            if ($query->rowCount()>0) {;
                echo "Lead Exist!";
                return;
            }



            $sql = "INSERT INTO leads(`first_name`,`last_name`,`phone_number`,`status`,`assigned_to`,`data_sheets`,`source`,`assigned_from`,`level`)
                                 VALUES(:first_name,:last_name,:phone_number,:status,:assigned_to,:data_sheets,:source,:assigned_from,:level)";

            $query = $this->db->prepare($sql);
            $query->bindParam(':first_name', $_POST['first_name']);
            $query->bindParam(':last_name',$_POST['last_name']);
            $query->bindParam(':status',$_POST['status']);
            $query->bindParam(':assigned_to',$assigned_to);
            $query->bindParam(':data_sheets',$_POST['data_sheets']);
            $query->bindParam(':phone_number', $phone_number1);
            $query->bindParam(':assigned_from', $_POST['assigned_from']);
            $query->bindParam(':source', $source);
            $query->bindParam(':level', $_POST['level']);

            if ($query->execute()) {
                $lead_id=$this->db->lastInsertId();
                if ($_POST['start']!='') {
                    $this->addTask($_POST['first_name']." ".$_POST['last_name'],$_POST['content'],$_POST['start'],$_POST['assigned_from'],$lead_id);
                }
                echo "Success!";
            } else {
                echo "Error!";
            }
            return;
        }


        $sql='SELECT * FROM status';
        $query = $this->db->prepare($sql);
        $query->execute();
        $statuses=$query->fetchAll();
        ?>
        <link href="<?php echo URL; ?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <script src="<?php echo URL; ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo URL; ?>assets/js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/bootstrap-datetimepicker.min.css" />
        <form method="POST" action="">
            <table style="width:100%">
                <tr>
                    <td>
                        <label class="control-label">First Name</label></td>
                    <td>
                        <input type="text" name="first_name" value="<?=(isset($_GET['first_name'])?$_GET['first_name']:'');?>" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">Last name</label>
                    </td>
                    <td>
                        <input type="text" required name="last_name"  value="<?=(isset($_GET['last_name'])?$_GET['last_name']:'');?>" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">Phone Number</label>
                    </td>
                    <td>
                        <input type="text" name="phone_number"  value="<?=(isset($_GET['phone_number'])?$_GET['phone_number']:'');?>" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">Vicidial Description</label>
                    </td>
                    <td>
                        <textarea rows="4" style="width: 100%;"  type="text" name="data_sheets"  class="form-control"><?=(isset($_GET['data_sheets'])?$_GET['data_sheets']:'');?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">Level</label>
                    </td>
                    <td>
                        <select class="form-control"  name="level" id="level">
                            <option>High</option>
                            <option selected>Mid</option>
                            <option>Low</option>
                        </select>
                    </td>
                </tr>
                <!--                              VARhttps://any1coin.me/dashboard/iframe?first_name=--A--first_name--B--&last_name=--A--last_name--B--&phone_number=--A--phone_number--B--&assigned_from=--A--fullname--B--&source=--A--source--B--  -->
                <tr>
                    <td>
                        <label class="control-label">Source</label>
                    </td>
                    <td>
                        <select class="form-control"  name="source" id="source">
                            <option value="Robot" selected>Robot</option>
                            <option value="Promo">Promo</option>
                            <option value="Appointment">Appointment</option>
                            <option value="Academy" >Academy</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label class="control-label">Assign To</label>
                    </td>
                    <td>
                        <select class="form-control"  name="assigned_to" id="assigned_to">
                            <option value="7">Dalia Gosselin</option>
                            <option value="9">Roslyn Blanchard</option>
                            <option value="12">Isaac Thomas</option>
                            <option value="31">Davide Zanetti</option>
                            <option value="52">Endre Gal</option>
                            <option value="98">Elias Athan</option>
                            <option value="100">Grace Hoover</option>
                            <option value="101">Eliott Pope</option>
                            <option value="102">Nicole LeClerc</option>
                        </select>
                    </td>
                </tr>

                <input type="hidden" name="status" value="1">
            </table>
            <hr>
            <table style="width:100%">
                <tr>
                    <td>
                        <label class="control-label">Time</label>
                    </td>
                    <td style="position: relative">
                        <input type="text"  autocomplete="off" id="datetime" name="start" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="control-label">Comment</label>
                    </td>
                    <td>
                        <textarea rows="4" style="width: 100%;" type="text"  name="content" class="form-control"></textarea>
                    </td>
                </tr>
            </table>


            <input type="hidden" name="create_lead_iframe">
            <input type="hidden"  name="assigned_from" value="<?=(isset($_GET['assigned_from'])?$_GET['assigned_from']:'vici:error_getting_name');?>">
            <input type="hidden" name="me" value="<?=(isset($_GET['me'])?$_GET['me']:'null');?>">
            <button type="submit" class="submit-btn btn btn-warning  pull-right">Create</button>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#datetime').datetimepicker({
                    minDate: new Date(),
                    format: 'DD-MM-YYYY HH:mm:00',
                });
            });
        </script>

        <style media="screen">
            td {
                padding: 15px;
            }
            .submit-btn{
                background-color: black;
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                float: right;
            }
            input{
                width: 100%;
            }
            select{
                width: 100%;
            }
        </style>

        <?php
        //echo "test";

    }
}
