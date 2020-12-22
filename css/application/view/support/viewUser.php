<title>Edit User</title>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">
                                    <h4 class="title"><?=$user->first_name.' '.$user->last_name;?></h4>
                                    <p class="category">Edit User</p>
                                </div>
                                <div class="card-content">
                                  <div class="container">
                                      <!-- <h3 >Change Avatar</h3>
                                      <form method="post" enctype="multipart/form-data">
                                           <input type="file" name="image" id="image" />
                                           <input type="hidden" name="upload_image" value="1">
                                           <input type="hidden" name="user_id" value="<?=$user->user_id;?>">
                                           <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-info" />
                                      </form> -->

                                      <table class="table table-bordered">
                                           <tr>
                                                <th><?php $userImage=$this->model->getUserImage($user->user_id); ?>
                                                <?php if ($userImage->image==null){ ?>
                                                  No Avatar
                                                <?php } else { ?>
                                                    <img src="data:image/png;base64,<?php echo base64_encode($userImage->image);?>" style="width:100px;height:100px" alt="Avatar" >
                                                <?php } ?></th>
                                           </tr>
                                      </table>
                                 </div>
                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Username</label>
                                                    <input type="text" disabled name="username" value="<?=$user->username;?>" class="form-control" >
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Password</label>
                                                    <input type="password" disabled name="password" value="<?=$user->password;?>" class="form-control">
                                                </div>
                                            </div> -->
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" disabled name="user_email" value="<?=$user->user_email;?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-3">
                                              <div class="form-group label-floating">
                                                  <label class="control-label">SIP</label>
                                                  <input type="text" disabled name="user_sip" value="<?=$user->user_sip;?>" class="form-control">
                                              </div>
                                          </div>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">First Name</label>
                                                    <input type="text" disabled name="first_name" value="<?=$user->first_name;?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" disabled name="last_name" value="<?=$user->last_name;?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Role</label>
                                                    <select  disabled  name="role" class="form-control selectRole">
                                                        <option value="operator">Operator</option>
                                                        <option value="manager">Manager</option>
                                                        <!-- <option value="supervisor">Supervisor</option>
                                                        <option value="floor_manager">Floor Manager</option>
                                                        <option value="economist">Economist</option>-->
                                                        <option value="customer">Customer</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Recycle</label>
                                                    <select   disabled name="recycle" class="form-control recycle">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="edit_user">
                                        <!-- <a onclick="deleteUser(<?=$user->user_id;?>)" class="btn btn-danger pull-left">Delete</a> -->
                                        <a  href="<?=URL.$_SESSION['role'].'/editUser/'.$user->user_id;?>" class="btn btn-info pull-right">Edit User</a>
                                          <a href="<?=URL?>api/loginAsUser/<?=$user->user_id;?>" class="btn btn-info pull-right" >Login as user</a>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                              <div class="card">
                                  <div class="card-header" data-background-color="blue">
                                      <h4 class="title">
                                              Documents
                                      </h4>
                                  </div>
                                  <div class="card-content">
                                      <div class="row" id="docs">
                                          <!-- <form action="<?=URL?>admin/uploadDocuments" enctype="multipart/form-data" method="POST" class="col-sm-12 dz-parent">
                                            <input type="hidden" name="user_id" value="<?=$user->user_id;?>">
                                              <div id="zdrop" class="fileuploader">
                                                  <div id="upload-label" >
                                                      <span class="title">
                                                        <input  accept="application/pdf" name="documents" type="file" />
                                                      </span>
                                                  </div>
                                              </div>
                                              <button type="submit" class="btn btn-info pull-right">Upload</button>
                                          </form> -->
                                          <div class="card-content table-responsive">
                                              <table class="table table-hover">
                                                <?php
                                                  $documents=$this->model->getDocuments($user->user_id);
                                                  $output='';
                                                  foreach ($documents as $doc) {
                                                    $docname=explode("/",$doc->url);
                                                    //print_r(count($docname));
                                                    $output.="<tr><td><a target='_blank' href=".URL."api/getDocumentA/".$doc->document_id.">".$docname[count($docname)-1]."</a></td><td></td></tr>";
                                                  }
                                                  echo $output;
                                                ?>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </div>
            </div>
<script type="text/javascript">
    $(document).ready(function(){
      $("[name='password']").focus(function(){
          this.type = "text";
      }).blur(function(){
          this.type = "password";
      })

      $('#insert').click(function(){
           var image_name = $('#image').val();
           if(image_name == '')
           {
                alert("Please Select Image");
                return false;
           }
           else
           {
                var extension = $('#image').val().split('.').pop().toLowerCase();
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                {
                     alert('Invalid Image File');
                     $('#image').val('');
                     return false;
                }
           }
      });
 });
 </script>
            <script type="text/javascript">
                $('.usersNav').addClass('active');
                $('.selectRole').val('<?=$user->role;?>');
                $('.recycle').val('<?=$user->recycle;?>');
                  function deleteUser(user_id) {
                    swal({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      type: 'warning',
                      showCancelButton: true,
                      cancelButtonColor: '#00bcd4',
                      confirmButtonColor: '#f44336',
                      confirmButtonText: 'Delete'
                    }).then((result) => {
                      if (result.value) {
                        window.location.href='?deleteUser=true';
                      }
                    })
                  }

function getSupervisors(v){
    if (v=='operator') {
        $.ajax({
          url: '<?=URL;?>api/getSupervisors/',
          type: 'POST',
          dataType: 'json',
        })
        .done(function(data) {
            dataa=data;
            $('#supervisorif').html(`<div class="form-group label-floating">
                                        <label class="control-label">Supervisor</label>
                                        <select  id="supervisor" required name="supervisor" class="form-control">
                                            <option value=''></option>
                                        </select>
                                    </div>`);
            $('#supervisor').focus();
            for (var i=0;i<data.length;i++) {
               $('#supervisor').append('<option value='+data[i].user_id+'>'+data[i].full_name+'</option>');
            };
            $('#supervisorif').show();
        })
        .fail(function(err) {
            console.log(err);
        })
    }else{
        $('#supervisorif').html('');
        $('#supervisorif').hide();
    }

}

            </script>
