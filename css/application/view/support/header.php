<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL; ?>assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="<?php echo URL; ?>assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="<?php echo URL; ?>assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo URL; ?>assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <link href="<?php echo URL; ?>assets/css/demo.css" rel="stylesheet" />
    <link href="<?php echo URL; ?>assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo URL; ?>assets/css/material-icons.css" rel="stylesheet" />
    <script src="<?php echo URL; ?>assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo URL; ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo URL; ?>assets/js/material.min.js" type="text/javascript"></script>
    <script src="<?php echo URL; ?>assets/js/arrive.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/bootstrap-notify.js"></script>
    <script src="<?php echo URL; ?>assets/js/material-dashboard.js?v=1.2.0"></script>
    <script src="<?php echo URL; ?>assets/js/sweetalert.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/dropzone.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/moment.min.js"></script>
    <script src="<?php echo URL; ?>assets/js/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/daterangepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/chosen.jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/chosen.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL;?>assets/css/dropzone.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL;?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/bootstrap-datetimepicker.min.css" />
    <style type="text/css">.sidebar-background{ background-size: auto !important; }</style>
</head>
<?php
$usersR=$this->model->getUsersRecycle('operator');
$usersR=array_merge($usersR,$this->model->getUsersRecycle('result'));
?>
<style>
	.rotate {
	  animation: rotation 8s infinite linear;
	}

	@keyframes rotation {
	  0 {
	    transform: rotateY(0);
	  }
	  50% {
	    transform: rotateY(180deg);
	  }
	  100% {
	    transform: rotateY(360deg);
	  }
	}
</style>
<style media="screen">
  #assign_to{
    width: 70% !important;
  }
  /* .recycleSubNavH{display:none;}
  .showRecycleSubNavH:hover ~ .recycleSubNavH,.recycleSubNavH:hover {
   display: block !important;
   -webkit-animation: slide-r 1s ease-out;
   -moz-animation: slide-r 1s ease-out;
 } */
