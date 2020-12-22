<?php
if(!isset($_SESSION['username'])){ header('Location:'.URL); return; };
if($_SESSION['role']!='operator') { header('Location:'.URL); return; };
/**
 * //echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit(); debug sql
 */
class operator extends Controller
{


    public function index(){

        $documents=$this->model->getUploads_test();

       if ($documents>0){header('Location:'.URL.$_SESSION['role'].'/upload');}

       elseif ($documents==0){header('Location:'.URL.$_SESSION['role'].'/leads');}

       else{header('Location:'.URL.$_SESSION['role'].'/emails');}


    }


    public function call_log(){
      $call_log=$this->model->getCallLog();

      require APP . 'view/operator/header.php';
      require APP . 'view/operator/call_log.php';
      require APP . 'view/operator/footer.php';
    }

    public function links($link){
      require APP . 'view/operator/header.php';
      require APP . 'view/operator/links/'.$link.'.php';
      require APP . 'view/operator/footer.php';
    }

    public function profile(){
      $show_fop =$this->model->getUserShowFop();
//      $pwd =$this->model->new_funct();
      require APP . 'view/operator/header.php';
      require APP . 'view/operator/profile.php';
      require APP . 'view/operator/footer.php';
    }

    function leads(){
            //$operators=$this->model->getUsersByRole('operator');
    	  $output=$this->model->getLeads();
        $leads=$output[1];
        $pages=ceil($output[0]/100);
        $countleads=$output[0];

        $statuses=$this->model->getStatuses();
        //$sources=$this->model->getSources();

        $sources=$this->model->getSources();
   		  require APP . 'view/operator/header.php';
        require APP . 'view/operator/leads.php';
        require APP . 'view/operator/footer.php';
    }

    // public function createLead(){
    //     if(isset($_POST['create_lead'])){
    //         $this->model->createLead();
    //         return;
    //     }
    //     //$operators   =  $this->model->getUsersByRole('operator');
    //     //$supervisors =  $this->model->getUsersByRole('supervisor');
    //     //$campaigns=$this->model->getCampaigns();
    //     require APP . 'view/operator/header.php';
    //     require APP . 'view/operator/createLead.php';
    //     require APP . 'view/operator/footer.php';
    // }

