<?php
if(!isset($_SESSION['username'])){ header('Location:'.URL); return; };
if($_SESSION['role']!='customer') { header('Location:'.URL); return; };
/**
 * //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit(); debug sql
 */
class customer extends Controller
{


    public function index(){
        header('Location:'.URL.$_SESSION['role'].'/leads');
    }

    public function call_log(){
      $call_log=$this->model->getCallLog();

      require APP . 'view/customer/header.php';
      require APP . 'view/customer/call_log.php';
      require APP . 'view/customer/footer.php';
    }

    public function links($link){
      require APP . 'view/customer/header.php';
      require APP . 'view/customer/links/'.$link.'.php';
      require APP . 'view/customer/footer.php';
    }
    function leads(){
        if (isset($_REQUEST['export'])){
            if ($_REQUEST['export']==true) {
                $this->model->getLeads('export');
                return;
            }
        }

        $operators=$this->model->getUsers();
        // $operators=$this->model->getUsersByRole('operator');
        // $operators=array_merge($operators,$this->model->getUsersByRole('result'));
        // $operatorsR=$this->model->getUsersRecycle('operator');
        //$supervisors=$this->model->getUsersByRole('supervisor');
    	  $output=$this->model->getLeads();
        $leads=$output[1];
        $pages=ceil($output[0]/100);
        $countleads=$output[0];
        //$campaigns=$this->model->getCampaigns();
        //print_r($leads);
        $assigned_froms=$this->model->getAssignedFroms();
        $statuses=$this->model->getStatuses();
        $sources=$this->model->getSources();
        if (isset($_POST['all_selected'])) {
          $all_ids=$output[2];
          $id_string=array();
          foreach ($all_ids as $key => $value) {
            array_push($id_string,$value->lead_id);
          }
          if (isset($_POST['limit'])) {
            if ($_POST['limit']!='') {
              array_splice($id_string,(int)$_POST['limit']);
            }
          }

          $id_string1=implode(',', array_map('intval', $id_string));
          //print_r($id_string1);
          //return;
          //$all_ids_js=array();
        //  foreach ($all_ids as $key => $value) {
          if ($_POST['action']=='assign_to') {
              $sql="UPDATE leads SET assigned_to=:operator WHERE lead_id in(".$id_string1.")";
              $query=$this->db->prepare($sql);
              //$query->bindParam(':id', $value->lead_id);
              $query->bindParam(':operator', $_POST['operator']);
              $query->execute();
              $_SESSION['assigned_to']='success';
          }elseif ($_POST['action']=='delete') {
              echo "delete";
              $sql="DELETE FROM leads WHERE lead_id in(".$id_string1.")";
              $query=$this->db->prepare($sql);
              $query->execute();

              $sql="DELETE FROM notes WHERE lead_id  in(".$id_string1.")";
              $query=$this->db->prepare($sql);
              $query->execute();

              $sql="DELETE FROM tasks WHERE lead_id  in(".$id_string1.")";
              $query = $this->db->prepare($sql);
              $query->execute();

              $sql="DELETE FROM `log` WHERE lead_id  in(".$id_string1.")";
              $query = $this->db->prepare($sql);
              $query->execute();

              $sql="UPDATE leads SET last_change=now() WHERE lead_id=in(".$id_string1.")";
              $query = $this->db->prepare($sql);
              $query->execute();

              $_SESSION['deleted']='success';
          }elseif ($_POST['action']=='edit') {
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
            if ($_POST['status0']!='') {
              $q.="status='".$_POST['status0']."',";
            }
            if ($_POST['assigned_to0']!='') {
              $q.="assigned_to='".$_POST['assigned_to0']."',";
            }
            $q=rtrim($q, ',');
            $sql="UPDATE leads SET ".$q." WHERE lead_id in(".$id_string1.")";
            $query=$this->db->prepare($sql);
            $query->execute();

            $sql="UPDATE leads SET last_change=now() WHERE lead_id=in(".$id_string1.")";
            $query = $this->db->prepare($sql);
            $query->execute();
          }
          return;
        }

   		  require APP . 'view/customer/header.php';
        require APP . 'view/customer/leads.php';
        require APP . 'view/customer/footer.php';
    }