</style>
<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" >
        <!-- <div class="sidebar" data-color="blue" data-image="<?php echo URL; ?>assets/img/sidebar-5.jpg"> -->
            <!--
            Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
            Tip 2: you can also add an image using data-image tag
            -->
            <div class="logo">
              <!--   <a href="<?=URL;?>" class="simple-text">
                    OPUS
                </a> -->
            <img  class="rotate" style="width: 238px" src="<?php echo URL; ?>assets/img/logo_any1.png">
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">

                  <li class="deleteNav h_buttons" style="display:none;cursor:pointer">
                    <a onclick="editBtnClick()" class="editbtn">
                       <i class="material-icons"  style="">edit</i>
                        <p class="edittxt" style="">Edit</p>
                    </a>

                      <a onclick="deleteBtnClick()" class="delbtn">
                         <i class="material-icons"  style="color:red">delete_forever</i>
                          <p class="dlttxt" style="color:red">Remove</p>
                      </a>
                  <!-- </li> -->
                  <!-- <center class="h_buttons" style="display:none"> -->
                    <!-- <input type="button" onclick="deleteBtnClick()" value="Delete" class="btn btn-danger delbtn"> -->
                  <!-- <li class="assigntoNav h_buttons" style="display:none"> -->
                    <a>
                    <!-- <div class="form-group" style="padding-bottom:0px !important;margin:0px !important;">
                      <i class="material-icons">how_to_reg</i>
                      <select style="" class="form-control" onchange="bulkAssignTo(this.value)" name="assign_to" id="assign_to">
                        <option  value=''>Assign To</option>
                          <option value='0'>None</option>
                          <?php
                              $output='';
                              if (!isset($operators)) {
                                $operators=[];
                              }
                              foreach ($operators as $operator) {
                                  $output.='<option value="'.$operator->user_id.'" >'.$operator->first_name.' '.$operator->last_name.'</option>';
                              }
                              echo $output;
                          ?>
                      </select>

                    </div> -->

                  </a>
                  </li>
                    <li class="leadsNav">
                        <a href="<?=URL.$_SESSION['role'].'/leads';?>">
                            <i class="material-icons">supervised_user_circle</i>
                            <p>Leads</p>
                        </a>
                    </li>
                    <li class="agendaNav">
                        <a href="<?=URL.$_SESSION['role'].'/agenda';?>">
                            <i class="material-icons">event</i>
                            <p>Agenda</p>
                        </a>
                    </li>
                    <li class="reminderNav">
                        <a href="<?=URL.$_SESSION['role'].'/reminders';?>">
                            <i class="material-icons">calendar_view_day</i>
                            <p>Reminders</p>
                        </a>
                    </li>

                    <li class="statusNav">
                        <a href="<?=URL.$_SESSION['role'].'/statuses';?>">
                            <i class="material-icons">category</i>
                            <p>Status</p>
                        </a>
                    </li>

                    <li class="calllogNav">
                        <a href="<?=URL.$_SESSION['role'].'/call_log';?>">
                            <i class="material-icons">call</i>
                            <p>Call Log</p>
                        </a>
                    </li>

                    <li class="mailNav">
                        <a href="">
                            <i class="material-icons">mail</i>
                            <p>Mail</p>
                        </a>
                    </li>
                    <li class="smsNav">
                        <a href="">
                            <i class="material-icons">sms</i>
                            <p>SMS</p>
                        </a>
                    </li>
                    <li class="pushwebNav">
                        <a href="">
                            <i class="material-icons">web</i>
                            <p>Push Web</p>
                        </a>
                    </li>
                    <li class="manualcallNav">
                        <a style="cursor:pointer;" onclick="$('#manual_call').modal();">
                            <i class="material-icons">call</i>
                            <p>Manual Call</p>
                        </a>
                    </li>
                    <!-- <ul class="nav testtt">
                      <li class="recycleNav showRecycleSubNavH">
                          <a href="<?=URL.$_SESSION['role'].'/recycle';?>">
                              <i class="material-icons">cached</i>
                              <p>Recycle</p>
                          </a>

                              <?php
                                foreach ($usersR as $ur) {
                                  echo '<li class="recycleSubNavH ur'.$ur->user_id.'Nav" style="display: none">';
                                  echo '<a href="'.URL.$_SESSION['role'].'/recycle?assigned_to%5B%5D='.$ur->user_id.'">';
                                  echo '<i class="material-icons">arrow_right</i>';
                                  echo '<p>'.$ur->first_name.' '.$ur->last_name.'</p></a></li>';
                                }
                               ?>

                      </li>
                    </ul> -->
                    <script type="text/javascript">
                    $('.showRecycleSubNavH').mouseover(function(){
                          $('.recycleSubNavH').show('slow');
                      });

                    $('.testtt').mouseleave(function(){
                        $('.recycleSubNavH').not('#nohidenav').hide('slow');
                    });
                    </script>
                    <!-- <div class="card-content table-responsive h_buttons" style="display:none"> -->

                      <!-- </center> -->
                    <!-- </div> -->
                    <!-- <li class="campaignNav">
                        <a href="<?=URL.$_SESSION['role'].'/campaigns';?>">
                            <i class="material-icons">event_note</i>
                            <p>Campagna</p>
                        </a>
                    </li>
                    <li class="statusNav">
                        <a href="<?=URL.$_SESSION['role'].'/statuses';?>">
                            <i class="material-icons">category</i>
                            <p>Stato Pratica</p>
                        </a>
                    </li> -->

<!--                     <li class="active-pro">
                        <a href="mailto:adalenvladi@gmail.com">
                            <i class="material-icons">unarchive</i>
                            <p>Support</p>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="card-icon fbtn" style="float:right;cursor:pointer;">
                        <i class="material-icons">menu</i>
                      </div>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown userName">
                                 <?=$_SESSION['full_name'];?>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" style="cursor: pointer;" data-toggle="dropdown">
                                    <!-- <i class="material-icons">person</i> -->
                                    <?php $userImage=$this->model->getUserImage($_SESSION['user_id']); ?>
                                    <?php if ($userImage->image==null){ ?>
                                      <img src="<?php echo URL; ?>assets/img/145.png" alt="User" class="userImg">
                                    <?php } else { ?>
                                        <img src="data:image/png;base64,<?php echo base64_encode($userImage->image);?>" alt="User" class="userImg">
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu">
                                  <li>
                                      <a href="<?=URL.'support/profile';?>" style="background-color: #000000;color:white" class="btn-info">My Profile</a>
                                  </li>
                                    <li>
                                        <a href="<?=URL.'home/logout';?>" style="background-color: #000000;color:white" class="btn-info">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
