<title><?php echo $lead->first_name." ".$lead->last_name;  ?></title>
<style>

    body{}

    .email_input{display: flex; align-items: center; margin-bottom:15px; color:black;}

    .card-body {
        background: #1f2933;
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.35rem;
        border-radius: 10px;
    }

    .form-control-custom {
        background-color: #f1f1f138;
    }

    .form-control, .form-group .form-control {
        font-size: 14px!important;
        border: 1px solid rgba(170, 170, 170, 0.3);
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        background-repeat: repeat;
    }

    .card-header:first-child {
        background-color: rgb(31, 41, 51);
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-header{padding: .75rem 1.25rem;margin:0!important;}

    .pb-3{padding-bottom: 1.5rem!important;}

    .timeline-2 {
        position: relative;
        border-left: 2px solid #59ceb5;
    }

    .time-item {
        position: relative;
        padding-bottom: 1px;
        border-color: #eff3f6;
    }

    .item-info {
        margin-left: 15px;
        margin-bottom: 15px;
    }

    .text-muted {
        color: #707070 !important;
    }

    .time-item:before, .time-item-item:after {
        display: table;
        content: " ";
    }

    .time-item:after {
        position: absolute;
        bottom: 0;
        left: 0;
        top: 5px;
        width: 14px;
        height: 14px;
        margin-left: -8px;
        background-color: #59ceb5;
        border-color: #59ceb5;
        border-style: solid;
        border-width: 2px;
        border-radius: 10px;
        content: '';
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }

    .p-l-30{padding-left:1rem;}


    .font-small{font-size: 15px;}

    .mr-2, .mx-2 {
        margin-right: .8rem!important;
    }
    .font-custom {
        color: #cdad6b;
        font-size: 15px;
        font-weight: 800;
    }

    .form-group {
        padding-bottom: 10px;
        margin: 18px 0 0 0;
    }


    .timeline-2 .form-group{display: none;}


    .text_primary_custom{color: #cdad6b;}



</style>
<meta charset="utf-8">
<script src="<?php echo URL; ?>assets/ep/js/config.js"></script>
<script src="<?php echo URL; ?>assets/ep/js/util.js"></script>
<script src="<?php echo URL; ?>assets/ep/js/jquery.emojiarea.js"></script>
<script src="<?php echo URL; ?>assets/ep/js/emoji-picker.js"></script>
<link href="<?php echo URL; ?>assets/ep/css/emoji.css" rel="stylesheet">


<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="text-center pb-3">
                            <img  style="width:115px;" alt="" class="rounded-circle  mx-auto d-block" src="<?php echo URL; ?>assets/img/any1coin_logo.png">
                        </div>
                        <div class="text-center pb-3">
                            <h5 class="mt-2 mb-0"><?=$lead->first_name;?> <?=$lead->last_name;?></h5>
                            <p class="text-muted mb-2 pb-3"><?=$lead->note;?></p>
                            <div class="col-md-6 pb-3"><button onclick="sipCall('call-audio','<?=$_SESSION['user_sip'].$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="btn btn-block mb-2">Call</button> </div>
                            <div class="col-md-6 pb-3"><button onclick="$('.to_name').val($('.fn').val()+' '+$('.ln').val());$('.to').val($('.em').val());$('#send_email_modal').modal();" class="btn btn-block mb-2">Email</button> </div>
                        </div>

                        <div class="row text-center pb-3">
                            <div class="col-lg-4 mt-3 align-self-center p-0">
                                <p class="font-custom mb-0">Status</p>
                                <p class="mb-0"><?=$this->model->getStatus($lead->status)->status_name;?></p>
                            </div>
                            <div class="col-lg-4 mt-3 align-self-center p-0">
                                <p class="font-custom mb-0">Source</p>
                                <p class="mb-0"><?=$lead->source;?></p>
                            </div>
                            <div class="col-lg-4 mt-3 align-self-center p-0">
                                <p class="font-custom mb-0">Assigned To</p>
                                <p class="mb-0"><?=$this->model->getUser($lead->assigned_to)->first_name;?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card m-b-30 contact">
                            <div class="card-body">
                                <h6 class="header-title pb-3">Contact</h6>
                                <ul class="list-unstyled p-l-30">
                                    <li class="pb-3"><i class="fas fa-phone mr-2"></i> <b>Phone: </b> <span class="font-small"><?=$lead->phone_number;?></span> </li>
                                    <li class="mt-2 pb-3"><i class="far fa-envelope mt-2 mr-2"></i> <b> Alt Phone: </b> <span class="font-small"><?=$lead->alt_number;?></span> </li>
                                    <li class="mt-2 pb-3"><i class="far fa-envelope mt-2 mr-2"></i> <b> Email: </b> <span class="font-small"><?=$lead->email;?></span>  </li>
                                    <li class="mt-2 pb-3"><i class="fas fa-map-marker-alt mt-2 mr-2"></i> <b>Location:</b>  <span class="font-small">Italy</span> <img  style="width:30px;" alt="" class="rounded-circle  mx-auto d-block" src="<?php echo URL; ?>assets/img/it_flag.png"> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <a href="#" class="float-right"></a>
                                <h6 class="header-title pb-3">Quick Edit:</h6>
                                <div class="row m-b-30">
                                    <div class="col-sm-12 m-b-30 pb-3">
                                        <label class="font-custom">Status: </label>
                                        <?php
                                        $output='';
                                        $st='';
                                        foreach ($statuses as $key => $status) {
                                            $st.='<option value="'.$status->status_id.'">'.$status->status_name.'</option>';
                                        }
                                        $output.='<td><select class=" form-control '.$lead->lead_id.'" onchange="editStatus('.$lead->lead_id.',Number(this.value))" id="status_select"><option class="oldstatus'.$lead->lead_id.'" value="'.$lead->status.'">'.$lead->status_name.'</option>'.$st.'</select></td>';
                                        echo $output;
                                        ?>
                                    </div>
                                    <div class="col-sm-12 pb-3"">
                                    <label class="font-custom">Source</label>
                                    <input type="text" disabled placeholder="<?=$lead->source;?>" class="form-control form-control-custom" value="<?=$lead->source;?>">
                                </div>


                                <div class="col-sm-12 pb-3"">
                                <label class="font-custom">Assigned to:</label>
                                <input type="text" disabled placeholder="<?=$this->model->getUser($lead->assigned_to)->first_name;?>" class="form-control form-control-custom" value="<?=$this->model->getUser($lead->assigned_to)->first_name;?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="col-lg-9 col-xl-9">
        <div class="card m-b-30">
            <div class="card-header profile-tabs pb-0">

                <ul class="nav nav-tabs mb-20" role="tablist">
                    <li role="presentation" class="leadTabs active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-info-circle viewLeadIcon"></i> Details</a></li>
                    <li role="presentation" class="leadTabs"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-file-alt viewLeadIcon"></i> Summary  </a></li>
                    <li role="presentation" class="leadTabs"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab"><i class="fa fa-comments viewLeadIcon"></i> Comments </a></li>
                    <li role="presentation" class="leadTabs"><a href="#activity" aria-controls="activity" role="tab" data-toggle="tab"><i class="fa fa-plane viewLeadIcon"></i> Activity</a></li>
                    <li role="presentation" class="leadTabs"><a href="#description" aria-controls="description" role="tab" data-toggle="tab"><i class="fa fa-newspaper viewLeadIcon"></i> Description</a></li>
                    <?php if($lead->source==='Academy')
                        echo '<li role="presentation" class="leadTabs"><a href="#academia" aria-controls="academia" role="tab" data-toggle="tab"><i class="fa fa-graduation-cap viewLeadIcon"></i>  Academy</a></li>';
                    else if ($lead->source==='Appointment')
                        echo '<li role="presentation" class="leadTabs"><a href="#academia" aria-controls="academia" role="tab" data-toggle="tab"><i class="fa fa-handshake viewLeadIcon"></i> Appointment </a></li>';
                    else if ($lead->source==='Promo'||$lead->source==='Ex Brands')
                        echo '<li role="presentation" class="leadTabs"><a href="#promo" aria-controls="promo" role="tab" data-toggle="tab"><i class="far fa-circle viewLeadIcon"></i> Promo </a></li>';

                    ?>
                </ul>
            </div>
            <div class="card-body" style="min-height: 350px;border-top-right-radius: 0; border-top-left-radius: 0;">
                <div class="">
                    <div class="tab-content">
                        <div class="tab-pane" id="profile">
                            <div class="row">
                                <div class="col-sm-12  pb-3">
                                    <label class="font-custom">Note: </label>
                                    <input type="text" onchange="editNoteFinal('<?=$lead->lead_id;?>',this.value)" class="form-control form-control-custom" value="<?=$lead->note;?>" name="note">
                                </div>

                                <div class="col-sm-12  pb-3">
                                    <label class="font-custom">Status: </label>
                                    <?php
                                    $output='';
                                    $st='';
                                    foreach ($statuses as $key => $status) {
                                        $st.='<option value="'.$status->status_id.'">'.$status->status_name.'</option>';
                                    }
                                    $output.='<td><select class=" form-control '.$lead->lead_id.'" onchange="editStatus('.$lead->lead_id.',Number(this.value))" id="status_select"><option class="oldstatus'.$lead->lead_id.'" value="'.$lead->status.'">'.$lead->status_name.'</option>'.$st.'</select></td>';
                                    echo $output;
                                    ?>
                                </div>

                                <div class="col-sm-12 pb-3"">
                                <label class="font-custom">Source</label>
                                <input type="text" disabled placeholder="<?=$lead->source;?>" class="form-control form-control-custom" value="<?=$lead->source;?>">
                            </div>


                            <div class="col-sm-12 pb-3"">
                            <label class="font-custom">Assigned to:</label>
                            <input type="text" disabled placeholder="<?=$this->model->getUser($lead->assigned_to)->first_name;?>" class="form-control form-control-custom" value="<?=$this->model->getUser($lead->assigned_to)->first_name;?>">
                        </div>


                    </div>
                </div>
                <div class="tab-pane active"  id="home">
                    <div class="row">
                        <div class="col-lg-12">


                            <div class="">
                                <form class="form-horizontal form-material">
                                    <div class="form-group row m-b-30">
                                        <div class="col-md-6">
                                            <label class="font-custom">First Name</label>
                                            <input type="text" disabled placeholder="<?=$lead->phone_number;?>" class="form-control form-control-custom" value="<?=$lead->first_name;?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="font-custom">Last Name</label>
                                            <input type="text" disabled placeholder="<?=$lead->last_name;?>" class="form-control form-control-custom" value="<?=$lead->last_name;?>">
                                        </div>
                                    </div>
                                    <?php if(!isset($_GET['modal'])){ ?>
                                        <div class="form-group row m-b-30">
                                            <div class="col-md-6">
                                                <label class="font-custom">Phone Number</label>
                                                <input type="text" disabled placeholder="<?=$lead->phone_number;?>" class="form-control form-control-custom" value="<?=$lead->phone_number;?>" id="example-email">
                                                <div  class="callIconsDiv">
                                                    <a class="callIcons wpIcon" target="blank" href="https://web.whatsapp.com/send?phone=<?=$lead->phone_number;?>&amp;text=&amp;source=&amp;data=">
                                                        <img class="socialImg" src="<?php echo URL; ?>assets/img/whatsapp.png" style="width:auto;height:27px" alt="WhatsApp"/>
                                                    </a>
                                                    <a class="callIcons wpIcon" href="viber://chat?number=<?=$lead->phone_number;?>">
                                                        <img class="socialImg" src="<?php echo URL; ?>assets/img/viber.png" style="width:auto;height:27px" alt="Viber"/>
                                                    </a>
                                                    <a class="callIcons wpIcon">
                                                        <img src="<?php echo URL; ?>assets/img/msg.png" data-toggle="tooltip" data-placement="top" class="msgImg" onclick="$('.pni').val($('.pn').val());$('#send_sms_modal').modal();"/>

                                                    </a>
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone0.png" data-toggle="tooltip" data-placement="top" class="callImg" alt="phone 1" title="Mobile"    onclick="sipCall('call-audio','<?='77'.$_SESSION['user_sip'].$lead->phone_number;?>','<?=$lead->lead_id;?>');"/>

                                                    </a>
                                                    &nbsp;                                                    &nbsp;
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone2.png" data-toggle="tooltip" data-placement="top" alt="phone 1"  title="Random IT" onclick="sipCall('call-audio','<?='99'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                    </a>
                                                    &nbsp;
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone3.png" data-toggle="tooltip" data-placement="top" alt="phone 1"  title="Random UK" onclick="sipCall('call-audio','<?='88'.$lead->phone_number;?>','<?=$lead->lead_id;?>');"  class="material-icons call_now_btn callImg"/>


                                                    </a>
                                                    &nbsp;
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone4.png" data-toggle="tooltip" data-placement="top" title="Mobile Random"  onclick="sipCall('call-audio','<?='66'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                    </a>
                                                    &nbsp;
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone5.png" data-toggle="tooltip" data-placement="top" alt="phone 1"   title="Random CEL ITA" onclick="sipCall('call-audio','<?='67'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                    </a>

                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone8.png" data-toggle="tooltip" data-placement="top" alt="phone 1"   title="Random CEL ITA 2" onclick="sipCall('call-audio','<?='69'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="font-custom">Alt Number</label>
                                                <input type="text" disabled placeholder="Alt Number" class="form-control form-control-custom" value="<?=$lead->alt_number;?>">
                                                <div class="callIconsDiv">

                                                    <a class="callIcons wpIcon" target="blank" href="https://web.whatsapp.com/send?phone=<?=$lead->alt_number;?>&amp;text=&amp;source=&amp;data=">
                                                        <img class="socialImg"   src="<?php echo URL; ?>assets/img/whatsapp.png" style="width:auto;height:27px" alt="WhatsApp"/>
                                                    </a>
                                                    <a class="callIcons wpIcon" href="viber://chat?number=<?=$lead->alt_number;?>">
                                                        <img class="socialImg" src="<?php echo URL; ?>assets/img/viber.png" style="width:auto;height:27px" alt="Viber"/>
                                                    </a>
                                                    <a class="callIcons wpIcon">
                                                        <img src="<?php echo URL; ?>assets/img/msg.png" class="msgImg" onclick="$('.pni').val($('.pn').val());$('#send_sms_modal').modal();"/>

                                                    </a>

                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone0.png"  data-toggle="tooltip" data-placement="top" class="callImg" alt="phone 1" title="Mobile"   onclick="sipCall('call-audio','<?='77'.$_SESSION['user_sip'].$lead->alt_number;?>','<?=$lead->lead_id;?>',$(this).data('title'));$(this).addClass('btn_call_clicked');"/>

                                                    </a>
                                                    &nbsp;
                                                    &nbsp;
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone2.png" data-toggle="tooltip" data-placement="top" alt="phone 1"  title="Random IT" onclick="sipCall('call-audio','<?='99'.$lead->alt_number;?>','<?=$lead->lead_id;?>',$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn callImg"/>

                                                    </a>
                                                    &nbsp;
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone3.png" data-toggle="tooltip" data-placement="top" alt="phone 1"  title="Random UK"  onclick="sipCall('call-audio','<?='88'.$lead->alt_number;?>','<?=$lead->lead_id;?>',$(this).data('title'));$(this).addClass('btn_call_clicked');"  class="material-icons call_now_btn callImg"/>
                                                    </a>
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone4.png" data-toggle="tooltip" data-placement="top" title="Mobile Random"   onclick="sipCall('call-audio','<?='66'.$lead->alt_number;?>','<?=$lead->lead_id;?>',$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn callImg"/>
                                                    </a>
                                                    &nbsp;
                                                    <a class="callIcons">
                                                        <img  src="<?php echo URL; ?>assets/img/phone5.png" data-toggle="tooltip" data-placement="top" alt="phone 1"   title="Random CEL ITA"  onclick="sipCall('call-audio','<?='67'.$lead->alt_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row m-b-30">
                                            <div class="col-md-6">
                                                <label class="font-custom">Email</label>
                                                <input type="text" disabled placeholder="<?=$lead->email;?>" class="form-control form-control-custom" value="<?=$lead->email;?>">
                                                <div class="callIconsDiv">
                                                    <img src="<?php echo URL; ?>assets/img/gmail.png" style="width:auto;height:34px" alt="WhatsApp"  onclick="$('.to_name').val($('.fn').val()+' '+$('.ln').val());$('.to').val($('.em').val());$('#send_email_modal').modal();"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="font-custom">Registered</label>
                                                <input type="text" disabled placeholder="Registered:" class="form-control form-control-custom" value="<?=date('d-m-Y   h:m:i',strtotime($lead->date_created))?>">
                                            </div>
                                        </div>

                                    <?php }?>
                                    <!-- <div class="form-group">
                                        <textarea rows="5" placeholder="Message" class="form-control"></textarea>
                                        <button class="btn btn-primary btn-sm text-light px-4 mt-2 float-right">Update Profile</button>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="comments">


                    <div class="card" >
                        <div class="card-header border-grey-1" data-background-color="blue">
                            <h4 class="title">Comments<button type="button" class="btn btn-white animationbtn1 pull-right" style="padding: 6px 12px;margin:0;color:white;" onclick="$('#add_note_modal').modal();" name="button">+ Comment</button></h4>
                            <!-- <p class="category">Creating new user</p> -->
                        </div>
                        <div class="card-content">
                            <?php if (count($notes)<1): ?>
                                <p class="category">No Comments</p>
                            <?php endif; ?>
                            <?php foreach ($notes as $note): ?>
                                <div class="panel panel-info">
                                    <div class="panel-heading"><?=date("H:i d-m-Y", strtotime($note->date))?>
                                        <p class="category pull-right">
                                            <?php if ($note->user_id==$_SESSION['user_id']): ?>
                                                <!--<font class="editnote" onclick="editNote(<?=$note->note_id?>,'<?=$note->content?>')"><i class="material-icons">edit</i></font>-->
                                                <!--<font class="deletenote" onclick="deleteNote(<?=$note->note_id?>)"><i class="material-icons">delete</i></font>-->
                                            <?php endif; ?>
                                            <?=$note->first_name." ".$note->last_name ?>
                                        </p>
                                    </div>
                                    <div class="panel-body">
                                        <?=$note->content?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                </div>

                <div role="tabpanel" class="tab-pane" id="activity">


                    <div class="row ">
                        <div class="col-md-6" id="tasks_">
                            <div class="card">
                                <div class="card-header border-grey-1" data-background-color="blue">
                                    <h4 class="title">Calendar
                                        <button type="button" class="btn btn-white animationbtn1 pull-right" style="padding: 6px 12px;;margin:0; color:white;" onclick="$('#add_task_modal').modal();" name="button">+ Task</button>
                                    </h4>

                                    <!-- <p class="category">Creating new user</p> -->
                                </div>
                                <div class="card-content">
                                    <?php if (count($tasks)<1): ?>
                                        <p class="category">No pending activities</p>
                                    <?php endif; ?>
                                    <?php foreach ($tasks as $task): ?>
                                        <div class="panel panel-info <?php echo 'modal_'.$task->task_id;?>">
                                            <div class="panel-heading"><?=date("H:i d-m-Y", strtotime($task->start))?>
                                                <p class="category pull-right">
                                                    <font class="edittask" onclick="editTask(<?=$task->task_id?>,'<?=$task->content?>','<?=date("d-m-Y H:i:s", strtotime($task->start))?>')"><i class="material-icons">edit</i></font>
                                                    <font class="deletetask" onclick="deleteTask(<?=$task->task_id;?>)"><i class="material-icons">delete</i></font>
                                                    <?=$task->first_name." ".$task->last_name ?>
                                                </p>
                                            </div>
                                            <div class="panel-body">
                                                <?=$task->content?>
                                                <p  class="category pull-right" id="task_<?=$task->task_id?>"><?=$task->status ?>
                                                    <?php if ($task->status=="Pending"): ?>
                                                        <a onclick="setTaskStatus(<?=$task->task_id?>)" style="padding: 6px 12px;margin-left: 10px !important;margin:0"  class="btn btn-white">✔</a>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>




                        <div class="col-md-6 scrollablec" id="events_">
                            <div class="card">
                                <div class="card-header border-grey-1" data-background-color="blue">
                                    <h4 class="title">Agenda
                                        <button type="button" class="btn btn-white animationbtn1 pull-right" style="padding: 6px 12px;;margin:0;color:white;" onclick="$('#add_event_modal').modal();" name="button">+ Event</button>
                                    </h4>

                                    <!-- <p class="category">Creating new user</p> -->
                                </div>
                                <div class="card-content ">
                                    <?php if (count($events)<1): ?>
                                        <p class="category">No pending events</p>
                                    <?php endif; ?>
                                    <?php foreach ($events as $event): ?>
                                        <div class="panel panel-info <?php echo 'modal_'.$event->event_id;?>">
                                            <div class="panel-heading"><?=date("H:i d-m-Y", strtotime($event->start))?>
                                                <p class="category pull-right">
                                                    <font class="editevent" onclick="editEvent(<?=$event->event_id?>,'<?=$event->content?>','<?=date("d-m-Y H:i:s", strtotime($event->start))?>')"><i class="material-icons">edit</i></font>
                                                    <font class="deleteevent" onclick="deleteEvent(<?=$event->event_id;?>)"><i class="material-icons">delete</i></font>
                                                    <?=$event->first_name." ".$event->last_name ?>
                                                </p>
                                            </div>
                                            <div class="panel-body">
                                                <?=$event->content?>
                                                <p  class="category pull-right" id="event_<?=$event->event_id?>"><?=$event->status ?>
                                                    <?php if ($event->status=="Pending"): ?>
                                                        <a onclick="setEventStatus(<?=$event->event_id?>)" style="padding: 6px 12px;margin-left: 10px !important;margin:0"  class="btn btn-white">✔</a>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div>



                </div>

                <div role="tabpanel" class="tab-pane" id="description">


                    <div class="row  ">
                        <div class="col-md-12 scrollablec">
                            <div class="card" >
                                <div class="card-header border-grey-1" data-background-color="blue">
                                    <h4 class="title">Evolution Form<button type="button" class="btn btn-white animationbtn1 pull-right" style="padding: 6px 12px;margin:0;color:white;" onclick="$('#add_evolution_modal').modal();" name="button">+ Evolution</button></h4>
                                    <!-- <p class="category">Creating new user</p> -->
                                </div>
                                <div class="card-content">
                                    <?php if (count($evolutions)<1): ?>
                                        <p class="category">No data</p>
                                    <?php endif; ?>
                                    <?php foreach ($evolutions as $evolution): ?>
                                        <div class="panel panel-info">
                                            <div class="panel-heading"><?=date("H:i d-m-Y", strtotime($evolution->date))?>
                                                <p class="category pull-right">
                                                    <font class="editevolution" onclick="editEvolution(<?=$evolution->evolution_id?>,'<?=$evolution->content?>')"><i class="material-icons">edit</i></font>
                                                    <font class="deleteevolution" onclick="deleteEvolution(<?=$evolution->evolution_id?>)"><i class="material-icons">delete</i></font>
                                                    <?=$evolution->first_name." ".$evolution->last_name ?>
                                                </p>
                                            </div>
                                            <div class="panel-body">
                                                <?=$evolution->content?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div>



                </div>


                <div role="tabpanel" class="tab-pane" id="academia">

                    <div class="col-md-6 ">
                        <div class="col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">First Name</label>
                                <input  disabled type="text"    value="<?=$lead->first_name;?>" class="form-control fn ">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Last name</label>
                                <input type="text" disabled  value="<?=$lead->last_name;?>" class="form-control ln">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input type="text" disabled   value="<?=$lead->email;?>" class="form-control em">

                                <div class="callIconsDiv">
                                    <img src="<?php echo URL; ?>assets/img/gmail.png" style="width:auto;height:34px" alt="WhatsApp"  onclick="$('.to_name').val($('.fn').val()+' '+$('.ln').val());$('.to').val($('.em').val());$('#send_email_modal').modal();"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Phone Number</label>
                                <input type="text" disabled  value="<?=$lead->phone_number;?>" class="form-control pn">
                                <div  class="callIconsDiv" >
                                    <a class="callIcons">
                                        <img  src="<?php echo URL; ?>assets/img/phone0.png"  class="callImg" alt="phone 1" title="Mobile"    onclick="sipCall('call-audio','<?='60'.$lead->phone_number;?>','<?=$lead->lead_id;?>');"/>

                                    </a>
                                    <a class="callIcons">

                                        <img  src="<?php echo URL; ?>assets/img/phone1.png" alt="phone 1" title="Office"  onclick="sipCall('call-audio','<?='62'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                    </a>
                                    <a class="callIcons">
                                        <img  src="<?php echo URL; ?>assets/img/phone2.png" alt="phone 1"  title="Random IR" onclick="sipCall('call-audio','<?='61'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Data Sheets</label>
                                <textarea type="text" disabled name="data_sheets"  rows="3"  class="form-control"><?=$lead->data_sheets;?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-12 ">
                            <div class="card" >
                                <div class="card-header border-grey-1" data-background-color="blue">
                                    <h4 class="title">Comments<button type="button" class="btn btn-white animationbtn1 pull-right" style="padding: 6px 12px;margin:0;color:white" onclick="$('#add_note_academy_modal').modal();" name="button">+ Comment</button></h4>
                                    <!-- <p class="category">Creating new user</p> -->
                                </div>

                                <div class="card-content">
                                    <?php if (count($academy_comments)<1): ?>
                                        <p class="category">No Comments</p>
                                    <?php endif; ?>
                                    <?php foreach ($academy_comments as $note): ?>
                                        <div class="panel panel-info">
                                            <div class="panel-heading"><?=date("H:i d-m-Y", strtotime($note->date))?>
                                                <p class="category pull-right">
                                                    <?php if ($note->user_id==$_SESSION['user_id']): ?>
                                                        <!--<font class="editnote" onclick="editNote(<?=$note->note_id?>,'<?=$note->content?>')"><i class="material-icons">edit</i></font>-->
                                                        <!--<font class="deletenote" onclick="deleteNote(<?=$note->note_id?>)"><i class="material-icons">delete</i></font>-->
                                                    <?php endif; ?>
                                                    <?=$note->first_name." ".$note->last_name ?>
                                                </p>
                                            </div>
                                            <div class="panel-body">
                                                <?=$note->content?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 " id="reminders_">
                            <div class="card">
                                <div class="card-header border-grey-1" data-background-color="blue">
                                    <h4 class="title">Case
                                        <button type="button" class="btn btn-white pull-right" style="padding: 6px 12px;;margin:0" onclick="$('#add_reminder_modal').modal();" name="button">+ Reminder</button>
                                    </h4>

                                    <!-- <p class="category">Creating new user</p> -->
                                </div>
                                <div class="card-content ">
                                    <?php if (count($reminders)<1): ?>
                                        <p class="category">No pending reminders</p>
                                    <?php endif; ?>
                                    <?php foreach ($reminders as $reminder): ?>
                                        <div class="panel panel-info <?php echo 'modal_'.$reminder->reminder_id;?>">
                                            <div class="panel-heading"><?=date("H:i d-m-Y", strtotime($reminder->start))?>
                                                <p class="category pull-right">
                                                    <font class="editreminder" onclick="editTask(<?=$reminder->reminder_id?>,'<?=$reminder->content?>','<?=date("d-m-Y H:i:s", strtotime($reminder->start))?>')"><i class="material-icons">edit</i></font>
                                                    <font class="deletereminder" onclick="deleteTask(<?=$reminder->reminder_id;?>)"><i class="material-icons">delete</i></font>
                                                    <?=$reminder->first_name." ".$reminder->last_name ?>
                                                </p>
                                            </div>
                                            <div class="panel-body caseText">
                                                <?=$reminder->content?>
                                                <p  class="category pull-right" id="reminder_<?=$reminder->reminder_id?>"><?=$reminder->status ?>
                                                    <?php if ($reminder->status=="Pending"): ?>
                                                        <a onclick="setTaskStatus(<?=$reminder->reminder_id?>)" style="padding: 6px 12px;margin-left: 10px !important;margin:0"  class="btn btn-white">✔</a>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>

                <div role="tabpanel" class="tab-pane" id="promo">

                    <div class="col-md-12 ">

                        <div class="col-sm-12 pb-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Vicidial Description</label>
                                <input   type="text" rows="4" disabled value="<?=$lead->data_sheets;?>" class="form-control"></input>
                            </div>
                        </div>


                        <div class="col-sm-12 pb-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Description Apertura</label>
                                <input onchange="editWebform('<?=$lead->lead_id;?>',this.value)"  type="text" rows="4" value="<?=$lead->webform;?>" class="form-control"></input>
                            </div>
                        </div>

                        <div class="row m-0">
                            <div class="col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Retention Name</label>
                                    <input disabled type="text" " value="<?=$lead->retention_name;?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group label-floating">
                                    <label class="control-label">Description Retention</label>
                                    <input disabled type="text" rows="4" value="<?=$lead->retention_description;?>" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="col-sm-6" style="padding:0; margin:0">
                                <label class="font_custom">Assign to retention</label>
                                <select onchange="setAssigned()" style="margin:0" class="form-control" name="assigned_retention" id="assigned_retention">
                                    <option selected value="0">None</option>
                                    <option value="79">Christopher Nodier</option>
                                    <option value="77">Jacob Levi</option>
                                    <option value="78">Vitaly Kasyan</option>
                                </select>
                            </div>
                        </div>

                        <?php if (isset($tasks[0])) $task_date=$tasks[0]->start;
                        else $task_date='';?>

                        <div class="col-sm-6">
                            <a id="transfer_number" href="http://any1coin.net/dashboard/api/transfer/?lead_id=<?php echo $lead->lead_id.'&first_name='.$lead->first_name.'&last_name='.$lead->last_name.'&phone_number='.$lead->phone_number.'&email='.$lead->email.'&source='.$lead->source.'&assigned_apertura='.$lead->assigned_to.'&status='.$lead->status.'&data_sheets='.$lead->webform.'&task_date='.$task_date.'&assigned_retention='?>" class="btn btn-info pull-left"> <i class="fa fa-share"> </i> Send lead</a>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title pb-3">Activities</h5>

                    <div class="timeline-2">


                        <?php
                        foreach ($changelog as $log) {
                            $useri= $this->model->getUser($log['user_id']);
                            $useri=$useri->first_name." ".$useri->last_name;
                            $output.='<div class="time-item"><div class="item-info">';
                            $output.='<div class="text-muted">'.$log['date'].'</div><p class="text_primary_custom">'.$useri.'</p>';
                            $output.='<p>';
                            $diff=explode("|",$log['diff']);
                            foreach ($diff as $d) {
                                $output.=$d;
                            }
                            $output.='</p></div></div>';
                        }
                        echo $output;
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




<div id="add_note_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:370px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-12">
                        <img  style="width:115px;position: absolute;top: -30%;left:50%; transform: translateX(-50%)" alt="" class="rounded-circle  mx-auto d-block" src="<?php echo URL; ?>assets/img/comment_icon.png">

                        <br>
                        <select class="form-control" onchange="showCSTemplates(this);">
                            <option selected="selected" value="" id="Templates">Comment</option>
                            <option value="">Low</option>
                            <option value="">Mid</option>
                            <option value="">High</option>
                            <option value="">Not Interested</option>
                            <option value="">No Answer</option>
                            <option value="">Wrong Number</option>
                            <option value="">Busy</option>
                            <option value="">Secretary</option>
                            <option value="">FTD</option>
                        </select>

                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <textarea type="text" id="CSTemplates" required name="content" rows="6" cols="10" wrap="soft" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" value="<?=$lead->lead_id;?>" name="lead_id"></input>
                    <input type="hidden" value="1" name="add_note"></input>

                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="add_note_academia_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:300px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <textarea type="text" data-emoji-input="unicode" data-emojiable="true" required name="content" rows="14" cols="10" wrap="soft" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" value="<?=$lead->lead_id;?>" name="lead_id"></input>
                    <input type="hidden" value="1" name="add_note"></input>

                    <a class="btn btn-submit pull-right" name="submit">Submit</a>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="add_reminder_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:200px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input type="text" name="content" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" value="<?=$lead->first_name." ".$lead->last_name;?>" name="title"></input>
                    <input type="hidden" value="<?=$lead->lead_id;?>" name="lead_id"></input>
                    <input type="hidden" value="1" name="add_reminder"></input>
                    <?php $color= array('Betrader' => '#bdc3c7','Facebook'=>'#1c7ce0','Cpa'=>'#FCF6BA','Leverate'=>'#CB7F3C','Marketing'=>'#56488c','Promo'=>'#2c3e50','Sms'=>'#1e130c','Black Panther'=>'#434343'); ?>
                    <input type="hidden" value="<?=$color[$lead->source]?>" name="color"></input>
                    <div class="col-sm-4" style=" background-color: #EEEEEE; color: #3C4858;">
                        <div class="form-group ">
                            <label class="control-label">Time</label>
                            <input type="text" required autocomplete="off" id="datetime2" name="start" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="edit_reminder_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:200px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input type="text" name="content" class="form-control edit_reminder_comment">
                        </div>
                    </div>

                    <input type="hidden" value="1" name="edit_reminder"></input>
                    <input type="hidden" value="" class="edit_reminder_reminder_id" name="reminder_id"></input>
                    <div class="col-sm-4" style=" background-color: #EEEEEE; color: #3C4858;">
                        <div class="form-group " >
                            <label class="control-label">Time</label>
                            <input type="text" required autocomplete="off" id="datetime" name="start" class="form-control edit_reminder_start">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="add_task_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:200px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input type="text" name="content" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" value="<?=$lead->first_name." ".$lead->last_name;?>" name="title"></input>
                    <input type="hidden" value="<?=$lead->lead_id;?>" name="lead_id"></input>
                    <input type="hidden" value="1" name="add_task"></input>
                    <?php $color= array('Promo' => '#a6aeb3','Black Panther'=>'#000000','Betrader'=>'#36d1dc','Marketing'=>'#2b5876','Cpa'=>'#BF953F','Sms'=>'#1e130c','Facebook'=>'#0000ff','Leverate'=>'#3e5151'); ?>
                    <input type="hidden" value="<?=$color[$lead->source]?>" name="color"></input>
                    <div class="col-sm-4" style=" background-color: #EEEEEE; color: #3C4858;">
                        <div class="form-group " >
                            <label class="control-label">Time</label>
                            <input type="text" required autocomplete="off" id="datetime" name="start" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="edit_task_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:200px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input type="text" name="content" class="form-control edit_task_comment">
                        </div>
                    </div>

                    <input type="hidden" value="1" name="edit_task"></input>
                    <input type="hidden" value="" class="edit_task_task_id" name="task_id"></input>
                    <div class="col-sm-4" style=" background-color: #EEEEEE; color: #3C4858;">
                        <div class="form-group " >
                            <label class="control-label">Time</label>
                            <input type="text" required autocomplete="off" id="datetime" name="start" class="form-control edit_task_start">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="add_evolution_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:300px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <textarea type="text" data-emoji-input="unicode" data-emojiable="true" required name="content" rows="14" cols="10" wrap="soft" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" value="<?=$lead->lead_id;?>" name="lead_id"></input>
                    <input type="hidden" value="1" name="add_evolution"></input>

                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="send_sms_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:300px">
            <div class="modal-body">
                <form class="" action="<?=URL?>/api/sendSMS" method="post">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">SMS Text</label>
                            <textarea type="text" required data-emoji-input="unicode" maxlength="1600" data-emojiable="true" required name="sms_body" rows="14" cols="10" wrap="soft" class="form-control"></textarea>
                            <select class="form-control" name="out_number">

                                <option value="Any1Coin">Any1Coin</option>
                                <option value="+441412807366">+441412807366</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" value="" class="pni" name="pn"></input>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div  class="modal fade bd-example-modal-lg" id="send_email_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel" style="color:black;">New Email</h5>
            </div>
            <div class="modal-body">
                <form class="" action="<?=URL?>/api/sendEmail" method="post">
                    <div class="form-group">
                        <div class="email_input" >
                            <div class="col-md-2">
                                To:
                            </div>
                            <div class="col-md-10">
                                <input type="text" value="<?=$lead->email;?>" class="to form-control" name="to"></input>
                                <input type="hidden" value="<?=$lead->first_name;?>" class="to_name" name="to_name"></input>
                            </div>
                        </div>
                        <div class="email_input">
                            <div class="col-md-2">
                                Subject:
                            </div>
                            <div class="col-md-10">
                                <input type="text" required name="subject" value="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group"><label for="message-text" class="col-form-label">Message:</label>
                        <textarea type="text" id="editor1" style="color:black" name="body" rows="5" cols="10" wrap="soft" class="form-control"></textarea>
                    </div>
                    <input type="hidden" value="<?php echo $_SESSION['user_email'] ?>" class="from" name="from"></input>
                    <input type="hidden" value="<?php echo $_SESSION['full_name'] ?>" class="from_name" name="from_name"></input>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Send</button>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div id="add_event_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:200px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input type="text" name="content" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" value="<?=$lead->first_name." ".$lead->last_name;?>" name="title"></input>
                    <input type="hidden" value="<?=$lead->lead_id;?>" name="lead_id"></input>
                    <input type="hidden" value="1" name="add_event"></input>
                    <?php $color= array('Appointment' => 'green','Facebook'=>'#3b5998','AnyOnePower'=>'#D2B471','Google'=>'#CB7F3C'); ?>
                    <input type="hidden" value="<?=$color[$lead->source]?>" name="color"></input>
                    <div class="col-sm-4" style=" background-color: #EEEEEE; color: #3C4858;">
                        <div class="form-group ">
                            <label class="control-label">Time</label>
                            <input type="text" required autocomplete="off" id="datetime2" name="start" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="add_note_academy_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:300px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <textarea type="text" data-emoji-input="unicode" data-emojiable="true" required name="content" rows="14" cols="10" wrap="soft" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" value="<?=$lead->lead_id;?>" name="lead_id"></input>
                    <input type="hidden" value="1" name="add_academy_note"></input>

                    <button class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="edit_event_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:200px">
            <div class="modal-body">
                <form class="" action="" method="post">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <input type="text" name="content" class="form-control edit_event_comment">
                        </div>
                    </div>

                    <input type="hidden" value="1" name="edit_event"></input>
                    <input type="hidden" value="" class="edit_event_event_id" name="event_id"></input>
                    <div class="col-sm-4" style=" background-color: #EEEEEE; color: #3C4858;">
                        <div class="form-group " >
                            <label class="control-label">Time</label>
                            <input type="text" required autocomplete="off" id="datetime" name="start" class="form-control edit_event_start">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style media="screen">
    .scrollable {
        max-height: 400px;
        overflow-y: scroll;
    }
    .deletenote:hover{
        color: red;
        cursor: pointer;
    }
    .editnote:hover{
        color: orange;
        cursor: pointer;
    }
    .deletetask:hover{
        color: red;
        cursor: pointer;
    }
    .edittask:hover{
        color: orange;
        cursor: pointer;
    }
    .deleteevolution:hover{
        color: red;
        cursor: pointer;
    }
    .editevolution:hover{
        color: orange;
        cursor: pointer;
    }

    .emoji-wysiwyg-editor{
        height: 100px !important;
    }
    .ck-editor {
        color:black !important;
    }
    .call_now_btn{
        display: none;
    }
    .ck .ck-content{
        min-height:350px;}

</style>

<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('editor1');
</script>


<script type="text/javascript">




    function showCSTemplates(sel){
        locations =[
            /*Blank*/
            "",

            /*option Low*/
            "Il cliente è poco interessato!",

            /*option Mid*/
            "Il cliente potrebbe essere interessato!",

            /*option High*/
            "Il cliente ha comprovato interesse! ",

            /*option Not Interested*/
            "Il cliente non è interessato!",

            /*option No Answer*/
            "Il cliente non risponde!",

            /*option Wrong Number*/
            "Il numero del cliente è sbagliato!",

            /*option Busy*/
            "Il cliente è occupato!",

            /*option Segretaria*/
            "Risponde la segreteria telefonica! ",

            /*option FTD*/
            "Il cliente ha aderito alla proposta!",];

        srcLocation = locations    [sel.selectedIndex];
        if (srcLocation != undefined && srcLocation != "") {
            document.getElementById('CSTemplates').innerHTML= srcLocation;
        }
    }

    function setAssigned() {
        var transfer_number = document.getElementById("transfer_number").href;
        var assigned_ret = document.getElementById("assigned_retention").value;
        console.log(assigned_ret);
        var fixed_a = transfer_number.concat(assigned_ret);
        console.log('fixed: ', fixed_a);
        document.getElementById("transfer_number").href = fixed_a;
    }

    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(document).ready(function() {
        $('#datetime').datetimepicker({
            minDate: new Date(),
            format: 'DD-MM-YYYY HH:mm:00',
        });

        $('[name="start"]').datetimepicker({
            minDate: new Date(),
            format: 'DD-MM-YYYY HH:mm:00',
        });


        // $(".scrollablec").css({
        //   'height': (($(".tasksc").height()+30) + 'px')
        // });
    });
    $('.leadsNav').addClass('active');
    <?php

    if (isset($_SESSION['email_sent'])) {
    if ($_SESSION['email_sent']=='success') { ?>//if edit success
    $.notify({
        icon: "done",
        message: "Email Sent!"
    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });

    <?php } elseif($_SESSION['email_sent']=='fail') { ?> //if fail
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
    unset($_SESSION['email_sent']);
    }

    if (isset($_SESSION['sms_sent'])) {
    if ($_SESSION['sms_sent']=='success') { ?>//if edit success
    $.notify({
        icon: "done",
        message: "SMS Sent!"
    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });

    <?php } elseif($_SESSION['sms_sent']=='fail') { ?> //if fail
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
    unset($_SESSION['sms_sent']);
    }


    if (isset($_SESSION['create_lead'])) {
    if ($_SESSION['create_lead']=='success') { ?> //if fail
    $.notify({
        icon: "done",
        message: "Lead Created!"
    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
    <?php }
    unset($_SESSION['create_lead']);
    }
    if (isset($_SESSION['edit_lead'])) {
    if ($_SESSION['edit_lead']=='success') { ?> //if fail
    $.notify({
        icon: "done",
        message: "Lead Updated!"
    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
    <?php }
    unset($_SESSION['edit_lead']);
    }
    ?>

    function deleteNote(note_id){
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: 'red',
            confirmButtonText: 'Delete Comment'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/deleteNote/'+note_id,
                    type: 'POST',
                })
                    .done(function(data) {
                        console.log("success");
                        location.href=location.href;
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                //console.log(lead_id);
            }
        })
    }

    function deleteEvolution(evolution_id){
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: 'red',
            confirmButtonText: 'Delete Evolution?'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/deleteEvolution/'+evolution_id,
                    type: 'POST',
                })
                    .done(function(data) {
                        console.log("success");
                        location.href=location.href;
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                //console.log(lead_id);
            }
        })
    }

    function editTask(task_id,content,start){
        $('.edit_task_comment').val(content);
        $('.edit_task_task_id').val(task_id);
        $('.edit_task_start').val(start);
        $('.edit_task_start').datetimepicker({
            minDate:new Date(),
            format: 'DD-MM-YYYY HH:mm:00',
        });
        $('#edit_task_modal').modal();
    }

    function editReminder(reminder_id,content,start){
        $('.edit_reminder_comment').val(content);
        $('.edit_reminder_reminder_id').val(reminder_id);
        $('.edit_reminder_start').val(start);
        $('.edit_reminder_start').datetimepicker({
            minDate:new Date(),
            format: 'DD-MM-YYYY HH:mm:00',
        });
        $('#edit_reminder_modal').modal();
    }

    function editEvent(event_id,content,start){
        $('.edit_event_comment').val(content);
        $('.edit_event_event_id').val(event_id);
        $('.edit_event_start').val(start);
        $('.edit_event_start').datetimepicker({
            minDate:new Date(),
            format: 'DD-MM-YYYY HH:mm:00',
        });
        $('#edit_event_modal').modal();
    }

    function editNoteFinal(lead_id, note){

        console.log(note);
        console.log('lead ', lead_id)
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: '#00bcd4',
            confirmButtonText: 'Change'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/editNoteFinal/',
                    type: 'POST',
                    data: {
                        lead_id:lead_id,
                        note:note,
                    },
                })
                    .done(function(data) {
                        console.log("success");
                        location.reload();
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                console.log(lead_id);
            }
        })
    }




    function deleteEvent(event_id){
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: 'red',
            confirmButtonText: 'Delete Event'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/deleteEvent/'+event_id,
                    type: 'POST',
                })
                    .done(function(data) {
                        console.log("success");
                        location.href=location.href;
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                //console.log(lead_id);
            }
        })
    }

    function deleteTask(task_id){
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: 'red',
            confirmButtonText: 'Delete Task'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/deleteTask/'+task_id,
                    type: 'POST',
                })
                    .done(function(data) {
                        console.log("success");
                        location.href=location.href;
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                //console.log(lead_id);
            }
        })
    }

    function deleteReminder(reminder_id){
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: 'red',
            confirmButtonText: 'Delete Reminder'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/deleteReminder/'+reminder_id,
                    type: 'POST',
                })
                    .done(function(data) {
                        console.log("success");
                        location.href=location.href;
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                //console.log(lead_id);
            }
        })
    }

    function editNote(note_id,content){
        var inputValue =content;
        var {value: content1} =  Swal.fire({
            title: 'Edit Note',
            input: 'text',
            inputValue: inputValue,
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write something!'
                }else{
                    $.ajax({
                        url: '<?=URL?>api/editNote/'+note_id,
                        type: 'POST',
                        data:{content:value}
                    })
                        .done(function(data) {
                            console.log("success");
                            location.href=location.href;
                        })
                        .fail(function(err) {
                            console.log(err);
                        });
                }
            }
        })
    }

    function editEvolution(evolution_id,content){
        var inputValue =content;
        var {value: content1} =  Swal.fire({
            title: 'Edit Evolution',
            input: 'text',
            inputValue: inputValue,
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write something!'
                }else{
                    $.ajax({
                        url: '<?=URL?>api/editEvolution/'+evolution_id,
                        type: 'POST',
                        data:{content:value}
                    })
                        .done(function(data) {
                            console.log("success");
                            location.href=location.href;
                        })
                        .fail(function(err) {
                            console.log(err);
                        });
                }
            }
        })
    }

    function editStatus(lead_id,status_id){
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: '#00bcd4',
            confirmButtonText: 'Change'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/editStatus/',
                    type: 'POST',
                    data: {lead_id:lead_id,
                        status_id:status_id,
                    },
                })
                    .done(function(data) {
                        console.log("success");
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                console.log(lead_id);
                $($('.ss'+lead_id)).val($('.oldstatus'+lead_id).val());
            }
        })
    }

    function editWebform(lead_id, webform){

        console.log(webform);
        console.log('lead ', lead_id)
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: '#00bcd4',
            confirmButtonText: 'Change'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/editWebform/',
                    type: 'POST',
                    data: {
                        lead_id:lead_id,
                        webform:webform,
                    },
                })
                    .done(function(data) {
                        console.log("success");
                        location.reload();
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                console.log(lead_id);
                $($('.sss'+lead_id)).val($('.oldmental'+lead_id).val());
            }
        })
    }

    function editMental(lead_id,mental){
        swal({
            title: 'Are you sure?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#777',
            confirmButtonColor: '#00bcd4',
            confirmButtonText: 'Change'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?=URL?>api/editMental/',
                    type: 'POST',
                    data: {lead_id:lead_id,
                        mental:mental,
                    },
                })
                    .done(function(data) {
                        console.log("success");
                    })
                    .fail(function(err) {
                        console.log(err);
                    });
            }else{
                console.log(lead_id);
                $($('.sss'+lead_id)).val($('.oldmental'+lead_id).val());
            }
        })
    }

    $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '<?php echo URL; ?>assets/ep/img/',
            popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
    });

    $tooltip=$('.call_now_btn');
    $tooltip.tooltip();


</script>

<script type="text/javascript">
    function openChangelog(){
        $('#open_log').modal();
    }
    function setAssigned() {
        var transfer_number = document.getElementById("transfer_number").href;
        var assigned_ret = document.getElementById("assigned_retention").value;
        console.log(assigned_ret);
        var fixed_a = transfer_number.concat(assigned_ret);
        console.log('fixed: ', fixed_a);
        document.getElementById("transfer_number").href = fixed_a;
    }
</script>
