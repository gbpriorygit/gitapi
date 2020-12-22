<title>Call Log</title>
<style>
    body{
        background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.2)),  url("<?php echo URL; ?>assets/img/mobile1.jpg");
            }

    .daterangepicker{color:black;}
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
                                            <form method="POST" action="">
                                            <th style="">Date <br>

                                                    <input autocomplete="off"  type="text" id="myInput" name="log_time" placeholder="Search" title="Type in a name">

                                            </th>
                                            <th>User
                                                <select name="apertura" id="apertura">
                                                    <?php
                                                     $output='';
                                                     foreach  ($users as $user) {

                                                   $output='<option value="'.$user->user_id.'">'.$user->username.'</option>';

                                                    echo $output;
                                                     }
                                                    ?>
                                                </select>

                                            </th>

                                             <button type="submit">Search</button>
                                            </form>
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

                                                    if ($log->direction=='in') {
                                                      $direction='<img style="width:30px" src="'.URL.'assets/img/recieved_call.png">';
                                                    }else{
                                                      $direction='<img style="width:30px" src="'.URL.'assets/img/missed_call.png">';
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
                $('.calllogNav').addClass('animationbtn');
            </script>

<script>
    <?php if (!isset($_GET['last_change'])): ?>
    $('input[name="log_time"]').daterangepicker({
        startDate: '01-01-2020', // after open picker you'll see this dates as picked
        endDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY',
            cancelLabel: 'Clear'
        },
        autoUpdateInput: false,
        ranges: {
            'Today': [moment(), moment().add(1,'days')],

            'This Week': [moment().startOf('week'), moment().add(1,'days')],
            'This Month': [moment().startOf('month'), moment().endOf('month').add(1,'days')],
            'All Time': ['01-01-2018',moment()]
        }
    });
    $('input[name="log_time"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
    });

    $('input[name="log_time"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    <?php elseif($_GET['log_time']==''): ?>
    $('input[name="log_time"]').daterangepicker({
        startDate: '01-01-2020', // after open picker you'll see this dates as picked
        endDate: new Date(),
        locale: {
            format: 'DD-MM-YYYY',
            cancelLabel: 'Clear'
        },
        autoUpdateInput: false,
        ranges: {
            'Today': [moment(), moment(date).add(1,'days')],
            'This Week': [moment().startOf('week'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'All Time': ['01-01-2020',moment()]
        }
    });
    $('input[name="log_time"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
    });

    $('input[name="log_time"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
    <?php else: ?>
    $('input[name="log_time"]').daterangepicker({
        locale: {
            format: 'DD-MM-YYYY',
        },
        autoUpdateInput: true,
        ranges: {
            'Today': [moment().subtract(1,'days'), moment(date).add(1,'days')],

            'This Week': [moment().startOf('week'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'All Time': ['01-01-2020',moment()]
        }
    });
    <?php endif; ?>
</script>