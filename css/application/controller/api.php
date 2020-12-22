<?php
//if(!isset($_SESSION['username'])){ header('Location:'.URL); return; };

/**
 * //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit(); debug sql
 */
use Twilio\Rest\Client;

class api extends Controller
{


    public function index()
    {
        echo "api v1";
    }


    public function transfer_back(){
        $lead_id=' ';
        $phone_number=' ';
        $retention_description=' ';
        $retention_name=' ';
        $assigned_from=' ';


         if (isset($_GET['lead_id'])){
             $lead_id=$_GET['lead_id'];
         }

        if (isset($_GET['phone_number'])){
            $phone_number=$_GET['phone_number'];
        }

        if (isset($_GET['retention_name'])){
            $retention_name=$_GET['retention_name'];
        }

        if (isset($_GET['retention_description'])){
            $retention_description=$_GET['retention_description'];
        }

        if (isset($_GET['assigned_from'])){
            $assigned_from=$_GET['assigned_from'];
        }


        // $check_sql="SELECT count(lead_id) as total FROM leads WHERE phone_number='$fullNr'";

        $sql="UPDATE leads SET assigned_to=:assigned_to,retention_description=:retention_description,retention_name=:retention_name WHERE phone_number=:phone_number";

        $query = $this->db->prepare($sql);
        $query->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $query->bindParam(':retention_name', $retention_name, PDO::PARAM_STR);
        $query->bindParam(':retention_description', $retention_description, PDO::PARAM_STR);
        $query->bindParam(':assigned_to', $assigned_from);


        $insertedLead = $query->execute();

        if ($insertedLead){
            header("location:https://any1coin.net/dashboard/operator/viewLead/".$lead_id."/?result=success");



            $sql="SELECT *  FROM leads_promo WHERE phone_number=:phone_number";
            $query=$this->db->prepare($sql);
            $query->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
            $query->execute();

            if ($query->rowCount()>0) {


                $sql = "UPDATE leads_promo SET lead_send=0,lead_back=1 WHERE phone_number=:phone_number";

                $query = $this->db->prepare($sql);
                $query->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
                $query->execute();

            }

            else
                {
                    $sql = "INSERT INTO leads_promo(`phone_number`,`assigned_to`,`lead_back`)
                               VALUES(:phone_number,:assigned_to,'1')";

                    $query = $this->db->prepare($sql);
                    $query->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
                    $query->bindParam(':assigned_to', $assigned_from);
                    $query->execute();
                }

        }
        else
        {
            echo 'error';
        }
    }






    
    public function transfer(){

        // if (isset($_GET['lead_id'])){
            $lead_id=$_GET['lead_id'];
        // }
        echo $lead_id;

        $sql='SELECT leads.*, evolutions.content FROM leads
                LEFT OUTER JOIN evolutions ON evolutions.lead_id = leads.lead_id
                WHERE (leads.lead_id=:lead_id)';
        $query = $this->db->prepare($sql);
        $query->bindParam(':lead_id', $lead_id);

        $query->execute();
        $lead=$query->fetch();
        
        // API URL
        $url = 'http://any1coin.net/dashboard/api/transfer';
        
        // Create a new cURL resource
        $ch = curl_init($url);
        
        // Setup request to send json via POST
        $data = array(
            'lead'=>$lead
        );
        $payload = json_encode(array("user" => $data));
        
        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        
        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        
        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute the POST request
        $result = curl_exec($ch);
        
        // Close cURL resource
        curl_close($ch);
    }
    
    
    public function wpregistrations(){
        // return 'hey';
        $registrations = $this->getRegistrations();

        $regArray = array();
//        return $this->checkIfUserExists(2);

        foreach ($registrations as $key=>$registra)
        {
//                                            each row
            if (isset($registra['user_id'])&&$registra['user_id']!=1)
            {
                if (!$this->checkIfUserExists($registra['user_id'])){
//                    echo $registra['user_id'];
                    $user_id=$registra['user_id'];
                    $user=$this->getUserData($user_id);
                    $regArray[$registra['user_id']]['user_id']=$registra['user_id'];
                    if ((isset($registra['meta_key'])&&$registra['meta_key']==='first_name')){
                        $first_name=$registra['meta_value'];
                        $regArray[$registra['user_id']]['first_name']=$registra['meta_value'];
                    }
                    if ((isset($registra['meta_key'])&&$registra['meta_key']==='last_name')){
                        $first_name=$registra['meta_value'];
                        $regArray[$registra['user_id']]['last_name']=$registra['meta_value'];
                    }
                    if ((isset($registra['meta_key'])&&$registra['meta_key']==='phone_number')){
                        $first_name=$registra['meta_value'];
                        $regArray[$registra['user_id']]['phone_number']=$registra['meta_value'];
                    }
                    if ((isset($registra['meta_key'])&&$registra['meta_key']==='Date')){
                        $first_name=$registra['meta_value'];
                        $regArray[$registra['user_id']]['Date']=$registra['meta_value'];
                    }
                    if ((isset($registra['meta_key'])&&$registra['meta_key']==='Time')){
                        $first_name=$registra['meta_value'];
                        $regArray[$registra['user_id']]['Time']=$registra['meta_value'];
                    }
                    if (isset($user)&&isset($user['user_email'])){
                        $regArray[$registra['user_id']]['email']=$user['user_email'];
                    }
                }
            }
        }
        // return $regArray;

        return $this->insertRegistrations($regArray);

        return $regArray;
    }

    public function insertRegistrations($regArray){
        foreach ($regArray as $reg){

            $sql = "INSERT INTO leads(`first_name`,`last_name`,`phone_number`, `email`, `source`, `academy_id`)
                               VALUES(:first_name,:last_name,:phone_number, :email, 'Academy', :academy_id)";

            $query = $this->db->prepare($sql);
            $query->bindParam(':first_name', $reg['first_name']);
            $query->bindParam(':last_name',$reg['last_name']);
            $query->bindParam(':phone_number', $reg['phone_number']);
            $query->bindParam(':email', $reg['email']);
            $query->bindParam(':academy_id', $reg['user_id']);

            $insertedLead = $query->execute();
            //error handler
//            if ($query->execute()) {
//                $lead_id=$this->db->lastInsertId();
//                header('location: viewLead/'.$this->db->lastInsertId());
//                $_SESSION['create_lead']='success';
//            } else {
//                $_SESSION['create_lead']='fail';
//                header("location:".URL.$_SESSION['role'].'/leads');
//            }

//            return $insertedLead;

//            return $this->db->lastInsertId();
            $this->insertAcademyIntoReminders($reg, $this->db->lastInsertId());

        }
    }

    public function insertAcademyIntoReminders($reg, $lead_id){

            $date=$this->formatDate($reg['Date'], $reg['Time']);
            $sql="INSERT INTO reminders(title,content,start,lead_id,description,color) VALUES(:title,:content,:start,:lead_id,'',:color)";
            $query = $this->db->prepare($sql);
            $parameters=array(
                ':title' => $reg['first_name'].' '.$reg['last_name'],
                ':content' => 'Academy Registration',
                ':start' => $date,
                ':lead_id' => $lead_id,
//                ':user_id' => $_SESSION['user_id'],
                ':color'  => 'green'
            );
            $query->execute($parameters);

            //log cheanges
//            $sql="INSERT INTO log(user_id,lead_id,diff,ip) VALUES(:user_id,:lead_id,:diff,:ip)";
//            $query=$this->db->prepare($sql);
//            $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
//            $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
//            $query->bindValue(':diff',"New Reminder : ".$_POST['content']." | ".$_POST['start']);
//            $query->bindParam(':ip', $ip);
//            $query->execute();

            $_SESSION['addTask']='success';
    }
        //  print_r($_POST['start']);
//        header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);

    public function formatDate($date, $time){
        $onlyDate = str_replace("/", "-", $date);
        $formattedDate = $onlyDate.' '.$time;
        return $formattedDate;
    }

    public function getRegistrations(){

        $dsn = "mysql:host=localhost;dbname=gbphyxfz_academ";
        $user = "gbphyxfz_academ";
        $passwd = "9x@pF8dS.8";

        $pdo = new PDO($dsn, $user, $passwd);

        $stm = $pdo->query("SELECT * FROM wpby_usermeta");

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserData($user_id){
        $dsn = "mysql:host=localhost;dbname=gbphyxfz_academ";
        $user = "gbphyxfz_academ";
        $passwd = "9x@pF8dS.8";

        $pdo = new PDO($dsn, $user, $passwd);

        $stm = $pdo->query("SELECT * FROM wpby_users WHERE ID=".$user_id);

//        $query = $this->db->prepare($stm);
//        $query->bindParam(':user_id', $user_id);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function checkIfUserExists($user_id){
        $sql="SELECT count(lead_id) FROM leads WHERE academy_id=:user_id";
        $query=$this->db->prepare($sql);
        $query->execute(array(':user_id' => $user_id));
        $lead_count = $query->fetch(PDO::FETCH_NUM);
//        return $lead_count;
//        return $lead_count;
        if ($lead_count[0]){
            return true;
        }
        else
        {
            return false;
        }
    }



        public function fetch_numbers(){
        if (isset($_GET['name'])){
            $name=$_GET['name'];
        }
        if (isset($_GET['email'])){
            $email=$_GET['email'];
        }
        if (isset($_GET['phone'])){
            $phone=$_GET['phone'];
        }

        // $check_sql="SELECT count(lead_id) as total FROM leads WHERE phone_number='$fullNr'";

        $sql = "INSERT INTO leads(`first_name`,`last_name`,`phone_number`, `email`,`list_id`, `source`)
                               VALUES(:first_name,' ','39' :phone_number, :email, 65 , 'SMS')";

        $query = $this->db->prepare($sql);
        $query->bindParam(':first_name', $name, PDO::PARAM_STR);
        $query->bindParam(':phone_number', $phone, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        $insertedLead = $query->execute();
        
        if ($insertedLead){
            echo 'success';
        }
        else
        {
            echo 'error';
        }
    }

    public function getUncheckedLeads(){
        $sql="SELECT COUNT(lead_id) FROM leads WHERE checked='false'";
        $query=$this->db->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function call(){

    }

    public function getCV(){
        $sql="SELECT *  FROM cv WHERE `user_id`=:user_id";
        $query=$this->db->prepare($sql);
        $query->execute(array(':user_id' =>$_SESSION['user_id']));
        $cv=$query->fetch();
        if (!$cv) {
          echo  "File do not exist in database!";
          return;
        }
      $target_dir = APP."cv/";
        //  print_r($cv);
      $target_file = $target_dir . basename($cv->url);
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
                      header("Content-Disposition: attachment; filename=\"".$cv->url."\"");
                      readfile($target_file);
          break;
                  case 'csv':
                      header("Content-type: text/csv");
                      header('Content-disposition: attachment; filename="'.$cv->url.'"');
                      readfile($target_file);
                  break;
        };
      } else{
        echo "File do not exist in server!";
      }
    }


    public function deleteDocument($document_id){
      if($_SESSION['role']!='admin') { header('Location:'.URL); return; };
      $sql="SELECT *  FROM documents WHERE `document_id`=:document_id";
      $query=$this->db->prepare($sql);
      $query->bindParam(':document_id',$document_id);
      $query->execute();
      $document=$query->fetch();
      //print_r($document);
      if (!$document) {
        echo  "File do not exist in database!";
        return;
      }
      //$file = APP."documents/".$_POST['url'];
      $file=$document->url;
      $sql = "DELETE FROM documents WHERE document_id=:document_id";
      $query = $this->db->prepare($sql);
      $query->bindParam(':document_id',$document_id,PDO::PARAM_INT);
      if ($query->execute()) {
         echo "success";
         unlink($file);
      }else{
          echo "error";
      }

      header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

    public function deleteUpload($document_id){
      if($_SESSION['role']!='admin') { header('Location:'.URL); return; };
      $sql="SELECT *  FROM uploads WHERE `document_id`=:document_id";
      $query=$this->db->prepare($sql);
      $query->bindParam(':document_id',$document_id);
      $query->execute();
      $document=$query->fetch();
      //print_r($document);
      if (!$document) {
        echo  "File do not exist in database!";
        return;
      }
      //$file = APP."documents/".$_POST['url'];
      $file=$document->url;
      $sql = "DELETE FROM uploads WHERE document_id=:document_id";
      $query = $this->db->prepare($sql);
      $query->bindParam(':document_id',$document_id,PDO::PARAM_INT);
      if ($query->execute()) {
         echo "success";
         unlink($file);
      }else{
          echo "error";
      }

      header("Location: " . $_SERVER["HTTP_REFERER"]);
  }

    public function getDocumentA($document_id){
      if($_SESSION['role']!='admin') { header('Location:'.URL); return; };
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
        case "pdf":
          header("content-type: application/pdf");
          readfile($target_file);
        }

      } else{
        echo "File do not exist in server!";
      }
    }

