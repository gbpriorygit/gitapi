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
    <!--<script src="<?php echo URL; ?>assets/js/fullcalendar.min.js"></script>-->
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/daterangepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>assets/js/chosen.jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL;?>assets/css/dropzone.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL;?>assets/css/fullcalendar.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/chosen.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>assets/css/bootstrap-datetimepicker.min.css" />
    <style type="text/css">.sidebar-background{ background-size: auto !important; }</style>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js"></script>
    <script src="<?php echo URL; ?>assets/js/fullcalendar.js"></script>
    <script src="<?php echo URL; ?>assets/js/fullCalendarScript.js"></script>
</head>
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
	
	
    .modal-backdrop.fade.in {
        display: none;
    }
    
    #divCallOptions{
        display:none;
    }
    
	#txtRegStatus i{
	    font-size:20px;
	    width: 260px !important;
	}
	#txtCallStatus i{
	    font-size:20px;
	    width: 260px !important;
	}
	.softphone{
	    background:none;
	}
	
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
            <img class="rotate" style="width: 238px" src="<?php echo URL; ?>assets/img/logo_any1.png">
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li onclick="resetNewLeads()"  class="leadsNav">
                        <a href="<?=URL.$_SESSION['role'].'/leads';?>">
                            <i class="material-icons">supervised_user_circle</i>
                            <p>Leads</p>
                        </a>
                    </li>

                    <li class="calendarNav">
                        <a href="<?=URL.$_SESSION['role'].'/calendar';?>">
                            <i class="material-icons">calendar_today</i>
                            <p>Calendar</p>
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
                    <hr class="hrDivider">
                    <li class="mailNav">
                        <a href="<?=URL.$_SESSION['role'].'/emails';?>">
                            <i class="material-icons">mail</i>
                            <p>Email</p>
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
                    <hr class="hrDivider">
                    <li class="activityNav">
                        <a href="<?=URL.$_SESSION['role'].'/activity';?>">
                            <i class="material-icons">timeline</i>
                            <p>Activity</p>
                        </a>
                    </li>
                    <li class="calllogNav">
                        <a href="<?=URL.$_SESSION['role'].'/call_log';?>">
                            <i class="material-icons">call</i>
                            <p>Call Log</p>
                        </a>
                    </li>
                    <li class="uploadNav">
                        <a href="<?=URL.$_SESSION['role'].'/upload';?>">
                            <i class="material-icons">backup</i>
                            <p>Upload</p>
                        </a>
                    </li>
                    
                
                    <!--<li class="manualcallNav">-->
                    <!--    <a style="cursor:pointer;" onclick="$('#manual_call').modal();">-->
                    <!--        <i class="material-icons">call</i>-->
                    <!--        <p>Manual Call</p>-->
                    <!--    </a>-->
                    <!--</li>-->
                    
                    
                    <li class="" style="display: flex; justify-content: center;  margin-top: 70px;">
                        <div id="divBtnCallGroup" class="btn-group" style="padding-left: 6px;padding-right: 7px;">
                            <button id="btnCall" disabled  style="background-image: none" class="btn btn-info menu-call-icon call-btn" data-toggle="dropdown"><i class="material-icons call-icon">call</i><span class="call-text">Call</span></button>
                        </div>

                        <div class="btn-group" style="padding-left: 7px;padding-right: 6px;">
