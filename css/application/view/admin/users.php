<title>Users</title>
<style>
    body{
        background-position:top;background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.1)),  url("<?php echo URL; ?>assets/img/bg_6.jpg");
    }
    .nav-pills.nav-pills-warning>li.active>a, .nav-pills.nav-pills-warning>li.active>a:focus, .nav-pills.nav-pills-warning>li.active>a:hover {background: transparent!important}

    .card{background: #00000054!important;}

    .copyPassInput{
        opacity: 0;
        width:20px !important;
    }
    .card-header{text-align: center;
        background: linear-gradient(to top, #0f0c29, #0a2048, #24243e)!important;}
    .card-header h4 {font-size:22px;margin-bottom:0!important;}
    .user_l{font-size: 17px;
        padding: 7px 19px!important;}
</style>
            <div class="content" style="margin-top: 20px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 ml-auto mr-auto text-center"></div>
                        <div class="col-md-6 ml-auto mr-auto text-center">
                            <ul style="max-width: fit-content;" class="navButtons card nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                                <li class="nav-item active animationbtn1 navBtnShadow navBtnLeft">
                                      <a class="nav-link pageButtons" href="" role="tablist">
                                          <i class="material-icons">person</i>
                                          Users
                                      </a>
                                </li>
                                <li  class="nav-item navBtnShadow animationbtn1">
                                    <a style="background-color: transparent!important;" class="nav-link  pageButtons" href="createUser" role="tablist">
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
                                <div class="card-content table-responsive">
                                    <table class="table" id="tabl">
                                        <thead >
                                            <th>Icon</th>
                                            <th>Name<br>
                                                <input type="text" id="input1" onkeyup="filterTabl1()" class=""></th></th>
                                            <th>Role<br>
                                                <input type="text" id="input2" onkeyup="filterTabl2()" class=""></th></th>
                                            <!-- <th>Supervisor</th> -->
                                            <th><center></center></th>

                                        </thead>
                                        <tbody>
                                            <?php
                                                $output='';
                                                //<td><a class="user_name_l" href="viewUser/'.$user->user_id.'">'.$user->first_name.' '.$user->last_name.'</a></td>
                                                foreach ($users as $user) {
                                                    $output.='<tr>
                                                                <td style="padding: 22px 0px;">'.$this->model->UserLogo($user->user_id).'</td>
                                                                <td style="padding: 36px 0px;"><a class="user_name_l" href="'.URL.$_SESSION['role'].'/leads/?assigned_to%5B%5D='.$user->user_id.'">'.$user->first_name.' '.$user->last_name.'</a></td>

                                                                <td style="text-transform: capitalize;padding: 26px 0;">'.$this->model->RoleLogo($user->role).'</td>

                                                                <td style="padding: 16px 0px;" ><a title="Edit user"   target="_blank" c class="btn btn-info user_l" href="'.URL.$_SESSION['role'].'/editUser/'.$user->user_id.'" ><i class="material-icons">edit</i></a>
                                                                <a title="View user"  target="_blank" class="btn btn-info user_l" href="'.URL.$_SESSION['role'].'/viewUser/'.$user->user_id.'" ><i class="material-icons">info</i></a>
                                                                <a  title="Login as user"  target="_blank" c href="'.URL.'api/loginAsUser/'.$user->user_id.'" class="btn btn-info user_l" ><i class="material-icons">perm_identity</i></a>
                                                                <a onclick="myFunction('.$user->user_id.')" class="btn btn-info user_l tolt" title="'.$user->password.'"><i class="material-icons">visibility</i></a></td>
                                                                <input id="myInput'.$user->user_id.'" class="copyPassInput" value="'.$user->password.'">
                                                            </tr>';
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
                $('.usersNav').addClass('animationbtn');
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


function filterTabl1() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("input1");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabl");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}



function filterTabl2() {
 var input, filter, table, tr, td, i;
 input = document.getElementById("input2");
 filter = input.value.toUpperCase();
 table = document.getElementById("tabl");
 tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[2];
                        if (td) {
                            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }



      $(document).ready(function(){
        $("[name='password']").focus(function(){
            this.type = "text";
        }).blur(function(){
            this.type = "password";
        })
      });


                function myFunction(index) {
                    var copyText = document.getElementById("myInput"+index);
                    copyText.select();
                    copyText.setSelectionRange(0, 99999)
                    document.execCommand("copy");
                }


            </script>
