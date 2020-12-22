<title>Status</title>

<style>
    body{
        background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.3)),  url("<?php echo URL; ?>assets/img/bg_10.jpg");
    }
    .nav-pills>li>a:hover{background: #1b2a61!important;}
    .card{background: #00000052!important;}
    .card-header{text-align: center;
        background: linear-gradient(to top, #0f0c29, #0a2048, #24243e)!important;}
    .card-header h4 {font-size:22px;margin-bottom:0!important;}
</style>
<div class="content" style="margin-top: 20px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 ml-auto mr-auto text-center"></div>
            <div class="col-md-6 ml-auto mr-auto text-center">
                <ul style="max-width: fit-content;" class="max-width: fit-content; card nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                    <li class="nav-item">
                          <a class="nav-link animationbtn1" href="createStatus" role="tablist">
                              <i class="material-icons">add</i>
                              Create Status
                          </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 ml-auto mr-auto text-center"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Status</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table">
                            <thead class="text-info">
                                <th>Status</th>
                                <th>Ratting</th>
                                <th>Recycle</th>
                                <th>Leads</th>
                                <th><center>Action</center></th>
                            </thead>
                            <tbody>
                                <?php
                                    $output='';
                                    foreach ($statuses as $status) {

                                        $output.='<tr>
                                                    <td>'.$status->status_name.'</td>
                                                    <td>'.$status->status_description.'</td>
                                                    <td><a href="'.URL.$_SESSION['role'].'/recycle?status%5B%5D='.$status->status_id.'">'.$this->model->countByStatusRecycle($status->status_id).'</a></td>
                                                    <td><a href="'.URL.$_SESSION['role'].'/leads?status%5B%5D='.$status->status_id.'">'.$this->model->countByStatus($status->status_id).'</a></td>';
                                             $output.='<td><center><a type="button" rel="tooltip" class="btn btn-info user_l" href="'.URL.$_SESSION['role'].'/editStatus/'.$status->status_id.'" ><i class="material-icons">edit</i></a></center></td></tr>';
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
    $('.statusNav').addClass('animationbtn');
    <?php
        if (isset($_SESSION['edit_status'])) {
            if ($_SESSION['edit_status']=='success') { ?>//if edit success
                $.notify({
                  icon: "done",
                  message: "Changes saved!"
                },{
                  type: 'success',
                  timer: 300,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
                });

            <?php } elseif($_SESSION['edit_status']=='fail') { ?> //if fail
                $.notify({
                  icon: "error_outline",
                  message: "An error occurred!"
                },{
                  type: 'danger',
                  timer: 300,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
                });
            <?php }
            unset($_SESSION['edit_status']);
        }

        if (isset($_SESSION['delete_status'])) {
            if ($_SESSION['delete_status']=='success') { ?>//if edit success
                $.notify({
                  icon: "done",
                  message: "Status Deleted!"

                },{
                  type: 'success',
                  timer: 300,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
                });

            <?php } elseif($_SESSION['delete_status']=='fail') { ?> //if fail
                $.notify({
                  icon: "error_outline",
                  message: "Status deletion failed!"
                },{
                  type: 'danger',
                  timer: 300,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
                });
            <?php }
            unset($_SESSION['delete_status']);
        }

        if (isset($_SESSION['create_status'])) {
            if ($_SESSION['create_status']=='success') { ?>//if edit success
                $.notify({
                  icon: "done",
                  message: "New Status created!"
                },{
                  type: 'success',
                  timer: 300,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
                });

            <?php } elseif($_SESSION['create_status']=='fail'){ ?> //if fail
                $.notify({
                  icon: "error_outline",
                  message: "Status creation failed!"

                },{
                  type: 'danger',
                  timer: 300,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
                });
            <?php }
            unset($_SESSION['create_status']);
        }



        if (isset($_SESSION['update_statuses'])) {
            if ($_SESSION['update_statuses']=='success') { ?>//if edit success
                $.notify({
                  icon: "done",
                  message: "Status Updated!"
                },{
                  type: 'success',
                  timer: 300,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
                });

            <?php } elseif($_SESSION['update_statuses']=='fail'){ ?> //if fail
                $.notify({
                  icon: "error_outline",
                  message: "Staus update failed!"

                },{
                  type: 'danger',
                  timer: 300,
                  placement: {
                      from: 'top',
                      align: 'right'
                  }
                });
            <?php }
            unset($_SESSION['update_statuses']);
        }

    ?>
</script>
