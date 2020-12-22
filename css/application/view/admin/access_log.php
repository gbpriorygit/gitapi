<title>Access Log</title>
<style>
    body{
        background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.2)),  url("<?php echo URL; ?>assets/img/bg_2.jpg");
    }
    .daterangepicker {
        color: black;
    }
    .card{background: #00000052!important;}
    .card-header{text-align: center;
        background: linear-gradient(to top, #0f0c29, #0a2048, #24243e)!important;}
    .card-header h4 {font-size:22px;margin-bottom:0!important;}
</style>
<div class="content" style="margin-top: 30px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Access Log</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-content table-responsive">

                        <div class="row">
                            <div>
                                <ul class="nav nav-tabs mb-20" role="tablist">
                                    <?php foreach($users as $key=>$user): ?>
                                        <li role="presentation" class="uploadTabs <?php if($key==0) echo 'active';?>"><a href="#<?=$user->user_id?>" role="tab" data-toggle="tab"><?=$this->model->user_tab($user)?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tab-content">

                                    <?php foreach($users as $key=>$user): ?>
                                        <div role="tabpanel" class="tab-pane  <?php if($key==0) echo 'active';?>" id="<?=$user->user_id?>">
                                            <div class="">
                                                <table id="table" class="table table-hover">
                                                    <thead>

                                                    <tr>
                                                        <th>Type</th>

                                                        <th style="">Date <br>
                                                            <form method="POST" action="">
                                                                <input autocomplete="off"  type="text" id="myInput" name="log_time" placeholder="Search" title="Type in a name">
                                                                <button type="submit">Search</button>
                                                            </form>
                                                        </th>

                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php
                                                    $allLogs=$this->model->getAccessLogs($user->user_id);
                                                    foreach ($allLogs[0] as $access):?>
                                                        <tr>
                                                            <td style="width: 40%;">
                                                                <?php if ($access['access_type']=="login") {
                                                                    echo '<img style="width:30px" src="'.URL.'assets/img/login.png">';
                                                                }else{
                                                                    echo '<img style="width:30px" src="'.URL.'assets/img/logout.png">';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $access['d'];?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.accessLogNav').addClass('animationbtn');
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