    function recycle(){
        if (isset($_REQUEST['export'])){
            if ($_REQUEST['export']==true) {
                $this->model->getRecycle('export');
                return;
            }
        }

        $operators=$this->model->getUsersByRole('operator');
        $operators=array_merge($operators,$this->model->getUsersByRole('result'));
        $operatorsR=$this->model->getUsersRecycle('operator');
        $operatorsR=array_merge($operatorsR,$this->model->getUsersByRole('result'));
        //$supervisors=$this->model->getUsersByRole('supervisor');
        $output=$this->model->getRecycle();
        $leads=$output[1];
        $pages=ceil($output[0]/100);
        $countleads=$output[0];
        //$campaigns=$this->model->getCampaigns();
        //print_r($leads);
        $statuses=$this->model->getStatuses();
        $sources=$this->model->getSources();
        if (isset($_POST['all_selected'])) {
          $all_ids=$output[2];
          $id_string=array();
          foreach ($all_ids as $key => $value) {
            array_push($id_string,$value->lead_id);
          }
          $id_string1=implode(',', array_map('intval', $id_string));
          //print_r($id_string1);
          //return;
          //$all_ids_js=array();
        //  foreach ($all_ids as $key => $value) {
          if ($_POST['action']=='assign_to') {
              $sql="UPDATE leads SET assigned_to=:operator WHERE lead_id in(".$id_string1.")";
              $query=$this->db->prepare($sql);
              //$query->bindParam(':id', $value->lead_id);
              $query->bindParam(':operator', $_POST['operator']);
              $query->execute();
              $_SESSION['assigned_to']='success';
          }elseif ($_POST['action']=='delete') {
              echo "delete";
              $sql="DELETE FROM leads WHERE lead_id in(".$id_string1.")";
              $query=$this->db->prepare($sql);
              $query->execute();

              $sql="DELETE FROM notes WHERE lead_id  in(".$id_string1.")";
              $query=$this->db->prepare($sql);
              $query->execute();

              $sql="DELETE FROM tasks WHERE lead_id  in(".$id_string1.")";
              $query = $this->db->prepare($sql);
              $query->execute();

              $sql="DELETE FROM `log` WHERE lead_id  in(".$id_string1.")";
              $query = $this->db->prepare($sql);
              $query->execute();

              $sql="UPDATE leads SET last_change=now() WHERE lead_id=in(".$id_string1.")";
              $query = $this->db->prepare($sql);
              $query->execute();

              $_SESSION['deleted']='success';
          }elseif ($_POST['action']=='edit') {
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
            if ($_POST['status0']!='') {
              $q.="status='".$_POST['status0']."',";
            }
            if ($_POST['assigned_to0']!='') {
              $q.="assigned_to='".$_POST['assigned_to0']."',";
            }
            $q=rtrim($q, ',');
            $sql="UPDATE leads SET ".$q." WHERE lead_id in(".$id_string1.")";
            $query=$this->db->prepare($sql);
            $query->execute();

            $sql="UPDATE leads SET last_change=now() WHERE lead_id=in(".$id_string1.")";
            $query = $this->db->prepare($sql);
            $query->execute();
          }
          return;
        }

   		  require APP . 'view/customer/header.php';
        require APP . 'view/customer/recycle.php';
        require APP . 'view/customer/footer.php';
    }


    public function createLead(){
        if(isset($_POST['create_lead'])){
            $this->model->createLead();
            return;
        }
        $operators   =  $this->model->getUsersByRole('operator');

        require APP . 'view/customer/header.php';
        require APP . 'view/customer/createLead.php';
        require APP . 'view/customer/footer.php';
    }

