<title>Result</title>
<style>
    body{
        background-image:linear-gradient(rgba(0,0,0,0.2),rgba(0,0,0,0.1)),  url("<?php echo URL; ?>assets/img/bglion2.jpg");
        background-position: top;
    background-repeat: no-repeat!important;
    }
</style>
            <div class="content" style="margin-top: 20px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 ml-auto mr-auto text-center"></div>
                        <div class="col-md-6 ml-auto mr-auto text-center">
                            <ul style="max-width: fit-content;" class="max-width: fit-content; card nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                                <li class="nav-item active">
                                      <a class="nav-link" href="" role="tablist">
                                          <i class="material-icons">person</i>
                                          Users
                                      </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="createUser" role="tablist">
                                        <i class="material-icons">person_add</i>
                                        Create User
                                    </a>
                            </ul>
                        </div>
                        <div class="col-md-3 ml-auto mr-auto text-center"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">
                                    <h4 class="title">Users</h4>
                                    <!-- <p class="category"><a href="../admin/inactiveUsers">Utenti non attivi</a></p> -->
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Filter</label>
                                        <input type="text" id="inpu" onkeyup="filterTabl()" class="form-control">
                                    <span class="material-input"></span></div>
                                </div>
                                <div class="card-content table-responsive">
                                  <table class="table" id="tabl">
                                      <thead >
                                          <th>Name</th>
                                          <th>Role</th>
                                          <!-- <th>Supervisor</th> -->
                                          <th><center></center></th>

                                      </thead>
                                      <tbody>
                                          <?php
                                              $output='';
                                              //<td><a class="user_name_l" href="viewUser/'.$user->user_id.'">'.$user->first_name.' '.$user->last_name.'</a></td>
                                              foreach ($users as $user) {
                                                  if ($user->role!='admin' && $user->role!='manager') {
                                                    $output.='<tr>
                                                                <td><a class="user_name_l" href="'.URL.$_SESSION['role'].'/leads/?assigned_to%5B%5D='.$user->user_id.'">'.$user->first_name.' '.$user->last_name.'</a></td>

                                                                <td>'.$user->role.'</td>

                                                                <td><a title="Edit user" target="_blank" c class="btn btn-info user_l" href="'.URL.$_SESSION['role'].'/editUser/'.$user->user_id.'" ><i class="material-icons">edit</i></a>
                                                                <a title="View user" target="_blank" class="btn btn-info user_l" href="'.URL.$_SESSION['role'].'/viewUser/'.$user->user_id.'" ><i class="material-icons">info</i></a>
                                                                <a  title="Login as user" target="_blank" c href="'.URL.'api/loginAsUser/'.$user->user_id.'" class="btn btn-info user_l" ><i class="material-icons">perm_identity</i></a>
                                                                <a class="btn btn-info user_l tolt" title="'.$user->password.'"><i class="material-icons">visibility</i></a></td>
                                                            </tr>';
                                                  }
                                              }
                                              //<td>'.$this->model->getSupervisorByOperator($user->supervisor).'</td>
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
                $('.resultNav').addClass('active');
                $('.tolt').tooltip({ trigger: "manual" , html: true, animation:false})
                  .on("mouseenter", function () {
                      var _this = this;
                      $(this).tooltip("show");
                      $(".tooltip").on("mouseleave", function () {
                          $(_this).tooltip('hide');
                      });
                  }).on("mouseleave", function () {
                      var _this = this;
                      setTimeout(function () {
                          if (!$(".tooltip:hover").length) {
                              $(_this).tooltip("hide");
                          }
                      }, 300);
              });
                <?php
                    if (isset($_SESSION['edit_user'])) {
                        if ($_SESSION['edit_user']=='success') { ?>//if edit success
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

                        <?php } elseif($_SESSION['edit_user']=='fail') { ?> //if fail
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
                        unset($_SESSION['edit_user']);
                    }

                    if (isset($_SESSION['delete_user'])) {
                        if ($_SESSION['delete_user']=='success') { ?>//if edit success
                            $.notify({
                              icon: "done",
                              message: "User Deleted!"

                            },{
                              type: 'success',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });

                        <?php } elseif($_SESSION['delete_user']=='fail') { ?> //if fail
                            $.notify({
                              icon: "error_outline",
                              message: "User deletion failed!"
                            },{
                              type: 'danger',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });
                        <?php }
                        unset($_SESSION['delete_user']);
                    }

                    if (isset($_SESSION['create_user'])) {
                        if ($_SESSION['create_user']=='success') { ?>//if edit success
                            $.notify({
                              icon: "done",
                              message: "New user created!"
                            },{
                              type: 'success',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });

                        <?php } elseif($_SESSION['create_user']=='fail'){ ?> //if fail
                            $.notify({
                              icon: "error_outline",
                              message: "User creation failed!"

                            },{
                              type: 'danger',
                              timer: 300,
                              placement: {
                                  from: 'top',
                                  align: 'right'
                              }
                            });
                        <?php }
                        unset($_SESSION['create_user']);
                    }
                ?>
function filterTabl() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("inpu");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabl");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
            </script>