<!--                            <input type="button" id="btnHangUp"  style="background-image: none" class="btn btn-danger menu-call-icon hangup-btn" value="HangUp" onclick='sipHangUp();' disabled />-->
                            <button id="btnHangUp"  onclick='sipHangUp();' disabled  style="background-image: none" class="btn btn-info menu-call-icon hangup-btn" data-toggle="dropdown"><span class="hangup-text">HangUp</span>

                                <svg style="position: absolute; left: 0; font-size:5px !important; top:0px" class="MuiSvgIcon-root jss254 hangup-icon" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation" tabindex="-1" title="CallEnd"><path d="M12 9c-1.6 0-3.15.25-4.6.72v3.1c0 .39-.23.74-.56.9-.98.49-1.87 1.12-2.66 1.85-.18.18-.43.28-.7.28-.28 0-.53-.11-.71-.29L.29 13.08c-.18-.17-.29-.42-.29-.7 0-.28.11-.53.29-.71C3.34 8.78 7.46 7 12 7s8.66 1.78 11.71 4.67c.18.18.29.43.29.71 0 .28-.11.53-.29.71l-2.48 2.48c-.18.18-.43.29-.71.29-.27 0-.52-.11-.7-.28-.79-.74-1.69-1.36-2.67-1.85-.33-.16-.56-.5-.56-.9v-3.1C15.15 9.25 13.6 9 12 9z"></path></svg>

                            </button>
                        </div>
                    </li>
                    <li style="max-height: 70px;width:265px;">

                        <div id='divCallOptions' class='call-options btn-group call-options btn-group' style="justify-content: center !important; ">
<!--                            <input type="button" class="btn menu-call-icon manual-btn" style="margin-left: 5px; margin-right:5px;;padding-left: 15px; padding-right: 15px;background-image: none" id="btnMute" />-->
                            <button id="btnMute"  value="Mute" onclick='sipToggleMute();' style="background-image: none" class="btn menu-call-icon mute-btn" data-toggle="dropdown">
                                <i style="font-size: 20px !important;" class="fa fa-volume-mute mute-icon"></i><span class="mute-text">Mute</span>

                            </button>

                            <button id="btnHoldResume"  value="Hold"  onclick='sipToggleHoldResume();' style="background-image: none" class="btn menu-call-icon pause-btn" data-toggle="dropdown">
                                <i style="font-size: 20px !important;" class="fa fa-pause pause-icon"></i><span class="pause-text">Pause</span>

                            </button>
                            <button  id="btnTransfer" value="Transfer" onclick='sipTransfer();' style="background-image: none" class="btn menu-call-icon transfer-btn" data-toggle="dropdown">
                                <i style="font-size: 20px !important;" class="fa fa-exchange-alt transfer-icon"></i><span class="transfer-text">Transfer</span>

                            </button>