    public function editLead($lead_id){
        if(isset($_POST['edit_lead'])){
            $this->model->editLead($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }
        $operators   =  $this->model->getUsersByRole('operator');
        $supervisors =  $this->model->getUsersByRole('supervisor');
        $lead        =  $this->model->getLeadById($lead_id);
        $statuses=$this->model->getStatuses();
        if (!isset($lead->lead_id)) {
          header("Location:".URL.$_SESSION['role'].'/leads/');
          return;
        }
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/editLead.php';
        require APP . 'view/operator/footer.php';
    }

    public function upload(){
        $user=$this->model->getUser($_SESSION['user_id']);
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/upload.php';
        require APP . 'view/operator/footer.php';
    }

    public function nextLead($currentLead,$status,$direction){
      $next=$this->model->getNextLead($currentLead,$status,$direction);
      if (isset($next)) {
        header("Location:".URL.$_SESSION['role'].'/viewLead/'.$next.'?status%5B%5D='.$status);
      }else{
        if ($status=='all') {
          header("Location:".URL.$_SESSION['role'].'/leads/');
          return;
        }
        header("Location:".URL.$_SESSION['role'].'/leads/?status%5B%5D='.$status);
      }
    }

    public function viewLead($lead_id){
        if(isset($_POST['edit_lead'])){
            $this->model->editLead($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }
        if(isset($_POST['edit_task'])){
            $this->model->editTask($_POST['task_id']);
            header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
            return;
        }

        if(isset($_POST['add_task'])){
            $this->model->addTask($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }

        if(isset($_POST['edit_reminder'])){
            $this->model->editReminder($_POST['reminder_id']);
            header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
            return;
        }

        if(isset($_POST['add_reminder'])){
            $this->model->addReminder($lead_id);
            $this->model->setLastChange($lead_id);
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

        if(isset($_POST['add_evolution'])){
            $this->model->addEvolution($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }

        if(isset($_POST['add_note'])){
            $this->model->addNote($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }
        
        
        if(isset($_POST['add_academy_note'])){
            $this->model->addAcademyNote($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }
        
        if(isset($_GET['modal'])){
            $this->model->setSeen($_GET['modal']);
            $this->model->setSeenEvent($_GET['modal']);
            $this->model->setSeenReminder($_GET['modal']);

            $this->model->setLastChange($lead_id);
        }
        $operators    =  $this->model->getUsersByRole('operator');
        $changelog   =  $this->model->getChangelog($lead_id);
        //$supervisors  =  $this->model->getUsersByRole('supervisor');
        $statuses=$this->model->getStatuses();
        $lead         =  $this->model->getLeadById($lead_id);
        $notes        =  $this->model->getNotes($lead_id);
        $academy_comments = $this->model->getAcademyComments($lead_id);
        $tasks        =  $this->model->getTasks($lead_id);
        $events        = $this->model->getEvents($lead_id);
        $evolutions   =  $this->model->getEvolutions($lead_id);
        $reminders    =  $this->model->getReminders($lead_id);

        if(isset($_GET['result'])) {
            $this->model->resetAssignedTo($lead->lead_id);
            $this->model->lead_send($lead->phone_number,$lead->assigned_to);
            header("Location:".URL.$_SESSION['role'].'/leads/?result=transferred');
            return;
        }

        //$changelog   =  $this->model->getChangelog($contract_id);
        //$statuses=$this->model->getStatuses();
        //$campaigns=$this->model->getCampaigns();
        if (!isset($lead->lead_id)) {
          header("Location:".URL.$_SESSION['role'].'/leads/');
          return;
        }
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/viewLead.php';
        require APP . 'view/operator/footer.php';
    }

    public function viewLead_test($lead_id){
        if(isset($_POST['edit_lead'])){
            $this->model->editLead($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }
        if(isset($_POST['edit_task'])){
            $this->model->editTask($_POST['task_id']);
            header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
            return;
        }

        if(isset($_POST['add_task'])){
            $this->model->addTask($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }

        if(isset($_POST['edit_reminder'])){
            $this->model->editReminder($_POST['reminder_id']);
            header("Location:".URL.$_SESSION['role'].'/viewLead/'.$lead_id);
            return;
        }

        if(isset($_POST['add_reminder'])){
            $this->model->addReminder($lead_id);
            $this->model->setLastChange($lead_id);
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

        if(isset($_POST['add_evolution'])){
            $this->model->addEvolution($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }

        if(isset($_POST['add_note'])){
            $this->model->addNote($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }


        if(isset($_POST['add_academy_note'])){
            $this->model->addAcademyNote($lead_id);
            $this->model->setLastChange($lead_id);
            return;
        }

        if(isset($_GET['modal'])){
            $this->model->setSeen($_GET['modal']);
            $this->model->setSeenEvent($_GET['modal']);
            $this->model->setSeenReminder($_GET['modal']);

            $this->model->setLastChange($lead_id);
        }
        $operators    =  $this->model->getUsersByRole('operator');
        $changelog   =  $this->model->getChangelog($lead_id);
        //$supervisors  =  $this->model->getUsersByRole('supervisor');
        $statuses=$this->model->getStatuses();
        $lead         =  $this->model->getLeadById($lead_id);
        $notes        =  $this->model->getNotes($lead_id);
        $academy_comments = $this->model->getAcademyComments($lead_id);
        $tasks        =  $this->model->getTasks($lead_id);
        $events        = $this->model->getEvents($lead_id);
        $evolutions   =  $this->model->getEvolutions($lead_id);
        $reminders    =  $this->model->getReminders($lead_id);

        if(isset($_GET['result'])) {
            $this->model->resetAssignedTo($lead->lead_id);
            $this->model->lead_send($lead->phone_number,$lead->assigned_to);
            header("Location:".URL.$_SESSION['role'].'/leads/?result=transferred');
            return;
        }

        //$changelog   =  $this->model->getChangelog($contract_id);
        //$statuses=$this->model->getStatuses();
        //$campaigns=$this->model->getCampaigns();
        if (!isset($lead->lead_id)) {
            header("Location:".URL.$_SESSION['role'].'/leads/');
            return;
        }
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/viewLead_test.php';
        require APP . 'view/operator/footer.php';
    }

    public function emails(){
        $emails =  $this->model->getAllEmailsOperator();
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/emails.php';
        require APP . 'view/operator/footer.php';
    }


    public function calendar(){
      //$tasks        =  $this->model->getAllTasks();
      require APP . 'view/operator/header.php';
      require APP . 'view/operator/calendar.php';
      require APP . 'view/operator/footer.php';
    }

    public function reminders(){
      //$tasks        =  $this->model->getAllTasks();
      require APP . 'view/operator/header.php';
      require APP . 'view/operator/reminders.php';
      require APP . 'view/operator/footer.php';
    }

    public function agenda(){
      //$tasks        =  $this->model->getAllTasks();
      require APP . 'view/operator/header.php';
      require APP . 'view/operator/agenda.php';
      require APP . 'view/operator/footer.php';
    }

    public function activity(){
      $output=$this->model->getActivity();
      $activity=$output[1];
      $pages=ceil($output[0]/100);

      //$operators    =  $this->model->getUsersByRole('operator');
      //$allchangelog   =  $this->model->getAllChangelog();
      //$tasks        =  $this->model->getAllTasksAdmin();
      require APP . 'view/operator/header.php';
      require APP . 'view/operator/activity.php';
      require APP . 'view/operator/footer.php';
    }
    //////////-documents-//////////////
    public function uploadCV(){
    	$this->model->uploadCV();
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

    public function users($showHours=false,$date=null){
        if ($showHours=='workhours') {
            $users=$this->model->getUsers();
            require APP . 'view/operator/header.php';
            require APP . 'view/operator/workhours.php';
            require APP . 'view/operator/footer.php';
            return;
        }elseif(!$showHours){
            $users=$this->model->getUsers();
            require APP . 'view/operator/header.php';
            require APP . 'view/operator/users.php';
            require APP . 'view/operator/footer.php';
        }else header('location:'.APP);
    }

    public function inactiveUsers($showHours=false,$date=null){
        if ($showHours=='workhours') {
            $users=$this->model->getInactiveUsers();
            require APP . 'view/operator/header.php';
            require APP . 'view/operator/workhours.php';
            require APP . 'view/operator/footer.php';
            return;
        }elseif(!$showHours){
            $users=$this->model->getInactiveUsers();
            require APP . 'view/operator/header.php';
            require APP . 'view/operator/users.php';
            require APP . 'view/operator/footer.php';
        }else header('location:'.APP);
    }
    public function viewUser($user_id){
        $contracts=$this->model->getContractsByUser($user_id);
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/viewUser.php';
        require APP . 'view/operator/footer.php';

    }

    public function createUser(){
        if(isset($_POST['create_user'])){
            $this->model->createUser();
            return;
        }
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/createUser.php';
        require APP . 'view/operator/footer.php';
    }

    public function editUser($user_id){
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
        require APP . 'view/operator/header.php';
        if(!isset($user->user_id)){
            echo "No user found!";
        } else {
            require APP . 'view/operator/editUser.php';
        }
        require APP . 'view/operator/footer.php';
    }

    public function lists(){
      if (isset($_GET['deleteList'])) {
             $this->model->deleteList($_GET['list_id']);
            return;
        }
            $lists=$this->model->getLists();
            require APP . 'view/operator/header.php';
            require APP . 'view/operator/lists.php';
            require APP . 'view/operator/footer.php';
    }

    public function getAllTasks(){
        $sql='SELECT tasks.*,users.first_name,users.last_name FROM tasks LEFT JOIN users ON users.user_id = tasks.user_id where tasks.user_id=:user_id and  MONTH(`start`) = MONTH(CURRENT_DATE()) AND YEAR(`start`) = YEAR(CURRENT_DATE())  order by `task_id` desc limit 6';
        $query = $this->db->prepare($sql);
        $query->execute(array(':user_id'=>$_SESSION['user_id']));
        return $query->fetchAll();
    }

    public function createList(){
        if(isset($_POST['create_list'])){
            $this->model->createList();
            return;
        }
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/createList.php';
        require APP . 'view/operator/footer.php';
    }
    public function uploadLeads($list_id){
        $list=$this->model->getList($list_id);
        if(isset($_POST['import'])){
            $this->model->uploadLeads($list_id,$list->source);
            return;
        }
        $operators=$this->model->getUsersByRole('operator');

        $list->count=$this->model->countList($list_id);

        require APP . 'view/operator/header.php';
        require APP . 'view/operator/uploadLeads.php';
        require APP . 'view/operator/footer.php';
    }
////////////////////////////////////////////////////////

    public function statuses(){
            $statuses=$this->model->getStatuses();
            require APP . 'view/operator/header.php';
            require APP . 'view/operator/statuses.php';
            require APP . 'view/operator/footer.php';
    }

    public function createStatus(){
        if(isset($_POST['create_status'])){
            $this->model->createStatus();
            return;
        }
        require APP . 'view/operator/header.php';
        require APP . 'view/operator/createStatus.php';
        require APP . 'view/operator/footer.php';
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
        require APP . 'view/operator/header.php';
        if(!isset($status->status_id)){
            echo "No status found!";
        } else {
            require APP . 'view/operator/editStatus.php';
        }
        require APP . 'view/operator/footer.php';
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
        require APP . 'view/operator/header.php';
        if(!isset($campaign->campaign_id)){
            echo "No campaign found!";
        } else {
            require APP . 'view/operator/editCampaign.php';
        }
        require APP . 'view/operator/footer.php';
    }
//////////////////////////////////////////////////////////////
}