    public function editLead($lead_id){
        if(isset($_POST['edit_lead'])){
            $this->model->editLead($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }
        $operators   =  $this->model->getUsersByRole('operator');
        $operators=array_merge($operators,$this->model->getUsersByRole('result'));
        $supervisors =  $this->model->getUsersByRole('supervisor');
        $lead        =  $this->model->getLeadById($lead_id);
        $statuses=$this->model->getStatuses();
        require APP . 'view/customer/header.php';
        require APP . 'view/customer/editLead.php';
        require APP . 'view/customer/footer.php';
    }

    public function reminders(){
      //$tasks        =  $this->model->getAllTasksAdmin();
      require APP . 'view/customer/header.php';
      require APP . 'view/customer/reminders.php';
      require APP . 'view/customer/footer.php';
    }

    public function viewLead($lead_id){
        if(isset($_POST['add_task'])){
            $this->model->addTask($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }
        if(isset($_POST['add_reminder'])){
            $this->model->addReminder($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }
        if(isset($_POST['edit_reminder'])){
            $this->model->editReminder($_POST['reminder_id']);
            header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
            return;
        }
        if(isset($_POST['edit_task'])){
            $this->model->editTask($_POST['task_id']);
            header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
            return;
        }

        if(isset($_POST['edit_event'])){
            $this->model->editEvent($_POST['event_id']);
            header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
            return;
        }
        if(isset($_POST['add_event'])){
            $this->model->addEvent($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }

        if(isset($_POST['add_note'])){
            $this->model->addNote($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }

        if(isset($_POST['add_evolution'])){
            $this->model->addEvolution($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }

        if(isset($_GET['modal'])){
            $this->model->setSeen($_GET['modal']);
            $this->model->setLastChange($lead_id);
            $this->model->setSeenEvent($_GET['modal']);
            $this->model->setSeenReminder($_GET['modal']);
            $this->model->setSeenEvent($_GET['modal']);

        }
        if(isset($_GET['Customer1MonthReminder'])){
          $this->model->setSeenCustomer1MonthReminder($_GET['Customer1MonthReminder']);
        }

        $changelog   =  $this->model->getChangelog($lead_id);
        $operators    =  $this->model->getUsersByRole('operator');
        $operators=array_merge($operators,$this->model->getUsersByRole('result'));
        $operators=array_merge($operators,$this->model->getUsersByRole('customer'));
        //$supervisors  =  $this->model->getUsersByRole('supervisor');
        $events        = $this->model->getEventsAdmin($lead_id);
        $statuses=$this->model->getStatuses();
        $lead         =  $this->model->getLeadById($lead_id);
        $notes        =  $this->model->getNotesAdmin($lead_id);
        $tasks        =  $this->model->getTasksAdmin($lead_id);
        $evolutions   =  $this->model->getEvolutions($lead_id);
        $reminders    =  $this->model->getReminders($lead_id);
        //$changelog   =  $this->model->getChangelog($contract_id);
        //$statuses=$this->model->getStatuses();
        //$campaigns=$this->model->getCampaigns();
        require APP . 'view/customer/header.php';
        require APP . 'view/customer/viewLead.php';
        require APP . 'view/customer/footer.php';
    }

    public function calendar(){
      //$tasks        =  $this->model->getAllTasksAdmin();
      require APP . 'view/customer/header.php';
      require APP . 'view/customer/calendar.php';
      require APP . 'view/customer/footer.php';
    }
    public function agenda(){
      require APP . 'view/customer/header.php';
      require APP . 'view/customer/agenda.php';
      require APP . 'view/customer/footer.php';
    }

    public function activity(){
      $output=$this->model->getActivity();
      $activity=$output[1];
      $pages=ceil($output[0]/100);

      $operators    =  $this->model->getUsersByRole('operator');
      //$allchangelog   =  $this->model->getAllChangelog();
      //$tasks        =  $this->model->getAllTasksAdmin();
      require APP . 'view/customer/header.php';
      require APP . 'view/customer/activity.php';
      require APP . 'view/customer/footer.php';
    }

    //////////-documents-//////////////
    public function uploadDocuments(){
    	$this->model->uploadDocuments();
    }
    public function getDocuments($contract_id){
    	$this->model->getDocuments($contract_id);
    }
    public function getDocument($document_id){
    	$this->model->getDocument($document_id);
    }
	/////////////////////////////////

    //////////-audio-//////////////
    public function uploadAudios(){
    	$this->model->uploadAudios();
    }
    public function getAudios($contract_id){
    	$this->model->getAudios($contract_id);
    }
    public function getAudio($audio_id){
    	$this->model->getAudio($audio_id);
    }
	/////////////////////////////////

    public function profile(){
      require APP . 'view/customer/header.php';
      require APP . 'view/customer/profile.php';
      require APP . 'view/customer/footer.php';
    }

    public function users($showHours=false,$date=null){
        if ($showHours=='workhours') {
            $users=$this->model->getUsers();
            require APP . 'view/customer/header.php';
            require APP . 'view/customer/workhours.php';
            require APP . 'view/customer/footer.php';
            return;
        }elseif(!$showHours){
            $users=$this->model->getUsersByRole('teamleader');
            $users=array_merge($users,$this->model->getUsersByRole('support'));
            $users=array_merge($users,$this->model->getUsersByRole('operator'));
            require APP . 'view/customer/header.php';
            require APP . 'view/customer/users.php';
            require APP . 'view/customer/footer.php';
        }else header('location:'.APP);
    }

    public function inactiveUsers($showHours=false,$date=null){
        if ($showHours=='workhours') {
            $users=$this->model->getInactiveUsers();
            require APP . 'view/customer/header.php';
            require APP . 'view/customer/workhours.php';
            require APP . 'view/customer/footer.php';
            return;
        }elseif(!$showHours){
            $users=$this->model->getInactiveUsers();
            require APP . 'view/customer/header.php';
            require APP . 'view/customer/users.php';
            require APP . 'view/customer/footer.php';
        }else header('location:'.APP);
    }
    public function viewUser($user_id){
        $contracts=$this->model->getContractsByUser($user_id);
        require APP . 'view/customer/header.php';
        require APP . 'view/customer/viewUser.php';
        require APP . 'view/customer/footer.php';

    }

    public function createUser(){
        if(isset($_POST['create_user'])){
            $this->model->createUser();
            return;
        }
        require APP . 'view/customer/header.php';
        require APP . 'view/customer/createUser.php';
        require APP . 'view/customer/footer.php';
    }

    public function editUser($user_id){
        if(isset($_POST['upload_image'])){
            $this->model->uploadImage($user_id);
            return;
        }
        if(isset($_POST['edit_user'])){
            $this->model->editUser($user_id);
            return;
        }
        if (isset($_GET['deleteUser'])) {
             $this->model->deleteUser($user_id);
            return;
        }
        $user=$this->model->getUser($user_id);
        $supervisors   =  $this->model->getUsersByRole('supervisor');
        require APP . 'view/customer/header.php';
        if(!isset($user->user_id)){
            echo "No user found!";
        } else {
            require APP . 'view/customer/editUser.php';
        }
        require APP . 'view/customer/footer.php';
    }

    public function lists(){
      if (isset($_GET['deleteList'])) {
             $this->model->deleteList($_GET['list_id']);
            return;
        }
            $lists=$this->model->getLists();
            require APP . 'view/customer/header.php';
            require APP . 'view/customer/lists.php';
            require APP . 'view/customer/footer.php';
    }

    public function createList(){
        if(isset($_POST['create_list'])){
            $this->model->createList();
            return;
        }
        require APP . 'view/customer/header.php';
        require APP . 'view/customer/createList.php';
        require APP . 'view/customer/footer.php';
    }
    public function uploadLeads($list_id){
        $list=$this->model->getList($list_id);
        if(isset($_POST['import'])){
            $this->model->uploadLeads($list_id,$list->source);
            return;
        }
        $operators=$this->model->getUsersByRole('operator');
        $statuses=$this->model->getStatuses();
        $list->count=$this->model->countList($list_id);

        require APP . 'view/customer/header.php';
        require APP . 'view/customer/uploadLeads.php';
        require APP . 'view/customer/footer.php';
    }
////////////////////////////////////////////////////////

    public function statuses(){
            $statuses=$this->model->getStatuses();
            require APP . 'view/customer/header.php';
            require APP . 'view/customer/statuses.php';
            require APP . 'view/customer/footer.php';
    }

    public function createStatus(){
        if(isset($_POST['create_status'])){
            $this->model->createStatus();
            return;
        }
        require APP . 'view/customer/header.php';
        require APP . 'view/customer/createStatus.php';
        require APP . 'view/customer/footer.php';
    }

    public function editStatus($status_id){
        if ($status_id==1) {
            header('Location: '.URL.$_SESSION['role'].'/statuses');
            return;
        }
        if(isset($_POST['edit_status'])){
            $this->model->editStatus($status_id);
            return;
        }
        if (isset($_GET['deleteStatus'])) {
             $this->model->deleteStatus($status_id);
            return;
        }
        $status=$this->model->getStatus($status_id);
        require APP . 'view/customer/header.php';
        if(!isset($status->status_id)){
            echo "No status found!";
        } else {
            require APP . 'view/customer/editStatus.php';
        }
        require APP . 'view/customer/footer.php';
    }
//////////////////////////////////////////////////////////////

    public function editCampaign($campaign_id){
        if ($campaign_id==1) {
            header('Location: '.URL.$_SESSION['role'].'/campaigns');
            return;
        }
        if(isset($_POST['edit_campaign'])){
            $this->model->editCampaign($campaign_id);
            return;
        }
        if (isset($_GET['deleteCampaign'])) {
             $this->model->deleteCampaign($campaign_id);
            return;
        }
        $campaign=$this->model->getCampaign($campaign_id);
        require APP . 'view/customer/header.php';
        if(!isset($campaign->campaign_id)){
            echo "No campaign found!";
        } else {
            require APP . 'view/customer/editCampaign.php';
        }
        require APP . 'view/customer/footer.php';
    }
//////////////////////////////////////////////////////////////
}