<!--                                <input type="button" class="btn menu-call-icon manual-btn" style="margin-left: 5px;; margin-right:5px;;padding-left: 15px;; padding-right: 15px;background-image: none" id="btnHoldResume" value="Hold" onclick='sipToggleHoldResume();' /> &nbsp;-->
<!--                            <input type="button" class="btn menu-call-icon manual-btn" style="margin-left: 5px;; margin-right:5px;;padding-left: 15px;; padding-right: 15px;background-image: none" onclick='sipTransfer();' /> &nbsp;-->
                            <!-- <input type="button" class="btn" style="" id="btnKeyPad" value="KeyPad" onclick='openKeyPad();' /> -->
                            <!-- </div> -->
                        </div>

                    </li>
                    <li  style="width:265px">
                        <div class="btn-group" style=" display: flex; justify-content: center">
                            <a  style="cursor:pointer;" onclick="$('#manual_call').modal();"
                            style="background-image: none" 
                            class="btn btn-info menu-call-icon manual-btn" data-toggle="dropdown">Manual Call</a>

                        </a>
                        
                        </div>
                    </li>
                    
                    
                    <li style="max-height: 50px;width:265px; display:flex; font-size:10px; margin-bottom:10px">
                        <label  id="txtCallStatus"></label>

                    </li>
                    <li style="max-height: 30px;width:265px; display:box; font-size:10px; margin-top:10px">

                        <label style="" id="txtRegStatus"></label>
                        <object id="fakePluginInstance" classid="clsid:69E4A9D1-824C-40DA-9680-C7424A27B6A0" style="visibility:hidden;"> </object>
                    </li>

                </ul>
            </div>
        </div>
        <div id="quickView" class="modal fade right " role="dialog" >
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content quickViewContent modal-dialog-scrollable" style="overflow-x:hidden;background: black!important;" >
                    <div class="col-sm-12" style="background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.2)), url('<?php echo URL; ?>assets/img/bp_eyes.jpg'); background-position: center;height:150px;">
                        <img style="border: 3px outset #a99672;padding: 0;border-radius: 95%;width: 100px;height: auto;position: absolute;top: 61%;left: 50%;transform: translateX(-50%);" src="<?php echo URL; ?>assets/img/leadImg.png" alt="">
                    </div>
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="row" style="padding: 0 2rem;">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12">
                                            <h5 href="" class="control-label quickFontBig"   id="quickName"> </h5>

                                        </div>
                                    </div>
                                </div>

                                <div class="row card" style="background: linear-gradient(to bottom, #171616, #434343);border: 1px outset;padding:10px;">

                                    <div class="col-sm-12" style="align-items: center;display: flex;">
                                        <div class="col-sm-2"> <i style="font-size: 25px;" class="fas fa-phone-alt"></i></div>
                                        <div class="col-sm-10"><h5 style="margin-bottom:0;" class="control-label quickFont">PHONE</h5>
                                            <h4 style="margin-top: 5px;" class="control-label quickFont"  id="quickPhone">-</h4></div>
                                    </div>
                                    <br>
                                    <div class="col-sm-12" style="align-items: center;display: flex;">
                                        <div class="col-sm-2"> <i style="font-size: 25px;" class="fas fa-mobile-alt"></i></div>
                                        <div class="col-sm-10"><h5 style="margin-bottom:0;" class="control-label quickFont">ALT PHONE</h5>
                                            <h4 style="margin-top: 5px;" class="control-label quickFont" id="quickAltPhone" >-</h4></div>
                                    </div>
                                    <br>
                                    <div class="col-sm-12" style="align-items: center;display: flex;">
                                        <div class="col-sm-2"> <i style="font-size: 25px;" class="far fa-envelope"></i></div>
                                        <div class="col-sm-10"><h5 style="margin-bottom:0;" class="control-label quickFont">EMAIL</h5>
                                            <h4 style="margin-top: 5px;" class="control-label quickFont"  id="quickEmail"></h4></div>
                                    </div>

                                </div>

                                <!--                            <div class="row m-0">-->
                                <!--                                <a id="quickViewUrl"  target="_blank" style="background-color: #cbac60 !important;background-image:none;" class="btn btn-sm btn-gold">View Details</a>-->
                                <!--                            </div>-->

                                <div class="row card" style="background: linear-gradient(to bottom, #171616, #434343);border: 1px outset;padding: 27px;">
                                    <div class="row m-0" >
                                        <div class="col-md-4">
                                            <label class="control-label quickFont"><b>Status Lead :</b></label>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="control-label quickFont" id="quickStatus"></label>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="col-md-4">
                                            <label class="control-label quickFont"><b>Assigned To :</b></label>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="control-label quickFont" id="quickAssigned">Assigned To</label>
                                        </div>
                                    </div>
                                    <div class="row m-0">
                                        <div class="col-md-4">
                                            <label class="control-label quickFont"><b>Note :</b></label>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="control-label quickFont" id="quickNote"></label>
                                        </div>
                                    </div>

                                    <div class="row m-0">
                                        <div class="col-md-4">
                                            <label class="control-label quickFont"><b>Source :</b></label>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="control-label quickFont" id="quickSource"></label>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <!--                            </form>-->
                        </div>
                        <div class="col-md-12 leadElements ">
                            <div class="card" style="background: linear-gradient(to bottom, #171616, #434343);border: 1px outset;padding: 27px;">
                                <div class="">
                                    <h4 class="title">Comments</h4>

                                    <div id="commentsDiv">

                                    </div>
                                    <div style="text-align: center; margin:0">
                                        <a href=""  target="_blank" id="commentsMore" class="btn btn-sm btn-gold">View More</a>

                                    </div>
                                    <!-- <p class="category">Creating new user</p> -->
                                </div>
                                <div class="card-content">

                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="row example-basic" >
                            <div class="col-xs-10 col-sm-12 activitySingle" style="margin-top:30px;" id="activityDiv">

                            </div>
                            <div style="text-align: center; margin:0">
                                <a href="" id="activitiesMore" target="_blank" class="btn btn-sm btn-gold">View More</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent">
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
                                      <a href="<?=URL.'operator/profile';?>" style="background-color: #000000;color:white" class="btn-info">My Profile</a>
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
