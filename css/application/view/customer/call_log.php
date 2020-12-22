<title>Call Log</title>
<style>
    body{
        background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.3)),  url("<?php echo URL; ?>assets/img/bgchess.jpg");
    }
</style>
            <div class="content" style="margin-top: 30px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">
                                    <h4 class="title">Call Log</h4>
                                    <p class="category"></p>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table">
                                        <thead >
                                            <th></th>
                                            <th>Lead</th>
                                            <th>Time</th>
                                            <th>User</th>
                                       </thead>
                                        <tbody>
                                            <?php
                                                $output='';
                                                foreach ($call_log as $log) {
                                                    $useri= $this->model->getUser($log->user_id);
                                                    $leadi= $this->model->getLeadById($log->lead_id);
                                                    $user_name=$useri->first_name." ".$useri->last_name;
                                                    if ($leadi) {
                                                      $name=$leadi->first_name." ".$leadi->last_name;
                                                      $href='href="'.URL.$_SESSION['role'].'/viewLead/'.$log->lead_id.'"';
                                                    }else{
                                                      $name=$log->phone_number;
                                                      $href="";
                                                    }

                                                    if ($log->direction=="in") {
                                                      $direction='<i class="material-icons">call_received</i>';
                                                    }else{
                                                      $direction='<i class="material-icons">call_made</i>';
                                                    }
                                                    $output.='<tr>
                                                                <td>'.$direction.'</td>
                                                                <td><a '.$href.'>'.$name.'</a></td>
                                                                <td>'.$log->calltime.'</td>
                                                                <td>'.$user_name.'</td>
                                                                </tr>';
                                                }
                                                echo $output;
                                             ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $('.calllogNav').addClass('active');
            </script>