    public function getUploadA($document_id){

        $sql="UPDATE uploads SET seen=1,seen_time=CURRENT_TIMESTAMP WHERE `document_id`=:document_id and `seen_time` IS NULL";
        $query=$this->db->prepare($sql);
        $query->execute(array(':document_id' =>$document_id));
        $document=$query->fetch();
        $sql="SELECT *  FROM uploads WHERE `document_id`=:document_id";
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
        case "pdf":
          header("content-type: application/pdf");
          readfile($target_file);
        }

      } else{
        echo "File do not exist in server!";
      }
    }


    public function getUploadAdmin($document_id){

        $sql="SELECT *  FROM uploads WHERE `document_id`=:document_id";
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
                case "pdf":
                    header("content-type: application/pdf");
                    readfile($target_file);
            }

        } else{
            echo "File do not exist in server!";
        }
    }

    public function getDocument($document_id){
      //if($_SESSION['role']!='admin') { header('Location:'.URL); return; };
      $sql="SELECT *  FROM documents WHERE `document_id`=:document_id and user_id=:user_id";
      $query=$this->db->prepare($sql);
      $query->execute(array(':document_id' =>$document_id,'user_id'=>$_SESSION['user_id']));
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
        case "pdf":
          header("content-type: application/pdf");
          readfile($target_file);
        }

      } else{
        echo "File do not exist in server!";
      }
    }

    public function logCall($direction){
      switch ($direction) {
        case 'in':
            $phone_number=str_replace("+", "", $_POST['phone_number']);
            $phone_number=ltrim($phone_number, '0');
            $sql="SELECT lead_id,first_name,last_name FROM leads WHERE phone_number like :phone_number or alt_number like :phone_number limit 1";
            $query=$this->db->prepare($sql);
            $query->execute(array('phone_number'=>$phone_number));
            $lead=$query->fetch();
            //print_r($lead);
            if (!isset($lead->lead_id)) {
              $lead_id=0;
              $output=$_POST['phone_number'];
            }else{
              $lead_id=$lead->lead_id;
              $output=$lead->first_name." ".$lead->last_name;
            }
            $sql="INSERT INTO call_log (lead_id,phone_number,direction,user_id) VALUES (:lead_id,:phone_number,:direction,:user_id)";
            $query=$this->db->prepare($sql);
            $query->execute(array('lead_id'=>$lead_id,'phone_number'=>$phone_number,'direction'=>$direction,'user_id'=>$_SESSION['user_id']));

            echo  $output;
          break;
        case 'out':
              if (!isset($_POST['from_number'])) {
                $_POST['from_number']="";
              }
            $sql="INSERT INTO call_log (lead_id,phone_number,direction,user_id,from_number) VALUES (:lead_id,:phone_number,:direction,:user_id,:from_number)";
            $query=$this->db->prepare($sql);
            $query->execute(array('lead_id'=>$_POST['phone_number'],'phone_number'=>$_POST['phone_number'],'direction'=>$direction,'user_id'=>$_SESSION['user_id'],'from_number'=>$_POST['from_number']));
          break;

        default:
          // code...
          break;
      }

      return;
    }

    public function getTasks(){
        $sql="SELECT * FROM tasks WHERE tasks.status='Pending' and user_id=:user_id order by task_id desc";
        $query=$this->db->prepare($sql);
        $query->execute(array('user_id' => $_SESSION['user_id']));
        echo json_encode($query->fetchAll());
    }

    public function getCustomer1MonthReminder(){
        $sql="SELECT * FROM Customer1MonthReminder WHERE Customer1MonthReminder.seen='0' and Customer1MonthReminder.start<NOW() and user_id=:user_id order by Customer1MonthReminder_id desc";
        $query=$this->db->prepare($sql);
        $query->execute(array('user_id' => $_SESSION['user_id']));
        echo json_encode($query->fetchAll());
    }

    public function getEvents(){
        $sql="SELECT * FROM events WHERE events.status='Pending' and user_id=:user_id order by event_id desc";
        $query=$this->db->prepare($sql);
        $query->execute(array('user_id' => $_SESSION['user_id']));
        echo json_encode($query->fetchAll());
    }

    public function getReminders(){
        $sql="SELECT * FROM reminders WHERE reminders.status='Pending' and user_id=:user_id order by reminder_id desc";
        $query=$this->db->prepare($sql);
        $query->execute(array('user_id' => $_SESSION['user_id']));
        echo json_encode($query->fetchAll());
    }


    public function getTasksAdmin(){
        $sql="SELECT * FROM tasks WHERE tasks.status='Pending' order by task_id desc";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll());
    }



    public function getTasksTeamleader(){
        $sql="SELECT tasks.task_id,tasks.title,tasks.content,tasks.description,tasks.user_id,tasks.lead_id,tasks.date_created,tasks.start,tasks.status,tasks.seen,tasks.color FROM tasks LEFT JOIN users ON tasks.user_id = users.user_id WHERE users.supervisor = ".$_SESSION['user_id']." AND tasks.status='Pending' order by task_id desc";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll());
    }


    public function getRemindersAdmin(){
        $sql="SELECT * FROM reminders WHERE reminders.status='Pending' order by reminder_id desc";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll());
    }


    public function getRemindersTeamleader(){
        $sql="SELECT reminders.reminder_id,reminders.title,reminders.content,reminders.description,reminders.user_id,reminders.lead_id,reminders.date_created,reminders.start,reminders.status,reminders.seen,reminders.color FROM reminders LEFT JOIN users ON reminders.user_id = users.user_id WHERE users.supervisor = 12 AND reminders.status='Pending' order by reminder_id desc";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll());
    }


    public function getEventsAdmin(){
        $sql="SELECT * FROM events WHERE events.status='Pending' order by event_id desc";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll());
    }


    public function getEventsTeamleader(){
        $sql="SELECT events.event_id,events.title,events.content,events.description,events.user_id,events.lead_id,events.date_created,events.start,events.status,events.seen,events.color FROM events LEFT JOIN users ON events.user_id = users.user_id WHERE users.supervisor = 12 AND events.status='Pending' order by event_id desc";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll());
    }

    public function countLeadsAdmin(){
        $sql="SELECT count(lead_id) as count FROM leads
        LEFT OUTER JOIN users  ON users.user_id = leads.assigned_to
        WHERE
        users.recycle = 0
        ";
        $query=$this->db->prepare($sql);
        $query->execute();
        $count=$query->fetch(PDO::FETCH_OBJ);

        $sql1="SELECT count(lead_id) as count FROM leads
        WHERE
        assigned_to = ''
        ";
        $query1=$this->db->prepare($sql1);
        $query1->execute();
        $count1=$query1->fetch(PDO::FETCH_OBJ);

        echo $count->count+$count1->count;
    }

    public function countRecycle(){
        $sql="SELECT count(lead_id) as count FROM leads
        LEFT JOIN users  ON users.user_id = leads.assigned_to
        WHERE
        users.recycle =1";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetch());
    }

    public function countRecycleSupport(){
        $sql="SELECT count(lead_id) as count FROM leads
        LEFT JOIN users  ON users.user_id = leads.assigned_to
        WHERE
        users.recycle =1 AND  leads.assigned_to=0 AND leads.source='Appointment'";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetch());
    }


    function sendSMS(){
          $phone_number='+'.trim($_REQUEST['pn']);
          // print_r($phone_number);
          //$phone_number="+355683546168";
          // Require the bundled autoload file - the path may need to change
          // based on where you downloaded and unzipped the SDK
          require __DIR__.'/twilio-php-master/Twilio/autoload.php';
          echo "SMS sending failed! Please check phone number!";
          // Use the REST API Client to make requests to the Twilio REST API


          // Your Account SID and Auth Token from twilio.com/console
          $sid = T_SID;
          $token = T_TOKEN;
          $client = new Client($sid, $token);

          // Use the client to do fun stuff like send text messages!
        try {
              $client->messages->create(
                  // the number you'd like to send the message to
                  $phone_number,
                  array(
                      // A Twilio phone number you purchased at twilio.com/console
                      'from' => $_REQUEST['out_number'],
                      // the body of the text message you'd like to send
                      'body' => $_REQUEST['sms_body']
                  )
              );
            $_SESSION['sms_sent']="success";


        } catch (TwilioException $e) {
              echo ( $e->getCode() . ' : ' . $e->getMessage() );
            $_SESSION['sms_sent']="fail";
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
          header("Location: " . $_SERVER["HTTP_REFERER"]);

    }

    function sendEmail(){
          $to=trim($_REQUEST['to']);
          $to_name=$_REQUEST['to_name'];

          $from=$_REQUEST['from'];
          $from_name=$_REQUEST['from_name'];

          $subject=$_REQUEST['subject'];
          $body=$_REQUEST['body'];

          require __DIR__.'/sendgrid-php-master/vendor/autoload.php';

          $email = new \SendGrid\Mail\Mail();
          $email->setFrom($from,$from_name);
          $email->setSubject($subject);
          $email->addTo($to,$to_name);
          $email->addContent("text/html",$body);
          // $email->addContent(
          //     "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
          // );
          $sendgrid = new \SendGrid(SENDGRID_API_KEY);
          try {
              $response = $sendgrid->send($email);
              print $response->statusCode() . "\n";
              print_r($response->headers());
              print $response->body() . "\n";
              $_SESSION['email_sent']="success";
          } catch (Exception $e) {
              echo 'Caught exception: '. $e->getMessage() ."\n";
              $_SESSION['email_sent']="fail";
          }
           header("Location: " . $_SERVER["HTTP_REFERER"]);

        $sql = "INSERT INTO emails(user_id,client_name,client_email,subject,message) VALUES(:user_id,:client_name,:client_email,:subject,:message)";
        $query = $this->db->prepare($sql);
        $query->bindParam(':user_id', $_SESSION['user_id']);
        $query->bindParam(':client_name', $_POST['to_name']);
        $query->bindParam(':client_email', $_POST['to']);
        $query->bindParam(':subject', $_POST['subject']);
        $query->bindParam(':message', $_POST['body']);
        if ($query->execute()) {
            echo "success";
        }else{
            echo "error";
        }

    }



    public function countLeads(){
        $sql="SELECT count(lead_id) as count FROM leads where assigned_to=:assigned_to ";
        $query=$this->db->prepare($sql);
        $query->execute(array('assigned_to' => $_SESSION['user_id']));
        echo json_encode($query->fetch());
    }

    public function countLeadsC(){
        $sql="SELECT count(lead_id) as count FROM leads where assigned_to='67' ";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetch());
    }

    public function countNewLeads(){
        $sql="SELECT new_leads as count FROM users where user_id=:user_id";
        $query=$this->db->prepare($sql);
        $query->execute(array('user_id' => $_SESSION['user_id']));
        echo json_encode($query->fetch());
    }

    public function countLeadsCustomer(){
        $sql="SELECT count(lead_id) as count FROM leads
        LEFT JOIN users  ON users.user_id = leads.assigned_to
        WHERE
        (users.recycle =0 OR leads.assigned_to=0) AND status='15' ";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetch());
    }

    public function resetNewLeads(){
      $sql="UPDATE users SET new_leads=0 WHERE user_id=:operator";
      $query=$this->db->prepare($sql);
      $query->bindParam(':operator', $_SESSION['user_id']);
      $query->execute();
    }
    public function countLeadsSupport(){
        $sql="SELECT count(lead_id) as count FROM leads
        WHERE
        leads.assigned_to='0' AND leads.source='Appointment' ";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetch());
    }



    public function notifications(){
        $sql="SELECT * FROM tasks WHERE seen=0 AND status='Pending' AND user_id=:user_id AND `start`< NOW() ";
        $query=$this->db->prepare($sql);
        $query->execute(array('user_id' =>$_SESSION['user_id']));
        $notifications=$query->fetchAll();
        echo json_encode($notifications);
    }


    public function notificationsEvents(){
        $sql="SELECT * FROM events WHERE seen=0 AND status='Pending' AND user_id=:user_id AND `start`< NOW() ";
        $query=$this->db->prepare($sql);
        $query->execute(array('user_id' =>$_SESSION['user_id']));
        $notifications=$query->fetchAll();
        echo json_encode($notifications);
    }

    public function notificationsReminders(){
        $sql="SELECT * FROM reminders WHERE seen=0 AND status='Pending' AND user_id=:user_id AND `start`< NOW() ";
        $query=$this->db->prepare($sql);
        $query->execute(array('user_id' =>$_SESSION['user_id']));
        $notifications=$query->fetchAll();
        echo json_encode($notifications);
    }

    public function setSeen($task_id){
      $sql="UPDATE tasks set seen=1 where task_id=:task_id";
      $query=$this->db->prepare($sql);
      $query->execute(array('task_id'=>$task_id));
    }

    public function setSeenEvent($event_id){
      $sql="UPDATE events set seen=1 where event_id=:event_id";
      $query=$this->db->prepare($sql);
      $query->execute(array('event_id'=>$event_id));
    }
    public function setSeenReminder($reminder_id){
      $sql="UPDATE reminders set seen=1 where reminder_id=:reminder_id";
      $query=$this->db->prepare($sql);
      $query->execute(array('reminder_id'=>$reminder_id));
    }

    public function deleteNote($note_id){
      $sql="DELETE from notes where note_id=:note_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('note_id'=>$note_id));
    }

    public function deleteEvolution($note_id){
      $sql="DELETE from evolutions where evolution_id=:evolution_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('evolution_id'=>$evolution_id));
    }

    public function deleteReminder($reminder_id){
      $sql="DELETE from reminders where reminder_id=:reminder_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('reminder_id'=>$reminder_id));
    }

    public function deleteTask($task_id){
      $sql="DELETE from tasks where task_id=:task_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('task_id'=>$task_id));
    }

    public function deleteEvent($event_id){
      $sql="DELETE from events where event_id=:event_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('event_id'=>$event_id));
    }

    public function editNote($note_id){
      $sql="UPDATE notes SET content=:content where note_id=:note_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('note_id'=>$note_id,'content'=>$_POST['content']));


    }

    public function editMental(){

      $sql="UPDATE leads SET mental=:mental where lead_id=:lead_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('lead_id'=>$_POST['lead_id'],'mental'=>$_POST['mental']));

      if ($_POST['mental']=='Self Respect') {
        $sql="UPDATE leads SET assigned_to='0' where lead_id=:lead_id limit 1";
        $query=$this->db->prepare($sql);
        $query->execute(array('lead_id'=>$_POST['lead_id']));

        $sql="UPDATE users SET new_leads=new_leads+1 WHERE role='customer'";
        $query=$this->db->prepare($sql);
        $query->execute();

        $this->addCustomer1MonthReminder($_POST['lead_id']);
      }
    }


    public function editSource(){

        $sql="UPDATE leads SET source=:source where lead_id=:lead_id limit 1";
        $query=$this->db->prepare($sql);
        $query->execute(array('lead_id'=>$_POST['lead_id'],'source'=>$_POST['source']));

    }



    public function editWebform(){

      $sql="UPDATE leads SET webform=:webform where lead_id=:lead_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('lead_id'=>$_POST['lead_id'],'webform'=>$_POST['webform']));

    }


    public function editName(){

      $sql="UPDATE leads SET first_name=:first_name where lead_id=:lead_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('lead_id'=>$_POST['lead_id'],'first_name'=>$_POST['name']));

    }


    public function editSurname(){

      $sql="UPDATE leads SET last_name=:last_name where lead_id=:lead_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('lead_id'=>$_POST['lead_id'],'last_name'=>$_POST['surname']));

    }


    public function editPhone(){

      $sql="UPDATE leads SET phone_number=:phone_number where lead_id=:lead_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('lead_id'=>$_POST['lead_id'],'phone_number'=>$_POST['phone_number']));

    }

    public function editAltPhone(){

      $sql="UPDATE leads SET alt_number=:alt_number where lead_id=:lead_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('lead_id'=>$_POST['lead_id'],'alt_number'=>$_POST['alt_number']));

    }

    public function editEmail(){

        $sql="UPDATE leads SET email=:email where lead_id=:lead_id limit 1";
        $query=$this->db->prepare($sql);
        $query->execute(array('lead_id'=>$_POST['lead_id'],'email'=>$_POST['email']));

    }



    public function editNoteFinal(){

        $sql="UPDATE leads SET note=:note where lead_id=:lead_id limit 1";
        $query=$this->db->prepare($sql);
        $query->execute(array('lead_id'=>$_POST['lead_id'],'note'=>$_POST['note']));

        $sql="UPDATE leads SET last_change=now() WHERE lead_id=:lead_id";
        $query=$this->db->prepare($sql);
        $query->execute(array('lead_id'=>$_POST['lead_id']));
        $query->execute();

    }










    public function login_test(){
//        $columns = array('id', 'user_id', 'log_time', 'type');

        $assigned_retention=' ';
        $assigned_from=' ';

        if (isset($_GET['lead_id'])){
            $lead_id=$_GET['lead_id'];
        }

        if (isset($_GET['first_name'])){
            $name=$_GET['first_name'];
        }
        if (isset($_GET['last_name'])){
            $last_name=$_GET['last_name'];
        }
        if (isset($_GET['email'])){
            $email=$_GET['email'];
        }
        if (isset($_GET['phone_number'])){
            $phone=$_GET['phone_number'];
        }
        if (isset($_GET['source'])){
            $source=$_GET['source'];
        }
        if (isset($_GET['status'])){
            $status=$_GET['status'];
        }

        if (isset($_GET['data_sheets'])){
            $data_sheets=$_GET['data_sheets'];
        }

        if (isset($_GET['assigned_retention'])){
            $assigned_retention=$_GET['assigned_retention'];
        }

        if (isset($_GET['assigned_from'])){
            $assigned_from=$_GET['assigned_from'];
        }

        // $check_sql="SELECT count(lead_id) as total FROM leads WHERE phone_number='$fullNr'";
//
//        $sql = "INSERT INTO leads(`first_name`,`last_name`,`phone_number`, `email`, `source`, `status`,`rating`, `data_sheets`, `assigned_to`, `assigned_from`)
//                               VALUES(:first_name, :last_name, :phone_number, :email, 'Promo', '3', '4', :data_sheets, :assigned_to, :assigned_from)";
//
//        $query = $this->db->prepare($sql);
//        $query->bindParam(':first_name', $name, PDO::PARAM_STR);
//        $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
//        $query->bindParam(':phone_number', $phone, PDO::PARAM_STR);
//        $query->bindParam(':email', $email, PDO::PARAM_STR);
//        $query->bindParam(':data_sheets', $data_sheets, PDO::PARAM_STR);
//        $query->bindParam(':assigned_to', $assigned_retention);
//        $query->bindParam(':assigned_from', $assigned_from, PDO::PARAM_STR);

//        $insertedLead = $query->execute();


        $query = "SELECT * FROM access_logs WHERE ";

        if (isset($_POST["is_date_search"])) {
            if ($_POST["is_date_search"] === "yes") {
                $query .= 'log_time BETWEEN "' . $_POST["start_date"] . '" AND "' . $_POST["end_date"] . '" AND ';
            }
        }

        if(isset($_POST["search"]["value"]))
        {
            $query .= '
              (id LIKE "%'.$_POST["search"]["value"].'%" )
             ';
        }

//            $query .= 'ORDER BY log_time DESC ';

        $query1 = '';

        $q = $this->db->prepare($query);
//        $query->bindParam(':first_name', $name, PDO::PARAM_STR);
//        $query->bindParam(':last_name', $last_name, PDO::PARAM_STR);
//        $query->bindParam(':phone_number', $phone, PDO::PARAM_STR);
//        $query->bindParam(':email', $email, PDO::PARAM_STR);
//        $query->bindParam(':data_sheets', $data_sheets, PDO::PARAM_STR);
//        $query->bindParam(':assigned_to', $assigned_retention);
//        $query->bindParam(':assigned_from', $assigned_from, PDO::PARAM_STR);

        $insertedLead = $q->execute();

        $notes=$q->fetchAll();
//        $number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

//        $result = mysqli_query($connect, $query . $query1);

//        $data = array();
//
//        while($row = mysqli_fetch_array($result))
//        {
//            $sub_array = array();
//            $sub_array[] = $row["id"];
//            $sub_array[] = $row["user_id"];
//            $sub_array[] = $row["log_time"];
//            $sub_array[] = $row["type"];
//            $data[] = $sub_array;
//        }
//
//        function get_all_data($connect)
//        {
//            $query = "SELECT * FROM access_logs";
//            $result = mysqli_query($connect, $query);
//            return mysqli_num_rows($result);
//        }

        $output = array(
//            "draw"    => intval($_POST["draw"]),
//            "recordsTotal"  =>  get_all_data($connect),
//            "recordsFiltered" => $number_filter_row,
        'query' => $query,
            "data"    => $notes
        );

        echo json_encode($notes);

    }
    
    public function getQuickLead($lead_id){
        $sql="SELECT *  FROM leads
        WHERE lead_id=:lead_id";
        $query=$this->db->prepare($sql);
        $query->bindParam(':lead_id',$lead_id);
        $query->execute();
        $lead=$query->fetch();

        $sql2="SELECT *  FROM notes
        WHERE lead_id=:lead_id LIMIT 5";
        $query2=$this->db->prepare($sql2);
        $query2->bindParam(':lead_id',$lead_id);
        $query2->execute();
        $notes=$query2->fetchAll();

        $sql3="SELECT *  FROM log
        WHERE lead_id=:lead_id  order by `date` desc  LIMIT 5";
        $query3=$this->db->prepare($sql3);
        $query3->bindParam(':lead_id',$lead_id);
        $query3->execute();
        $activites=$query3->fetchAll();

        $sql4="SELECT *  FROM users";
        $query4=$this->db->prepare($sql4);
        $query4->bindParam(':lead_id',$lead_id);
        $query4->execute();
        $users=$query4->fetchAll();

        $sql5="SELECT *  FROM status";
        $query5=$this->db->prepare($sql5);
        $query5->bindParam(':lead_id',$lead_id);
        $query5->execute();
        $status=$query5->fetchAll();

        $assignedTo='';
        foreach($users as $user){
            if ($user->user_id==$lead->assigned_to)
            {
                $assignedTo=$user->username;
//                break;
            }
        }

        $statusLead='';
        foreach($status as $stat){
            if ($stat->status_id==$lead->status)
            {
                $statusLead=$stat->status_name;
            }
        }

        $output=array();
        array_push($output, $lead);
        array_push($output, $notes);
        array_push($output, $activites);
        array_push($output, $assignedTo);
        array_push($output, $statusLead);
        echo json_encode($output);

    }




    public function quickViewEmail($id){
        $sql="SELECT *  FROM emails WHERE id=:id";
        $query=$this->db->prepare($sql);
        $query->bindParam(':id',$id);
        $query->execute();
        $lead=$query->fetch();

        $output=array();
        array_push($output, $lead);
        echo json_encode($output);

    }


















    public function setPreferito(){

        $sql="UPDATE leads SET preferito=:preferito where lead_id=:lead_id";
        $query=$this->db->prepare($sql);
        $query->execute(array('lead_id'=>$_POST['lead_id'], 'preferito'=>$_POST['preferito']));
    }

    public function editListName($list_id){
      $sql="UPDATE lists SET list_name=:content where list_id=:list_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('list_id'=>$list_id,'content'=>$_POST['content']));
    }

    public function editListSource($list_id){
      $sql="UPDATE lists SET source=:source where list_id=:list_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('list_id'=>$list_id,'source'=>$_POST['content']));

      $sql="UPDATE leads SET source=:source where list_id=:list_id";
      $query=$this->db->prepare($sql);
      $query->execute(array('list_id'=>$list_id,'source'=>$_POST['content']));
    }

    public function editEvolution($note_id){
      $sql="UPDATE evolutions SET content=:content where evolution_id=:evolution_id limit 1";
      $query=$this->db->prepare($sql);
      $query->execute(array('evolution_id'=>$note_id,'content'=>$_POST['content']));
    }

    public function setTaskStatus($task_id,$status="Completed"){
      $sql="UPDATE tasks set status=:status where task_id=:task_id";
      $query=$this->db->prepare($sql);
      $query->execute(array('task_id'=>$task_id,'status'=>$status));
    }

    public function setEventStatus($event_id,$status="Completed"){
      $sql="UPDATE events set status=:status where event_id=:event_id";
      $query=$this->db->prepare($sql);
      $query->execute(array('event_id'=>$event_id,'status'=>$status));
    }

    public function setReminderStatus($reminder_id,$status="Completed"){
      $sql="UPDATE reminders set status=:status where reminder_id=:reminder_id";
      $query=$this->db->prepare($sql);
      $query->execute(array('reminder_id'=>$reminder_id,'status'=>$status));
    }


    function bulk($action){
      $ids = json_decode(urldecode($_POST['ids']));//decode all lead ids
      if (isset($_POST['limit'])) {
        if ($_POST['limit']!='') {
          array_splice($ids,(int)$_POST['limit']);
        }
      }
      $c=count($ids);
      switch ($action) {
        case 'assign_to':
              $operator=$_POST['operator'];

//                $sql="UPDATE users SET new_leads=new_leads+:c WHERE user_id=:operator";
//                $query=$this->db->prepare($sql);
//                $query->bindParam(':operator',$operator);
//                $query->bindParam(':c', $c);
//                $query->execute();

                foreach ($ids as $key => $id) {
                    $sql="UPDATE leads SET assigned_to=:operator WHERE lead_id=:id";
                    $query=$this->db->prepare($sql);
                    $query->bindParam(':id', $id);
                    $query->bindParam(':operator', $operator);
                    $query->execute();


                    $sql="INSERT INTO new_leads(lead_id, assigned_to) VALUES(:id,:operator)";
                    $query=$this->db->prepare($sql);
                    $query->bindParam(':id', $id);
                    $query->bindParam(':operator', $operator);
                    $query->execute();


                    $sql="UPDATE leads SET last_change=now() WHERE lead_id=:lead_id";
                    $query=$this->db->prepare($sql);
                    $query->bindParam(':lead_id', $id);
                    $query->execute();
                }//foreach end
                $_SESSION['assigned_to']='success';
          break;
          case 'delete':
                foreach ($ids as $key => $id) {
                  $sql="DELETE FROM leads WHERE lead_id=:id"; echo $id;
                  $query=$this->db->prepare($sql);
                  $query->bindParam(':id', $id);
                  $query->execute();

                  $sql="DELETE FROM notes WHERE lead_id=:id"; echo $id;
                  $query=$this->db->prepare($sql);
                  $query->bindParam(':id', $id);
                  $query->execute();

                  $sql="DELETE FROM tasks WHERE lead_id=:lead_id";
                  $query = $this->db->prepare($sql);
                  $query->execute(array(':lead_id' =>  $id));

                  $sql="DELETE FROM events WHERE lead_id=:lead_id";
                  $query = $this->db->prepare($sql);
                  $query->execute(array(':lead_id' =>  $id));

                  $sql="DELETE FROM `log` WHERE lead_id=:lead_id";
                  $query = $this->db->prepare($sql);
                  $query->execute(array(':lead_id' =>  $id));

                  $sql="UPDATE leads SET last_change=now() WHERE lead_id=:lead_id";
                  $query=$this->db->prepare($sql);
                  $query->bindParam(':lead_id', $id);
                  $query->execute();
                }
                $_SESSION['deleted']='success';
            break;
          case 'edit':
          $q="";
              if ($_POST['note0']!='') {
                $q.="note='".$_POST['note0']."',";
              }
              if ($_POST['data_sheets0']!='') {
                $q.="data_sheets='".$_POST['data_sheets0']."',";
              }
              if ($_POST['brand0']!='') {
                $q.="brand='".$_POST['brand0']."',";
              }
              if ($_POST['source0']!='') {
                $q.="source='".$_POST['source0']."',";
              }
              if ($_POST['list0']!='') {
                  $q.="list_id='".$_POST['list0']."',";
              }

              if ($_POST['status0']!='') {
                $q.="status='".$_POST['status0']."',";
                if ($_POST['status0']==15) {
                  $sql="UPDATE users SET new_leads=new_leads+:c WHERE role='customer'";
                  $query=$this->db->prepare($sql);
                  $query->bindParam(':c', $c);
                  $query->execute();
                }
              }
              if ($_POST['assigned_to0']!='') {
                $q.="assigned_to='".$_POST['assigned_to0']."',";

              }
              $q=rtrim($q, ',');

              foreach ($ids as $key => $id) {
                $sql="UPDATE leads SET ".$q." WHERE lead_id=:lead_id";
                $query=$this->db->prepare($sql);
                $query->bindParam(':lead_id', $id);
                $query->execute();

                if ($_POST['assigned_to0']!=''){
                    $sql="INSERT INTO new_leads(lead_id, assigned_to) VALUES(:id,:operator)";
                    $query=$this->db->prepare($sql);
                    $query->bindParam(':id', $id);
                    $query->bindParam(':operator', $_POST['assigned_to0']);
                    $query->execute();
                }

                $sql="UPDATE leads SET last_change=now() WHERE lead_id=:lead_id";
                $query=$this->db->prepare($sql);
                $query->bindParam(':lead_id', $id);
                $query->execute();
              }//foreach end
            break;
        default:
          // code...
          break;
      }

    }

    public function editStatus(){
    	//get old status
		$sql='SELECT s.status_name FROM leads  inner join status s ON s.status_id=leads.status  WHERE lead_id=:lead_id LIMIT 1';
        $query = $this->db->prepare($sql);
        $query->bindParam(':lead_id',$_POST['lead_id'],PDO::PARAM_INT);
        $query->execute();
        $oldstatus=$query->fetch();
        //if($_SESSION['role']!='backoffice' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $sql = "UPDATE leads SET status=:status_id WHERE lead_id=:lead_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':status_id', $_POST['status_id'],PDO::PARAM_INT);
        $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
        if ($query->execute()) {
            if ($_POST['status_id']==15) {
              $sql="UPDATE users SET new_leads=new_leads+1 WHERE role='customer'";
              $query=$this->db->prepare($sql);
              $query->execute();

              $sql="UPDATE leads SET assigned_to='0' where lead_id=:lead_id limit 1";
              $query=$this->db->prepare($sql);
              $query->execute(array('lead_id'=>$_POST['lead_id']));

              // $this->addCustomer1MonthReminder($_POST['lead_id']);
            }

//            if status = superbia
            else if ($_POST['status_id']==17) {
              $sql="UPDATE users SET new_leads=new_leads+1 WHERE role='customer'";
              $query=$this->db->prepare($sql);
              $query->execute();

              $sql="UPDATE leads SET assigned_to='0' where lead_id=:lead_id limit 1";
              $query=$this->db->prepare($sql);
              $query->execute(array('lead_id'=>$_POST['lead_id']));

               $this->addCustomer1MonthReminder($_POST['lead_id']);
            }

            else if ($_POST['status_id']==8) {
                $sql="UPDATE leads SET assigned_to='26' where lead_id=:lead_id limit 1";
                $query=$this->db->prepare($sql);
                $query->execute(array('lead_id'=>$_POST['lead_id']));

                $sql="INSERT INTO leads_remove_report(user_id,lead_id,status_id) VALUES(:user_id,:lead_id,8)";
                $query=$this->db->prepare($sql);
                $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
                $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
                $query->execute();

            }

            else if ($_POST['status_id']==13) {
                $sql="UPDATE leads SET assigned_to='18' where lead_id=:lead_id limit 1";
                $query=$this->db->prepare($sql);
                $query->execute(array('lead_id'=>$_POST['lead_id']));

                $sql="INSERT INTO leads_remove_report(user_id,lead_id,status_id) VALUES(:user_id,:lead_id,13)";
                $query=$this->db->prepare($sql);
                $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
                $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
                $query->execute();

            }

            else if ($_POST['status_id']==11) {
                $sql="UPDATE leads SET assigned_to='24' where lead_id=:lead_id limit 1";
                $query=$this->db->prepare($sql);
                $query->execute(array('lead_id'=>$_POST['lead_id']));

                $sql="INSERT INTO leads_remove_report(user_id,lead_id,status_id) VALUES(:user_id,:lead_id,11)";
                $query=$this->db->prepare($sql);
                $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
                $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
                $query->execute();

            }

            else if ($_POST['status_id']==9) {
                $sql="UPDATE leads SET assigned_to='14' where lead_id=:lead_id limit 1";
                $query=$this->db->prepare($sql);
                $query->execute(array('lead_id'=>$_POST['lead_id']));

                $sql="INSERT INTO leads_remove_report(user_id,lead_id,status_id) VALUES(:user_id,:lead_id,9)";
                $query=$this->db->prepare($sql);
                $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
                $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
                $query->execute();

            }

            echo "success";
            $sql="UPDATE leads SET last_change=now() WHERE lead_id=:lead_id";
            $query = $this->db->prepare($sql);
            $query->bindParam(':lead_id',$_POST['lead_id'],PDO::PARAM_INT);
            $query->execute();

            	//new status name
            $sql='SELECT status_name FROM status where status_id=:status_id';
		        $query = $this->db->prepare($sql);
		        $query->bindParam(':status_id', $_POST['status_id'],PDO::PARAM_INT);
		        $query->execute();
		        $newstatus=$query->fetch();
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
                $query->bindValue(':diff',"status[".$oldstatus->status_name."=>".$newstatus->status_name."]");
                $query->bindParam(':ip', $ip);
                $query->execute();
        }else{
            echo "error";
        }
    }


    public function editAssign(){
    	//get old status
		$sql='SELECT s.first_name FROM leads  inner join users s ON s.user_id=leads.assigned_to  WHERE lead_id=:lead_id LIMIT 1';
        $query = $this->db->prepare($sql);
        $query->bindParam(':lead_id',$_POST['lead_id'],PDO::PARAM_INT);
        $query->execute();
        $oldstatus=$query->fetch();
        //if($_SESSION['role']!='backoffice' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $sql = "UPDATE leads SET assigned_to=:assigned_to WHERE lead_id=:lead_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':assigned_to', $_POST['assigned_to'],PDO::PARAM_INT);
        $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
        $query->execute();
    }


    public function AssignedTo(){
    	//get old status
		$sql='SELECT s.status_name FROM leads  inner join status s ON s.status_id=leads.status  WHERE lead_id=:lead_id LIMIT 1';
        $query = $this->db->prepare($sql);
        $query->bindParam(':lead_id',$_POST['lead_id'],PDO::PARAM_INT);
        $query->execute();
        $oldstatus=$query->fetch();
        //if($_SESSION['role']!='backoffice' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $sql = "UPDATE leads SET assigned_to=:assigned_to WHERE lead_id=:lead_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':assigned_to', $_POST['status_id'],PDO::PARAM_INT);
        $query->bindParam(':lead_id', $_POST['lead_id'],PDO::PARAM_INT);
        if ($query->execute()) {
            if ($_POST['status_id']==15) {
              $sql="UPDATE users SET new_leads=new_leads+1 WHERE role='customer'";
              $query=$this->db->prepare($sql);
              $query->execute();

              $sql="UPDATE leads SET assigned_to='0' where lead_id=:lead_id limit 1";
              $query=$this->db->prepare($sql);
              $query->execute(array('lead_id'=>$_POST['lead_id']));

              // $this->addCustomer1MonthReminder($_POST['lead_id']);
            }

//            if status = superbia
            else if ($_POST['status_id']==17) {
              $sql="UPDATE users SET new_leads=new_leads+1 WHERE role='customer'";
              $query=$this->db->prepare($sql);
              $query->execute();

              $sql="UPDATE leads SET assigned_to='0' where lead_id=:lead_id limit 1";
              $query=$this->db->prepare($sql);
              $query->execute(array('lead_id'=>$_POST['lead_id']));

               $this->addCustomer1MonthReminder($_POST['lead_id']);
            }
            echo "success";
            $sql="UPDATE leads SET last_change=now() WHERE lead_id=:lead_id";
            $query = $this->db->prepare($sql);
            $query->bindParam(':lead_id',$_POST['lead_id'],PDO::PARAM_INT);
            $query->execute();

            	//new status name
            $sql='SELECT status_name FROM status where status_id=:status_id';
		        $query = $this->db->prepare($sql);
		        $query->bindParam(':status_id', $_POST['status_id'],PDO::PARAM_INT);
		        $query->execute();
		        $newstatus=$query->fetch();
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
                $query->bindValue(':diff',"status[".$oldstatus->status_name."=>".$newstatus->status_name."]");
                $query->bindParam(':ip', $ip);
                $query->execute();
        }else{
            echo "error";
        }
    }

    public function register(){

      if (isset($_REQUEST['lead'])) {
        $lead=$_REQUEST['lead'];
      }else{
        $lead=$_REQUEST;
      }
      // api call
      //file_get_contents('https://any1coin.com/crm/api/register?brand=any1coin&first_name='.$args['first_name'].'&last_name='.$args['last_name'].'&phone_number='.$args['nickname'].'&email='.$args['user_email'].'&promocode='.$args['promocode'].'&source=any1coin.com&ip='.$_SERVER['REMOTE_ADDR']);

      $first_name=       (isset($lead['first_name'])?$lead['first_name']:'');
      $last_name=        (isset($lead['last_name'])?$lead['last_name']:'');
      $ip=               (isset($lead['ip'])?$lead['ip']:'');
      $email=            (isset($lead['email'])?$lead['email']:'');
      $phone_number=     (isset($lead['phone_number'])?$lead['phone_number']:'');
      $brand=        (isset($lead['brand'])?$lead['brand']:'');

      if (isset($lead['full_name'])) {
        $name=explode(" ", trim($lead['full_name']));
        $first_name=(isset($name[0])?$name[0]:'');
        $last_name=(isset($name[1])?$name[1]:'');
        if (isset($name[2])) {
            $last_name.=" ".$name[2];
        }
      }

      //var_dump($res);
      if($ip!=''){
        $res = file_get_contents('https://www.iplocate.io/api/lookup/'.$ip);
        $res = json_decode($res);
        $country_by_ip=$res->country;
      }else{
         $country_by_ip=    (isset($lead['country'])?$lead['country']:'');
      }

      $source=     (isset($lead['source'])?$lead['source']:'');

      // if ($brand!="456") {
      //   echo "brand_error"; return;
      // }
      if (isset($lead['test'])) {
        echo "\n\rTest Mode\n\n";print_r($lead);return;
      }

      $sql="SELECT lead_id FROM leads WHERE email=:email";
          $query = $this->db->prepare($sql);
          $query->execute(array(':email' =>$email));

            if ($query->rowCount()>0) {
                //$_SESSION['lead_exist']='true';
                //header("location:".URL.$_SESSION['role'].'/leads');
                return;
            }
      //print_r($_POST);
      $sql = "INSERT INTO leads(`first_name`,`last_name`,`email`,`phone_number`,`brand`,`country_by_ip`,`source`,`ip`)
                         VALUES(:first_name,:last_name,:email,:phone_number,:brand,:country_by_ip,:source,:ip)";
      $query = $this->db->prepare($sql);
      $query->bindParam(':first_name', $first_name);
      $query->bindParam(':last_name', $last_name);
      $query->bindParam(':email', $email);
      $query->bindParam(':phone_number', $phone_number);
      $query->bindParam(':brand', $brand);
      $query->bindParam(':country_by_ip', $country_by_ip);
      $query->bindParam(':source', $source);
      $query->bindParam(':ip', $ip);


      if ($query->execute()) {
         echo "success";
      }else{
          echo "error";
      }

    }

    public function loginAsUser($user_id){
      //if($_SESSION['role']!='manager' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
      $sql="SELECT * FROM users WHERE user_id=:user_id";
      $query=$this->db->prepare($sql);
      $query->execute(array(':user_id' => $user_id));

      $row=$query->fetch(PDO::FETCH_ASSOC);

      $_SESSION['old_username']=$_SESSION['username'];
      $_SESSION['old_full_name']=$_SESSION['full_name'];
      $_SESSION['old_role']=$_SESSION['role'];
      $_SESSION['old_user_id']=$_SESSION['user_id'];
      $_SESSION['old_supervisor']=$_SESSION['supervisor'];
      $_SESSION['old_user_email']=$_SESSION['user_email'];
      $_SESSION['old_user_sip']=$_SESSION['user_sip'];
      $_SESSION['oldsession']='ok';


      $_SESSION['username']=$row['username'];
      $_SESSION['full_name']=$row['first_name'].' '.$row['last_name'];
      $_SESSION['user_id']=$row['user_id'];
      $_SESSION['role']=$row['role'];
      $_SESSION['supervisor']=$row['supervisor'];
      $_SESSION['user_email']=$row['user_email'];
      $_SESSION['user_sip']=$row['user_sip'];


      header('Location:'.URL); return;
    }
    public function ApigetUsersBySupervisor($supervisor){
        $sql="SELECT CONCAT_WS(' ',first_name,last_name) AS full_name,user_id FROM users where role='operator' AND supervisor = :supervisor";
        $query=$this->db->prepare($sql);
        $query->execute(array(':supervisor' =>$supervisor));
        echo json_encode($query->fetchAll());
    }

    public function getSupervisors(){
        $sql="SELECT CONCAT_WS(' ',first_name,last_name) AS full_name,user_id FROM users where role='supervisor' ";
        $query=$this->db->prepare($sql);
        $query->execute();
        echo json_encode($query->fetchAll());
    }

    public function getLeadsChosen(){
        $sql="SELECT CONCAT_WS(' ',first_name,last_name) AS `text` ,lead_id as `id` FROM leads where first_name like :q or last_name like :q limit 10";
        $query=$this->db->prepare($sql);
        $query->execute(array('q' => $_GET['q'].'%' ));
        echo json_encode($query->fetchAll());
    }

    public function getLeadsChosenOp(){
        $sql="SELECT CONCAT_WS(' ',first_name,last_name) AS `text` ,lead_id as `id` FROM leads where assigned_to=:assigned_to and (first_name like :q or last_name like :q) limit 10";
        $query=$this->db->prepare($sql);
        $query->execute(array('q' => $_GET['q'].'%','assigned_to' => $_SESSION['user_id'] ));
        echo json_encode($query->fetchAll());
    }

    public function getWorkhours(){
      $user_id=$_POST['user_id'];
      $date=$_POST['date'];
      $output=array();
      $sql = "SELECT * FROM workhours WHERE user_id='$user_id' and MONTH(`date`) = MONTH('$date') and YEAR(`date`) = YEAR('$date')  order by `workhours_id` desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json
    }

    public function addHours(){
        //print_r($_POST);
        $sql = "INSERT INTO workhours(user_id,hours,`date`) VALUES(:user_id,:hours,:date)";
        $query = $this->db->prepare($sql);
        $query->bindParam(':user_id', $_POST['user_id'],PDO::PARAM_INT);
        $query->bindParam(':date', $_POST['date']);
        $query->bindParam(':hours', $_POST['hours'],PDO::PARAM_INT);
        if ($query->execute()) {
           echo "success";
        }else{
            echo "error";
        }
    }
    public function deleteHours(){
        //if($_SESSION['role']!='backoffice' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $sql = "DELETE FROM workhours WHERE workhours_id=:workhours_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':workhours_id', $_POST['workhours_id'],PDO::PARAM_INT);
        if ($query->execute()) {
           echo "success";
        }else{
            echo "error";
        }
    }


    public function deleteAudio(){
        //if($_SESSION['role']!='backoffice' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $file = APP."audios/".$_POST['url'];
        $sql = "DELETE FROM audios WHERE audio_id=:audio_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':audio_id', $_POST['audio_id'],PDO::PARAM_INT);
        if ($query->execute()) {
           echo "success";
           unlink($file);
        }else{
            echo "error";
        }
    }


    public function bulkUpdateStatuses(){
       //print_r($_SESSION);
        $sql = "UPDATE contracts SET status=status_temp WHERE status_temp!='' ";
        $query = $this->db->prepare($sql);
        if ($query->execute()) {

            $last_status_update = date("d-m-Y H:i:s"); ;
            $var_str = var_export($last_status_update, true);
            $var = "<?php\n\n\$last_status_update = $var_str;\n\n?>";
            file_put_contents('last_status_update.php', $var);
            //echo "success";
            $_SESSION['update_statuses']='success';
            header("location:".URL.$_SESSION['role'].'/statuses/');

        }else {
            $_SESSION['update_statuses']='false';
            header("location:".URL.$_SESSION['role'].'/statuses/');
        }
         //print_r($_SESSION);

    }

    public function editContractStatus(){
    	//get old status
		$sql='SELECT s.status_name FROM contracts  inner join status s ON s.status_id=contracts.status  WHERE contract_id=:contract_id LIMIT 1';
        $query = $this->db->prepare($sql);
        $query->bindParam(':contract_id',$_POST['contract_id'],PDO::PARAM_INT);
        $query->execute();
        $oldstatus=$query->fetch();
        //if($_SESSION['role']!='backoffice' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $sql = "UPDATE contracts SET status=:status_id WHERE contract_id=:contract_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':status_id', $_POST['status_id'],PDO::PARAM_INT);
        $query->bindParam(':contract_id', $_POST['contract_id'],PDO::PARAM_INT);
        if ($query->execute()) {
            echo "success";
            	//new status name
                $sql='SELECT status_name FROM status where status_id=:status_id';
		        $query = $this->db->prepare($sql);
		        $query->bindParam(':status_id', $_POST['status_id'],PDO::PARAM_INT);
		        $query->execute();
		        $newstatus=$query->fetch();

                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }

		        //log cheanges
                $sql="INSERT INTO log(user_id,contract_id,diff,ip) VALUES(:user_id,:contract_id,:diff,:ip)";
                $query=$this->db->prepare($sql);
                $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
                $query->bindParam(':contract_id', $_POST['contract_id'],PDO::PARAM_INT);
                $query->bindValue(':diff',"status[".$oldstatus->status_name."=>".$newstatus->status_name."]");
                $query->bindParam(':ip', $ip);
                $query->execute();

        }else{
            echo "error";
        }
    }
    public function editContractStatusTemp(){
        //get old status
        $sql='SELECT s.status_name FROM contracts  inner join status s ON s.status_id=contracts.status  WHERE contract_id=:contract_id LIMIT 1';
        $query = $this->db->prepare($sql);
        $query->bindParam(':contract_id',$_POST['contract_id'],PDO::PARAM_INT);
        $query->execute();
        $oldstatus=$query->fetch();
        //if($_SESSION['role']!='backoffice' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $sql = "UPDATE contracts SET status_temp=:status_id WHERE contract_id=:contract_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':status_id', $_POST['status_id'],PDO::PARAM_INT);
        $query->bindParam(':contract_id', $_POST['contract_id'],PDO::PARAM_INT);
        if ($query->execute()) {
            echo "success";
                //new status name
                $sql='SELECT status_name FROM status where status_id=:status_id';
                $query = $this->db->prepare($sql);
                $query->bindParam(':status_id', $_POST['status_id'],PDO::PARAM_INT);
                $query->execute();
                $newstatus=$query->fetch();

                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }

                //log cheanges
                $sql="INSERT INTO log(user_id,contract_id,diff,ip) VALUES(:user_id,:contract_id,:diff,:ip)";
                $query=$this->db->prepare($sql);
                $query->bindParam(':user_id',$_SESSION['user_id'],PDO::PARAM_INT);
                $query->bindParam(':contract_id', $_POST['contract_id'],PDO::PARAM_INT);
                $query->bindValue(':diff',"status[".$oldstatus->status_name."=>".$newstatus->status_name."]");
                $query->bindParam(':ip', $ip);
                $query->execute();

        }else{
            echo "error";
        }
    }

    public function editContractCampaign(){
        //if($_SESSION['role']!='backoffice' || $_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $sql = "UPDATE contracts SET campaign=:campaign_id WHERE contract_id=:contract_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':campaign_id', $_POST['campaign_id'],PDO::PARAM_INT);
        $query->bindParam(':contract_id', $_POST['contract_id'],PDO::PARAM_INT);
        if ($query->execute()) {
           echo "success";
        }else{
            echo "error";
        }
    }

    public function deleteContract(){
        if($_SESSION['role']!='admin') { header('Location:'.URL); return; };
        $sql = "DELETE FROM contracts WHERE contract_id=:contract_id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':contract_id', $_POST['contract_id'],PDO::PARAM_INT);
        if ($query->execute()) {
           echo "success";
        }else{
            echo "error";
        }
    }

    public function convertCnt($toType,$toStatus){

        $_POST=$_REQUEST['contract'];
        // 6 switch
        // 7 storni
        $old_type=  $_POST['contract_type'];
        $old_status=$_POST['status'];

        switch ($toStatus) {
            case 'switch':
                $_POST['status']='6';
                break;
            case 'storni':
                $_POST['status']='7';
                break;
            default:
               $_POST['status']='1';
                break;
        }

        $_POST['contract_type']=$toType;

        $sql="INSERT INTO contracts
                    (`date`,
                        operator,
                    supervisor,
                    campaign,
                    ugm_cb,
                    analisi_cb,
                    iniziative_cb,
        tel_number,alt_number,cel_number,cel_number2,cel_number3,email,alt_email,
client_type,gender,rag_sociale,first_name,last_name,vat_number,partita_iva,birth_date,
birth_nation,birth_municipality,document_type,document_number,document_date,
toponimo,address,civico,price,location,cap,
uf_toponimo,uf_address,uf_civico,uf_price,uf_location,uf_cap,
ddf_toponimo,ddf_address,ddf_civico,ddf_price,ddf_location,ddf_cap,
ubicazione_fornitura,domicillazione_documenti_fatture, contract_type, listino,
gas_request_type,gas_pdr,gas_fornitore_uscente,gas_consume_annuo,gas_tipo_riscaldamento,gas_tipo_cottura_acqua,gas_remi,gas_matricola,
luce_request_type,luce_pod,luce_tensione,luce_potenza,luce_fornitore_uscente,luce_opzione_oraria,luce_consume_annuo,
fature_via_email,
payment_type,iban_code,iban_accounthoder,iban_fiscal_code,note,status,
delega_first_name,delega_last_name,delega_vat_number,document_expiry,document_issue_place            )             VALUES            (:date,                :operator,            :supervisor,            :campaign,            :ugm_cb,            :analisi_cb,            :iniziative_cb,
:tel_number,:alt_number,:cel_number,:cel_number2,:cel_number3,:email,:alt_email,
:client_type,:gender,:rag_sociale,:first_name,:last_name,:vat_number,:partita_iva,
:birth_date,:birth_nation,:birth_municipality,:document_type,:document_number,:document_date,
:toponimo,:address,:civico,:price,:location,:cap,
:uf_toponimo,:uf_address,:uf_civico,:uf_price,:uf_location,:uf_cap,
:ddf_toponimo,:ddf_address,:ddf_civico,:ddf_price,:ddf_location,:ddf_cap,
:ubicazione_fornitura,:domicillazione_documenti_fatture, :contract_type, :listino,
:gas_request_type,:gas_pdr,:gas_fornitore_uscente,:gas_consume_annuo,:gas_tipo_riscaldamento,:gas_tipo_cottura_acqua,:gas_remi,:gas_matricola,
:luce_request_type,:luce_pod,:luce_tensione,:luce_potenza,:luce_fornitore_uscente,:luce_opzione_oraria,:luce_consume_annuo,
:fature_via_email,
:payment_type,:iban_code,:iban_accounthoder,:iban_fiscal_code,:note,:status,
:delega_first_name,:delega_last_name,:delega_vat_number,:document_expiry,:document_issue_place
    )";

        $query = $this->db->prepare($sql);
        $query->bindValue(':date',date('Y-m-d',strtotime($_POST['date'])));
        $query->bindParam(':operator', $_POST['operator'], PDO::PARAM_INT);
        $query->bindParam(':supervisor', $_POST['supervisor'],PDO::PARAM_INT);
        $query->bindParam(':campaign', $_POST['campaign'],PDO::PARAM_INT);
        $query->bindParam(':status',$_POST['status'],PDO::PARAM_INT);

        $query->bindValue(':ugm_cb',(isset($_POST['ugm_cb'])?$_POST['ugm_cb']:'false'));
        $query->bindValue(':analisi_cb',(isset($_POST['analisi_cb'])?$_POST['analisi_cb']:'false'));
        $query->bindValue(':iniziative_cb',(isset($_POST['iniziative_cb'])?$_POST['iniziative_cb']:'false'));

        $query->bindParam(':tel_number', $_POST['tel_number']);
        $query->bindParam(':alt_number', $_POST['alt_number']);
        $query->bindParam(':cel_number', $_POST['cel_number']);
        $query->bindParam(':cel_number2', $_POST['cel_number2']);
        $query->bindParam(':cel_number3', $_POST['cel_number3']);
        $query->bindParam(':email', $_POST['email']);
        $query->bindParam(':alt_email', $_POST['alt_email']);

        $query->bindParam(':client_type', $_POST['client_type']);
        $query->bindParam(':gender', $_POST['gender']);
        $query->bindParam(':rag_sociale', $_POST['rag_sociale']);
        $query->bindValue(':first_name', trim($_POST['first_name']));
        $query->bindValue(':last_name', trim($_POST['last_name']));
        $query->bindParam(':vat_number', $_POST['vat_number']);
        $query->bindParam(':partita_iva', $_POST['partita_iva']);
        $query->bindValue(':birth_date', date('Y-m-d',strtotime($_POST['birth_date'])));
        $query->bindParam(':birth_nation', $_POST['birth_nation']);
        $query->bindParam(':birth_municipality', $_POST['birth_municipality']);
        $query->bindParam(':document_type', $_POST['document_type']);
        $query->bindParam(':document_number', $_POST['document_number']);
        $query->bindValue(':document_date',date('Y-m-d',strtotime($_POST['document_date'])));
        $query->bindValue(':document_expiry',date('Y-m-d',strtotime($_POST['document_expiry'])));
        $query->bindValue(':document_issue_place', $_POST['document_issue_place']);

        $query->bindParam(':toponimo', $_POST['toponimo']);
        $query->bindParam(':address', $_POST['address']);
        $query->bindParam(':civico', $_POST['civico']);
        $query->bindParam(':price', $_POST['price']);
        $query->bindParam(':location', $_POST['location']);
        $query->bindParam(':cap', $_POST['cap']);

        if ($_POST['ubicazione_fornitura']=='non_resident') {
            $query->bindParam(':uf_toponimo', $_POST['uf_toponimo']);
            $query->bindParam(':uf_address', $_POST['uf_address']);
            $query->bindParam(':uf_civico', $_POST['uf_civico']);
            $query->bindParam(':uf_price', $_POST['uf_price']);
            $query->bindParam(':uf_location', $_POST['uf_location']);
            $query->bindParam(':uf_cap', $_POST['uf_cap']);
        }else{
            $query->bindValue(':uf_toponimo','');
            $query->bindValue(':uf_address', '');
            $query->bindValue(':uf_civico', '');
            $query->bindValue(':uf_price', '');
            $query->bindValue(':uf_location', '');
            $query->bindValue(':uf_cap', '');
        }

        if ($_POST['domicillazione_documenti_fatture']=='altro') {
            $query->bindParam(':ddf_toponimo', $_POST['ddf_toponimo']);
            $query->bindParam(':ddf_address', $_POST['ddf_address']);
            $query->bindParam(':ddf_civico', $_POST['ddf_civico']);
            $query->bindParam(':ddf_price', $_POST['ddf_price']);
            $query->bindParam(':ddf_location', $_POST['ddf_location']);
            $query->bindParam(':ddf_cap', $_POST['ddf_cap']);
        }else{
            $query->bindValue(':ddf_toponimo','');
            $query->bindValue(':ddf_address', '');
            $query->bindValue(':ddf_civico', '');
            $query->bindValue(':ddf_price', '');
            $query->bindValue(':ddf_location', '');
            $query->bindValue(':ddf_cap', '');
        }

        $query->bindParam(':ubicazione_fornitura', $_POST['ubicazione_fornitura']);
        $query->bindParam(':domicillazione_documenti_fatture', $_POST['domicillazione_documenti_fatture']);
        $query->bindParam(':contract_type', $_POST['contract_type']);
        $query->bindParam(':listino', $_POST['listino']);

        if ($_POST['contract_type']=='dual') {

            $query->bindParam(':luce_request_type',$_POST['luce_request_type']);
            $query->bindParam(':luce_pod',$_POST['luce_pod']);
            $query->bindParam(':luce_fornitore_uscente',$_POST['luce_fornitore_uscente']);
            $query->bindParam(':luce_opzione_oraria',$_POST['luce_opzione_oraria']);
            $query->bindParam(':luce_potenza',$_POST['luce_potenza']);
            $query->bindParam(':luce_tensione',$_POST['luce_tensione']);
            $query->bindValue(':luce_consume_annuo',$_POST['luce_consume_annuo']);

            $query->bindParam(':gas_request_type', $_POST['gas_request_type']);
            $query->bindParam(':gas_pdr', $_POST['gas_pdr']);
            $query->bindParam(':gas_fornitore_uscente', $_POST['gas_fornitore_uscente']);
            $query->bindParam(':gas_consume_annuo', $_POST['gas_consume_annuo']);
            $query->bindValue(':gas_tipo_riscaldamento',(isset($_POST['gas_tipo_riscaldamento'])?$_POST['gas_tipo_riscaldamento']:'false'));
            $query->bindValue(':gas_tipo_cottura_acqua',(isset($_POST['gas_tipo_cottura_acqua'])?$_POST['gas_tipo_cottura_acqua']:'false'));
            $query->bindParam(':gas_remi', $_POST['gas_remi']);
            $query->bindParam(':gas_matricola', $_POST['gas_matricola']);


        }elseif ($_POST['contract_type']=='gas') {

            $query->bindParam(':gas_request_type', $_POST['gas_request_type']);
            $query->bindParam(':gas_pdr', $_POST['gas_pdr']);
            $query->bindParam(':gas_fornitore_uscente', $_POST['gas_fornitore_uscente']);
            $query->bindParam(':gas_consume_annuo', $_POST['gas_consume_annuo']);
            $query->bindValue(':gas_tipo_riscaldamento',(isset($_POST['gas_tipo_riscaldamento'])?$_POST['gas_tipo_riscaldamento']:'false'));
            $query->bindValue(':gas_tipo_cottura_acqua',(isset($_POST['gas_tipo_cottura_acqua'])?$_POST['gas_tipo_cottura_acqua']:'false'));
            $query->bindParam(':gas_remi', $_POST['gas_remi']);
            $query->bindParam(':gas_matricola', $_POST['gas_matricola']);

            $query->bindValue(':luce_request_type','');
            $query->bindValue(':luce_pod','');
            $query->bindValue(':luce_fornitore_uscente','');
            $query->bindValue(':luce_opzione_oraria', '');
            $query->bindValue(':luce_potenza','');
            $query->bindValue(':luce_tensione','');
            $query->bindValue(':luce_consume_annuo','');

        }elseif ($_POST['contract_type']=='luce') {

            $query->bindParam(':luce_request_type',$_POST['luce_request_type']);
            $query->bindParam(':luce_pod',$_POST['luce_pod']);
            $query->bindParam(':luce_fornitore_uscente',$_POST['luce_fornitore_uscente']);
            $query->bindParam(':luce_opzione_oraria',$_POST['luce_opzione_oraria']);
            $query->bindParam(':luce_potenza',$_POST['luce_potenza']);
            $query->bindParam(':luce_tensione',$_POST['luce_tensione']);
            $query->bindValue(':luce_consume_annuo',$_POST['luce_consume_annuo']);

            $query->bindValue(':gas_request_type','');
            $query->bindValue(':gas_pdr','');
            $query->bindValue(':gas_fornitore_uscente','');
            $query->bindValue(':gas_consume_annuo', '');
            $query->bindValue(':gas_tipo_riscaldamento','');
            $query->bindValue(':gas_tipo_cottura_acqua','');
            $query->bindValue(':gas_remi', '');
            $query->bindValue(':gas_matricola','');
        }

        if ($_POST['client_type']=='delega') {
            $query->bindParam(':delega_first_name', $_POST['delega_first_name']);
            $query->bindParam(':delega_last_name', $_POST['delega_last_name']);
            $query->bindParam(':delega_vat_number', $_POST['delega_vat_number']);
        } else{
            $query->bindValue(':delega_first_name','');
            $query->bindValue(':delega_last_name','');
            $query->bindValue(':delega_vat_number','');
        }


        $query->bindValue(':fature_via_email',(isset($_POST['fature_via_email'])?$_POST['fature_via_email']:'false'));

        $query->bindParam(':payment_type', $_POST['payment_type']);

        if ($_POST['payment_type']=='cc') {
            $query->bindParam(':iban_code', $_POST['iban_code']);
            $query->bindParam(':iban_accounthoder', $_POST['iban_accounthoder']);
            $query->bindParam(':iban_fiscal_code', $_POST['iban_fiscal_code']);
        }else{
            $query->bindValue(':iban_code','');
            $query->bindValue(':iban_accounthoder', '');
            $query->bindValue(':iban_fiscal_code', '');
        }

        $query->bindParam(':note', $_POST['note']);


            if ($query->execute()) {

                if ($_POST['contract_type']=='luce') {
                    $_POST['contract_type']='gas';
                }elseif ($_POST['contract_type']=='gas') {
                    $_POST['contract_type']='luce';
                }
                $_POST['status']=$old_status;

                 $sql="UPDATE contracts SET `date`=:date,operator=:operator,supervisor=:supervisor,campaign=:campaign,ugm_cb=:ugm_cb,analisi_cb=:analisi_cb,iniziative_cb=:iniziative_cb, tel_number=:tel_number,alt_number=:alt_number,cel_number=:cel_number,cel_number2=:cel_number2,cel_number3=:cel_number3,email=:email,alt_email=:alt_email,client_type=:client_type,gender=:gender,rag_sociale=:rag_sociale,first_name=:first_name,last_name=:last_name,vat_number=:vat_number,partita_iva=:partita_iva,birth_date=:birth_date,birth_nation=:birth_nation,birth_municipality=:birth_municipality,document_type=:document_type,document_number=:document_number,document_date=:document_date,toponimo=:toponimo,address=:address,civico=:civico,price=:price,location=:location,cap=:cap,uf_toponimo=:uf_toponimo,uf_address=:uf_address,uf_civico=:uf_civico,uf_price=:uf_price,uf_location=:uf_location,uf_cap=:uf_cap,ddf_toponimo=:ddf_toponimo,ddf_address=:ddf_address,ddf_civico=:ddf_civico,ddf_price=:ddf_price,ddf_location=:ddf_location,ddf_cap=:ddf_cap,ubicazione_fornitura=:ubicazione_fornitura,domicillazione_documenti_fatture=:domicillazione_documenti_fatture,contract_type=:contract_type,listino=:listino,gas_request_type=:gas_request_type,gas_pdr=:gas_pdr,gas_fornitore_uscente=:gas_fornitore_uscente,gas_consume_annuo=:gas_consume_annuo,gas_tipo_riscaldamento=:gas_consume_annuo,gas_tipo_cottura_acqua=:gas_tipo_cottura_acqua,gas_remi=:gas_remi,gas_matricola=:gas_matricola,luce_request_type=:luce_request_type,luce_pod=:luce_pod,luce_tensione=:luce_tensione,luce_potenza=:luce_potenza,luce_fornitore_uscente=:luce_fornitore_uscente,luce_opzione_oraria=:luce_opzione_oraria,luce_consume_annuo=:luce_consume_annuo,fature_via_email=:fature_via_email,payment_type=:payment_type,iban_code=:iban_code,iban_accounthoder=:iban_accounthoder,iban_fiscal_code=:iban_fiscal_code,note=:note,status=:status,delega_first_name=:delega_first_name,delega_last_name=:delega_last_name,delega_vat_number=:delega_vat_number,document_expiry=:document_expiry,document_issue_place=:document_issue_place,note_super=:note_super WHERE contract_id=:contract_id";

                    $query = $this->db->prepare($sql);
                    $query->bindValue(':date',date('Y-m-d',strtotime($_POST['date'])));

                    $query->bindParam(':operator', $_POST['operator'], PDO::PARAM_INT);
                    $query->bindParam(':supervisor', $_POST['supervisor'],PDO::PARAM_INT);
                    $query->bindParam(':campaign', $_POST['campaign'],PDO::PARAM_INT);
                    $query->bindParam(':status',$_POST['status'],PDO::PARAM_INT);

                    $query->bindValue(':ugm_cb',(isset($_POST['ugm_cb'])?$_POST['ugm_cb']:'false'));
                    $query->bindValue(':analisi_cb',(isset($_POST['analisi_cb'])?$_POST['analisi_cb']:'false'));
                    $query->bindValue(':iniziative_cb',(isset($_POST['iniziative_cb'])?$_POST['iniziative_cb']:'false'));

                    $query->bindParam(':tel_number', $_POST['tel_number']);
                    $query->bindParam(':alt_number', $_POST['alt_number']);
                    $query->bindParam(':cel_number', $_POST['cel_number']);
                    $query->bindParam(':cel_number2', $_POST['cel_number2']);
                    $query->bindParam(':cel_number3', $_POST['cel_number3']);
                    $query->bindParam(':email', $_POST['email']);
                    $query->bindParam(':alt_email', $_POST['alt_email']);

                    $query->bindParam(':client_type', $_POST['client_type']);
                    $query->bindParam(':gender', $_POST['gender']);
                    $query->bindParam(':rag_sociale', $_POST['rag_sociale']);
                    $query->bindValue(':first_name', trim($_POST['first_name']));
                    $query->bindValue(':last_name', trim($_POST['last_name']));
                    $query->bindParam(':vat_number', $_POST['vat_number']);
                    $query->bindParam(':partita_iva', $_POST['partita_iva']);
                    $query->bindValue(':birth_date', date('Y-m-d',strtotime($_POST['birth_date'])));
                    $query->bindParam(':birth_nation', $_POST['birth_nation']);
                    $query->bindParam(':birth_municipality', $_POST['birth_municipality']);
                    $query->bindParam(':document_type', $_POST['document_type']);
                    $query->bindParam(':document_number', $_POST['document_number']);
                    $query->bindValue(':document_date',date('Y-m-d',strtotime($_POST['document_date'])));
                    $query->bindValue(':document_expiry',date('Y-m-d',strtotime($_POST['document_expiry'])));
                    $query->bindValue(':document_issue_place', $_POST['document_issue_place']);

                    $query->bindParam(':toponimo', $_POST['toponimo']);
                    $query->bindParam(':address', $_POST['address']);
                    $query->bindParam(':civico', $_POST['civico']);
                    $query->bindParam(':price', $_POST['price']);
                    $query->bindParam(':location', $_POST['location']);
                    $query->bindParam(':cap', $_POST['cap']);
                    $query->bindParam(':note_super', $_POST['note_super']);

                    if ($_POST['ubicazione_fornitura']=='non_resident') {
                        $query->bindParam(':uf_toponimo', $_POST['uf_toponimo']);
                        $query->bindParam(':uf_address', $_POST['uf_address']);
                        $query->bindParam(':uf_civico', $_POST['uf_civico']);
                        $query->bindParam(':uf_price', $_POST['uf_price']);
                        $query->bindParam(':uf_location', $_POST['uf_location']);
                        $query->bindValue(':uf_cap', $_POST['uf_cap']);
                    }else{
                        $query->bindValue(':uf_toponimo','');
                        $query->bindValue(':uf_address', '');
                        $query->bindValue(':uf_civico', '');
                        $query->bindValue(':uf_price', '');
                        $query->bindValue(':uf_location', '');
                        $query->bindValue(':uf_cap', '');
                    }

                    if ($_POST['domicillazione_documenti_fatture']=='altro') {
                        $query->bindParam(':ddf_toponimo', $_POST['ddf_toponimo']);
                        $query->bindParam(':ddf_address', $_POST['ddf_address']);
                        $query->bindParam(':ddf_civico', $_POST['ddf_civico']);
                        $query->bindParam(':ddf_price', $_POST['ddf_price']);
                        $query->bindParam(':ddf_location', $_POST['ddf_location']);
                        $query->bindValue(':ddf_cap', $_POST['ddf_cap']);
                    }else{
                        $query->bindValue(':ddf_toponimo','');
                        $query->bindValue(':ddf_address', '');
                        $query->bindValue(':ddf_civico', '');
                        $query->bindValue(':ddf_price', '');
                        $query->bindValue(':ddf_location', '');
                        $query->bindValue(':ddf_cap', '');
                    }

                    $query->bindParam(':ubicazione_fornitura', $_POST['ubicazione_fornitura']);
                    $query->bindParam(':domicillazione_documenti_fatture', $_POST['domicillazione_documenti_fatture']);
                    $query->bindParam(':contract_type', $_POST['contract_type']);
                    $query->bindParam(':listino', $_POST['listino']);

                    if ($_POST['contract_type']=='dual') {

                        $query->bindParam(':luce_request_type',$_POST['luce_request_type']);
                        $query->bindParam(':luce_pod',$_POST['luce_pod']);
                        $query->bindParam(':luce_fornitore_uscente',$_POST['luce_fornitore_uscente']);
                        $query->bindParam(':luce_opzione_oraria',$_POST['luce_opzione_oraria']);
                        $query->bindParam(':luce_potenza',$_POST['luce_potenza']);
                        $query->bindParam(':luce_tensione',$_POST['luce_tensione']);
                        $query->bindValue(':luce_consume_annuo',$_POST['luce_consume_annuo']);

                        $query->bindParam(':gas_request_type', $_POST['gas_request_type']);
                        $query->bindParam(':gas_pdr', $_POST['gas_pdr']);
                        $query->bindParam(':gas_fornitore_uscente', $_POST['gas_fornitore_uscente']);
                        $query->bindParam(':gas_consume_annuo', $_POST['gas_consume_annuo']);
                        $query->bindValue(':gas_tipo_riscaldamento',(isset($_POST['gas_tipo_riscaldamento'])?$_POST['gas_tipo_riscaldamento']:'false'));
                        $query->bindValue(':gas_tipo_cottura_acqua',(isset($_POST['gas_tipo_cottura_acqua'])?$_POST['gas_tipo_cottura_acqua']:'false'));
                        $query->bindParam(':gas_remi', $_POST['gas_remi']);
                        $query->bindParam(':gas_matricola', $_POST['gas_matricola']);


                    }elseif ($_POST['contract_type']=='gas') {

                        $query->bindParam(':gas_request_type', $_POST['gas_request_type']);
                        $query->bindParam(':gas_pdr', $_POST['gas_pdr']);
                        $query->bindParam(':gas_fornitore_uscente', $_POST['gas_fornitore_uscente']);
                        $query->bindParam(':gas_consume_annuo', $_POST['gas_consume_annuo']);
                        $query->bindValue(':gas_tipo_riscaldamento',(isset($_POST['gas_tipo_riscaldamento'])?$_POST['gas_tipo_riscaldamento']:'false'));
                        $query->bindValue(':gas_tipo_cottura_acqua',(isset($_POST['gas_tipo_cottura_acqua'])?$_POST['gas_tipo_cottura_acqua']:'false'));
                        $query->bindParam(':gas_remi', $_POST['gas_remi']);
                        $query->bindParam(':gas_matricola', $_POST['gas_matricola']);

                        $query->bindValue(':luce_request_type','');
                        $query->bindValue(':luce_pod','');
                        $query->bindValue(':luce_fornitore_uscente','');
                        $query->bindValue(':luce_opzione_oraria', '');
                        $query->bindValue(':luce_potenza','');
                        $query->bindValue(':luce_tensione','');
                        $query->bindValue(':luce_consume_annuo','');

                    }elseif ($_POST['contract_type']=='luce') {

                        $query->bindParam(':luce_request_type',$_POST['luce_request_type']);
                        $query->bindParam(':luce_pod',$_POST['luce_pod']);
                        $query->bindParam(':luce_fornitore_uscente',$_POST['luce_fornitore_uscente']);
                        $query->bindParam(':luce_opzione_oraria',$_POST['luce_opzione_oraria']);
                        $query->bindParam(':luce_potenza',$_POST['luce_potenza']);
                        $query->bindParam(':luce_tensione',$_POST['luce_tensione']);
                        $query->bindValue(':luce_consume_annuo',$_POST['luce_consume_annuo']);

                        $query->bindValue(':gas_request_type','');
                        $query->bindValue(':gas_pdr','');
                        $query->bindValue(':gas_fornitore_uscente','');
                        $query->bindValue(':gas_consume_annuo', '');
                        $query->bindValue(':gas_tipo_riscaldamento','');
                        $query->bindValue(':gas_tipo_cottura_acqua','');
                        $query->bindValue(':gas_remi', '');
                        $query->bindValue(':gas_matricola','');
                    }

                    if ($_POST['client_type']=='delega') {
                        $query->bindParam(':delega_first_name', $_POST['delega_first_name']);
                        $query->bindParam(':delega_last_name', $_POST['delega_last_name']);
                        $query->bindParam(':delega_vat_number', $_POST['delega_vat_number']);
                    } else{
                        $query->bindValue(':delega_first_name','');
                        $query->bindValue(':delega_last_name','');
                        $query->bindValue(':delega_vat_number','');
                    }


                    $query->bindValue(':fature_via_email',(isset($_POST['fature_via_email'])?$_POST['fature_via_email']:'false'));

                    $query->bindParam(':payment_type', $_POST['payment_type']);

                    if ($_POST['payment_type']=='cc') {
                        $query->bindParam(':iban_code', $_POST['iban_code']);
                        $query->bindParam(':iban_accounthoder', $_POST['iban_accounthoder']);
                        $query->bindParam(':iban_fiscal_code', $_POST['iban_fiscal_code']);
                    }else{
                        $query->bindValue(':iban_code','');
                        $query->bindValue(':iban_accounthoder', '');
                        $query->bindValue(':iban_fiscal_code', '');
                    }

                    $query->bindParam(':note', $_POST['note']);


                     $query->bindParam(':contract_id',$_POST['contract_id'],PDO::PARAM_INT);

                     $query->execute();
            }



    }
}
