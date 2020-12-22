<?php
header("Access-Control-Allow-Origin: *");
class Cron extends Controller{
    public function index(){


/////////////////tasks
      $sql="SELECT count(lead_id) as count from tasks WHERE (start < NOW() - INTERVAL 1 DAY)
                                        AND (status='Pending')
                                        AND user_id in (SELECT user_id from users where role='operator');

           UPDATE leads set  assigned_to=0  where lead_id in (SELECT lead_id from tasks WHERE (start < NOW() - INTERVAL 1 DAY)
                                                                                          AND (status='Pending')
                                                                                          AND user_id in (SELECT user_id from users where role='operator'));

           DELETE FROM tasks WHERE (start < NOW() - INTERVAL 1 DAY) AND status='Pending'
                                                                    AND user_id in (SELECT user_id from users where role='operator')";

      $query=$this->db->prepare($sql);

      if ($query->execute()) {
          $count=($query->fetch());
          $sql="UPDATE users SET new_leads=new_leads+:new_leadsa WHERE role='customer'";
          $query=$this->db->prepare($sql);
          $query->bindParam(':new_leadsa',$count->count);
          $query->execute();
      };




////////////////events

      $sql="SELECT count(lead_id) as count from events WHERE (start < NOW() - INTERVAL 1 DAY)
                                        AND (status='Pending')
                                        AND user_id in (SELECT user_id from users where role='operator');

           UPDATE leads set  assigned_to=0  where lead_id in (SELECT lead_id from events WHERE (start < NOW() - INTERVAL 1 DAY)
                                                                                          AND (status='Pending')
                                                                                          AND user_id in (SELECT user_id from users where role='operator'));

           DELETE FROM events WHERE (start < NOW() - INTERVAL 1 DAY) AND status='Pending'
                                                                    AND user_id in (SELECT user_id from users where role='operator')";

      $query=$this->db->prepare($sql);

      if ($query->execute()) {
          $count=($query->fetch());
          $sql="UPDATE users SET new_leads=new_leads+:new_leadsa WHERE role='customer'";
          $query=$this->db->prepare($sql);
          $query->bindParam(':new_leadsa',$count->count);
          $query->execute();
      };




//////////reminders


      $sql="SELECT count(lead_id) as count from reminders WHERE (start < NOW() - INTERVAL 1 DAY)
                                        AND (status='Pending')
                                        AND user_id in (SELECT user_id from users where role='operator');

           UPDATE leads set  assigned_to=0  where lead_id in (SELECT lead_id from reminders WHERE (start < NOW() - INTERVAL 1 DAY)
                                                                                          AND (status='Pending')
                                                                                          AND user_id in (SELECT user_id from users where role='operator'));

           DELETE FROM reminders WHERE (start < NOW() - INTERVAL 1 DAY) AND status='Pending'
                                                                    AND user_id in (SELECT user_id from users where role='operator')";

      $query=$this->db->prepare($sql);

      if ($query->execute()) {
          $count=($query->fetch());
          $sql="UPDATE users SET new_leads=new_leads+:new_leadsa WHERE role='customer'";
          $query=$this->db->prepare($sql);
          $query->bindParam(':new_leadsa',$count->count);
          $query->execute();
      };
    }
}
