<title>Lists</title>
            <div class="content" style="margin-top: 20px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 ml-auto mr-auto text-center"></div>
                        <div class="col-md-6 ml-auto mr-auto text-center">
                            <ul style="max-width: fit-content;" class="max-width: fit-content; card nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                                <li class="nav-item">
                                      <a class="nav-link" href="createList" role="tablist">
                                          <i class="material-icons">add</i>
                                          New List
                                      </a>
                                </li>
                                <li class="nav-item">
                                      <a class="nav-link" href="<?=URL.$_SESSION['role'].'/createLead';?>" role="tablist">
                                          <i class="material-icons">add</i>
                                          New Lead
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
                                    <h4 class="title">Lists</h4>
                                    <p class="category"></p>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table">
                                        <thead >
                                            <th>List Name</th>
                                            <th>Source</th>
                                            <th>Description</th>
                                            <th>Count</th>
                                            <th><center>Action</center></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $output='';
                                                foreach ($lists as $list) {

                                                    $output.='<tr>
                                                                <td><a href="'.URL.$_SESSION['role'].'/leads/?list_id='.$list->list_id.'">'.$list->list_name.'</a></td>
                                                                <td>'.$list->source.'</td>
                                                                <td>'.$list->list_description.'</td>
                                                                <td>'.$this->model->countList($list->list_id).'</td>';
                                                  $output.='<td><center><a class="btn btn-info" href="'.URL.$_SESSION['role'].'/uploadLeads/'.$list->list_id.'">Upload Leads</a>
                                                                <a onclick="deleteList('.$list->list_id.')" class="btn btn-danger" style="background:#f44336 !important">Delete</a></center></td></tr>';
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
                $('.listsNav').addClass('active');
                <?php
                    if (isset($_SESSION['edit_list'])) {
                        if ($_SESSION['edit_list']=='success') { ?>//if edit success
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

                        <?php } elseif($_SESSION['edit_list']=='fail') { ?> //if fail
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
                        unset($_SESSION['edit_list']);
                    }

                    if (isset($_SESSION['delete_list'])) {
                        if ($_SESSION['delete_list']=='success') { ?>//if edit success
                            $.notify({
                              icon: "done",
                              message: "List Deleted!"

                            },{
                              type: 'success',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });

                        <?php } elseif($_SESSION['delete_list']=='fail') { ?> //if fail
                            $.notify({
                              icon: "error_outline",
                              message: "List deletion failed!"
                            },{
                              type: 'danger',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });
                        <?php }
                        unset($_SESSION['delete_list']);
                    }

                    if (isset($_SESSION['create_list'])) {
                        if ($_SESSION['create_list']=='success') { ?>//if edit success
                            $.notify({
                              icon: "done",
                              message: "New List created!"
                            },{
                              type: 'success',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });

                        <?php } elseif($_SESSION['create_list']=='fail'){ ?> //if fail
                            $.notify({
                              icon: "error_outline",
                              message: "List creation failed!"

                            },{
                              type: 'danger',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });
                        <?php }
                        unset($_SESSION['create_list']);
                    }
                    if (isset($_SESSION['import_list'])) {
                        if ($_SESSION['import_list']=='success') { ?>//if edit success
                            $.notify({
                              icon: "done",
                              message: "List Imported!"
                            },{
                              type: 'success',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });

                        <?php } elseif($_SESSION['import_list']=='fail'){ ?> //if fail
                            $.notify({
                              icon: "error_outline",
                              message: "List import failed!"

                            },{
                              type: 'danger',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });
                        <?php }
                        unset($_SESSION['import_list']);
                    }

                if (isset($_SESSION['delete_list'])) {
                        if ($_SESSION['delete_list']=='success') { ?>//if edit success
                            $.notify({
                              icon: "done",
                              message: "List Deleted!"
                            },{
                              type: 'success',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });
                        <?php } elseif($_SESSION['delete_list']=='fail') { ?> //if fail
                            $.notify({
                              icon: "error_outline",
                              message: "List deletion failed!"
                            },{
                              type: 'danger',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });
                        <?php }
                        unset($_SESSION['delete_list']);
                    }
                  ?>
                function deleteList(list_id) {
                    swal({
                      title:'Are you sure?',
                      text: "All leads in this list will be deleted! ",
                      type: 'warning',
                      showCancelButton: true,
                      cancelButtonColor: '#00bcd4',
                      confirmButtonColor: '#f44336',
                      confirmButtonText: 'Delete'
                    }).then((result) => {
                      if (result.value) {
                        window.location.href='?deleteList=true&list_id='+list_id;
                      }
                    })
                }

            </script>
