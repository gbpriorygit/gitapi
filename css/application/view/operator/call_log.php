<title>Call Log</title>
<style>
    body{
        background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.2)),  url("<?php echo URL; ?>assets/img/mobile1.jpg");
        background-position:top;
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
                                            <th>From</th>
                                       </thead>
                                        <tbody>
                                            <?php
                                                $output='';
                                                foreach ($call_log as $log) {
                                                    $leadi= $this->model->getLeadById($log->lead_id);
                                                    if ($leadi) {
                                                      $name=$leadi->first_name." ".$leadi->last_name;
                                                      $href='href="'.URL.$_SESSION['role'].'/viewLead/'.$log->lead_id.'"';
                                                    }else{
                                                      $name=$log->phone_number;
                                                      $href="";
                                                    }

                                                    if ($log->direction=="in") {
                                                      $direction='<img style="width:30px" src="//any1coin.net/dashboard/assets/img/incoming.png">';
                                                    }else{
                                                      $direction='<img style="width:30px" src="//any1coin.net/dashboard/assets/img/outgoing.png">';
                                                    }
                                                    $output.='<tr>
                                                                <td>'.$direction.'</td>
                                                                <td><a '.$href.'>'.$name.'</a></td>
                                                                <td>'.$log->calltime.'</td>
                                                                <td>'.$log->from_number.'</td>
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
