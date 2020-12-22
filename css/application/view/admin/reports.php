<title>Reports</title>
<style>body{background-position:center right;
        background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.3)),  url("<?php echo URL; ?>assets/img/bg_8.jpg");}

    .card{background: #000000a1!important;}
    .card-header{text-align: center;
        background: linear-gradient(to top, #0f0c29, #0a2048, #24243e)!important;}
    .card-header h4 {font-size:22px;margin-bottom:0!important;}

    .nav-custom{
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;}
    .nav-custom li a {font-size: 16px;}

    li.active{background: #112146;
        border-radius: 3px;}

    .daterangepicker{color:black;}

</style>

<div class="content">
    <div class="container-fluid">


        <ul class="nav nav-tabs nav-custom" id="myTab" role="tablist">
            <li class="nav-item active">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">R-New</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Promo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link uploadTabs" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link uploadTabs" id="na-tab" data-toggle="tab" href="#na" role="tab" aria-controls="na-tab" aria-selected="true">NI/NA/WRONG/FTD</a>
            </li>


        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane" id="contact" role="tabpanel" aria-labelledby="contact-tab"><div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header border-grey-1" data-background-color="blue">
                                <h4 class="title">Leads Transfer
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="row">

                                    <table id="table2" class="table table-hover">

                                        <thead>

                                        <tr>
                                            <th style="width: 20%;">Date <br><input type="text" id="myInput2" onkeyup="myFunction2()" placeholder="Search" title="Type in a name"></th>
                                            <th>Type</th>
                                            <th><button style="color: white; " class="btn daliabtn agent_btn">Dalia</button></th>
                                            <th><button style="color: white; " class="btn roslynbtn agent_btn">Roslyn</button></th>
                                            <th><button style="color: white; " class="btn isaacbtn agent_btn">Isaac</button></th>
                                            <th><button style="color: white; " class="btn davidebtn agent_btn">Davide</button></th>
                                            <th><button style="color: white; " class="btn endrebtn agent_btn">Endre</button></th>
                                            <th><button style="color: white; " class="btn eliasbtn agent_btn">Elias</button></th>
                                            <th><button style="color: white; " class="btn eliottbtn agent_btn">Eliott</button></th>
                                            <th><button style="color: white; " class="btn nicolebtn agent_btn">Nicole</button></th>
                                            <th><button style="color: white; " class="btn gracebtn agent_btn">Grace</button></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php foreach ($promo as $rnews):?>
                                            <tr>
                                                <td>
                                                    <?php echo $rnews['d'];?>
                                                </td>
                                                <td>

                                                    <?php if ($rnews['lead_send']==0) {
                                                        echo '<img style="width:30px" src="'.URL.'assets/img/send_lead.png">';
                                                    }else{
                                                        echo '<img style="width:30px" src="'.URL.'assets/img/lead_back.png">';
                                                    }?>
                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Dalia'];?>

                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Rosslyn'];?>
                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Isaac'];?>
                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Davide'];?>
                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Endre'];?>
                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Elias'];?>
                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Eliott'];?>
                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Nicole'];?>
                                                </td>
                                                <td style="">
                                                    <?php echo $rnews['Grace'];?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab"><div class="row">
                    <div class="col-sm-12">
                        <div class="card">

                            <div class="card-header border-grey-1" data-background-color="blue">
                                <h4 class="title">Reports
                                    <!--                            --><?php //var_dump($sources);?>
                                </h4>

                                <!-- <p class="category">Creating new user</p> -->
                            </div>
                            <div class="card-content">
                                <div class="row">

                                    <div>
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs mb-20" role="tablist">
                                            <?php foreach($sources as $key=>$source): ?>
                                                <li role="presentation" class="uploadTabs <?php if($key=='0') echo 'active';?>"><a href="#<?=str_replace(' ','_',$source['source'])?>" role="tab" data-toggle="tab"><?=$source['source']?></a></li>
                                            <?php endforeach; ?>

                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">

                                            <?php foreach($sources as $key=>$source): ?>
                                                <div role="tabpanel" class="tab-pane  <?php if($key=='0') echo 'active';?>" id="<?=str_replace(' ','_',$source['source'])?>">
                                                    <div class="">
                                                        <table id="" class="table table-hover">
                                                            <thead>

                                                            <tr>

                                                                <th>User</th>
                                                                <th>R-New</th>
                                                                <th>Low</th>
                                                                <th>Mid</th>
                                                                <th>High</th>
                                                                <th>Stock</th>
                                                                <th>No answer</th>
                                                                <th>Inactive N.A</th>
                                                                <th>FTD</th>
                                                                <th>Existing Clients</th>
                                                                <th>Wrong Person</th>
                                                                <th>Inactive N.I</th>
                                                                <th>Attempting</th>
                                                                <th>Promo</th>

                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <?php foreach ($this->model->getReports($source['source']) as $report):?>
                                                                <tr>
                                                                    <td style="text-align: left;">
                                                                        <?php if($report['username']=='Roslyn-Blanchard')
                                                                        {
                                                                            echo '<button style="color: white;width:160px;" class="btn roslynbtn agent_btn">'.$report['username'].'</button>'; }


                                                                        elseif ($report['username']=='Dalia-Gosselin')
                                                                        {

                                                                            echo '<button style="color: white;width:160px;" class="btn daliabtn agent_btn">'.$report['username'].'</button>'; }

                                                                        elseif ($report['username']=='Endre Gal')
                                                                        {

                                                                            echo '<button style="color: white;width:160px;" class="btn endrebtn agent_btn">'.$report['username'].'</button>'; }

                                                                        elseif ($report['username']=='Davide-Zanetti')
                                                                        {

                                                                            echo '<button style="color: white;width:160px;" class="btn davidebtn agent_btn">'.$report['username'].'</button>'; }

                                                                        elseif ($report['username']=='Isaac-Thomas')
                                                                        {

                                                                            echo '<button style="color: white;width:160px;" class="btn isaacbtn agent_btn">'.$report['username'].'</button>'; }

                                                                        elseif ($report['username']=='Eliass Athan')
                                                                        {

                                                                            echo '<button style="color: white;width:160px;" class="btn eliasbtn agent_btn">'.$report['username'].'</button>';
                                                                        }

                                                                        elseif ($report['username']=='Grace-Hoover')
                                                                        {

                                                                            echo '<button style="color: white;width:160px;" class="btn gracebtn agent_btn">'.$report['username'].'</button>';
                                                                        }

                                                                        elseif ($report['username']=='Eliott-Pope')
                                                                        {

                                                                            echo '<button style="color: white;width:160px;" class="btn eliottbtn agent_btn">'.$report['username'].'</button>';
                                                                        }

                                                                        elseif ($report['username']=='Nicole-Lecrec')
                                                                        {

                                                                            echo '<button style="color: white;width:160px;" class="btn nicolebtn agent_btn">'.$report['username'].'</button>';
                                                                        }
                                                                        else
                                                                            echo '<button style="color: white;" class="btn">'.$report['username'].'</button>';


                                                                        ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['R-New']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Low']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Mid']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['High']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Stock']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['No answer']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Inactive N.A']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['FTD']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Existing Clients']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Wrong Person']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Inactive N.I']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Attempting']; ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo $report['Promo']; ?>
                                                                    </td>

                                                                </tr>
                                                            <?php endforeach;?>
                                                            </tbody>
                                                            <a style="background: #534f4a;padding: 2px 8px;border-radius: 3px;" href="<?php echo URL;?>admin/exportReportsAll/<?=str_replace(' ','_',$source['source'])?>">Export</a>
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
            <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header border-grey-1" data-background-color="blue">
                                <h4 class="title">Assigned Leads R-New
                                </h4>
                            </div>
                            <div class="card-content">
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
                                                        <table id="table<?=$user->user_id?>" class="table table-hover">
                                                            <thead>

                                                            <tr>

                                                                <th style="">Date <br>
                                                                    <form method="POST" action="">
                                                                        <input autocomplete="off"  type="text" id="myInput" name="log_time" placeholder="Search" title="Type in a name">
                                                                        <button type="submit">Search</button>
                                                                    </form>
                                                                </th>
                                                                <?php foreach($sources as $key=>$source): ?>
                                                                    <th><?=$source['source']?></th>
                                                                <?php endforeach;?>
                                                                <!--                                                        <th>Endre</th>-->
                                                                <!--                                                        <th>Elias</th>-->

                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <?php foreach ($this->model->getRnew($user->user_id) as $rnews):?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $rnews['d'];?>
                                                                    </td>
                                                                    <?php foreach($sources as $key=>$source): ?>

                                                                        <td style="">
                                                                            <?php echo $rnews[$source['source']];?>
                                                                        </td>
                                                                    <?php endforeach;?>


                                                                    <!--                                                            <td style="">-->
                                                                    <!--                                                                --><?php //echo $rnews['Endre'];?>
                                                                    <!--                                                            </td>-->
                                                                    <!--                                                            <td style="">-->
                                                                    <!--                                                                --><?php //echo $rnews['Elias'];?>
                                                                    <!--                                                            </td>-->
                                                                </tr>
                                                            <?php endforeach;?>
                                                            </tbody>
                                                            <a style="background: #534f4a;padding: 2px 8px;border-radius: 3px;" href="<?php echo URL;?>admin/exportRnewReports/<?=$user->user_id?>">Export</a>

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

            <div class="tab-pane" id="na" role="tabpanel" aria-labelledby="na-tab">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header border-grey-1" data-background-color="blue">
                                <h4 class="title">Assigned Leads R-New
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="row">


                                    <div>
                                        <ul class="nav nav-tabs mb-20" role="tablist">
                                            <?php foreach($users as $key=>$user): ?>
                                                <li role="presentation" class="uploadTabs <?php if($key==0) echo 'active';?>"><a href="#new<?=$user->user_id?>" role="tab" data-toggle="tab"><?=$this->model->user_tab($user)?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <div class="tab-content">

                                            <?php foreach($users as $key=>$user): ?>
                                                <div role="tabpanel" class="tab-pane <?php if($key==0) echo 'active';?>" id="new<?=$user->user_id?>">
                                                    <div class="">
                                                        <table id="table<?=$user->user_id?>" class="table table-hover">
                                                            <thead>

                                                            <tr>

                                                                <th style="">Date <br>
                                                                    <form method="POST" action="">
                                                                        <input autocomplete="off"  type="text" id="myInput" name="log_time" placeholder="Search" title="Type in a name">
                                                                        <button type="submit">Search</button>
                                                                    </form>
                                                                </th>
                                                                <?php foreach($statuses as $key=>$status): ?>
                                                                    <th><?=$status['c']?></th>
                                                                <?php endforeach;?>

                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            <?php foreach ($this->model->getRemoveLeads($user->user_id) as $removed):?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $removed['d'];?>
                                                                    </td>
                                                                    <?php foreach($statuses as $key=>$status): ?>

                                                                        <td style="">
                                                                            <?php echo $removed[$status['c']];?>
                                                                        </td>
                                                                    <?php endforeach;?>
                                                                </tr>
                                                            <?php endforeach;?>
                                                            </tbody>
                                                            <a style="background: #534f4a;padding: 2px 8px;border-radius: 3px;" href="<?php echo URL;?>admin/exportReports/<?=$user->user_id?>">Export</a>
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

                </div></div>

        </div>












    </div>



</div>
</div>
</div>

</div>
</div>
<script>
    $('.reportsNav').addClass('animationbtn');
    function myFunction(e, tableId) {
        console.log('e: ', e,' table: ',tableId);
        var input, filter, table, tr, td, i, txtValue;
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(e) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function myFunction2() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput2");
        filter = input.value.toUpperCase();
        table = document.getElementById("table2");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

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
