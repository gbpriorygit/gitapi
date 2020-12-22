<title><?php echo $lead->first_name." ".$lead->last_name;  ?></title>

<style>

    body{ background-image: linear-gradient(rgba(0,0,0,0.1) , rgba(0,0,0,0.2) ), url("../../assets/img/ferrari1-min.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: right;}
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
            <form method="POST" action="">
                <div class="col-sm-12">
                    <div class="card border_card">
                        <div class="card-header" data-background-color="blue">
                            <h4 class="title">Lead Details</h4>
                        </div>
                        <div class="card-content">
                            <div class="row">

                                <div>
                                    <!-- Nav tabs -->
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

                                    <!-- Tab panes -->
                                    <div class="tab-content">

                                        <div role="tabpanel" class="tab-pane active" id="home">
                                            <div class="">
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">First Name</label>
                                                        <input type="text" disabled   value="<?=$lead->first_name;?>" class="form-control fn ">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Last name</label>
                                                        <input type="text" disabled  value="<?=$lead->last_name;?>" class="form-control ln">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Mobile Number</label>
                                                        <input type="text" disabled  value="<?=$lead->phone_number;?>" class="form-control pn">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Phone Number</label>
                                                        <input type="text" disabled  value="<?=$lead->alt_number;?>" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Email</label>
                                                        <input type="text" disabled   value="<?=$lead->email;?>" class="form-control em">

                                                        <div class="callIconsDiv">
                                                            <img src="<?php echo URL; ?>assets/img/gmail.png" style="width:auto;height:34px" alt="WhatsApp"  onclick="$('.to_name').val($('.fn').val()+' '+$('.ln').val());$('.to').val($('.em').val());$('#send_email_modal').modal();"/>
                                                        </div>
                                                    </div>
                                                </div>



                                                <?php if(!isset($_GET['modal'])){ ?>

                                                    <div class="row" style="margin:0">


                                                        <?php if($lead->source==='Academy'): ?>

                                                        <?php else: ?>
                                                            <div class="col-sm-6">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Email</label>
                                                                    <input type="text" disabled   value="<?=$lead->email;?>" class="form-control em">

                                                                    <div class="callIconsDiv">
                                                                        <img src="<?php echo URL; ?>assets/img/gmail.png" style="width:auto;height:34px" alt="WhatsApp"  onclick="$('.to_name').val($('.fn').val()+' '+$('.ln').val());$('.to').val($('.em').val());$('#send_email_modal').modal();"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group label-floating">
                                                                    <label class="control-label">Mobile Number</label>
                                                                    <input type="text" disabled  value="<?=$lead->phone_number;?>" class="form-control pn">
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
                                                                        &nbsp;
                                                                        <a class="callIcons">

                                                                            <img  src="<?php echo URL; ?>assets/img/phone1.png" data-toggle="tooltip" data-placement="top" alt="phone 1" title="Office"  onclick="sipCall('call-audio','<?=$_SESSION['user_sip'].$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                                        </a>
                                                                        &nbsp;
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

                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php if($lead->source==='Academy'): ?>

                                                    <?php else: ?>
                                                        <div class="col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Phone Number</label>
                                                                <input type="text" disabled  value="<?=$lead->alt_number;?>" class="form-control">
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
                                                                    <a class="callIcons">

                                                                        <img  src="<?php echo URL; ?>assets/img/phone1.png" data-toggle="tooltip" data-placement="top" alt="phone 1" title="Office"  onclick="sipCall('call-audio','<?=$_SESSION['user_sip'].$lead->alt_number;?>','<?=$lead->lead_id;?>',$(this).data('title'));$(this).addClass('btn_call_clicked');" class="material-icons call_now_btn callImg"/>

                                                                    </a>
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
                                                    <?php endif; ?>
                                                <?php }?>

                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="profile">

                                            <div class="col-sm-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Note</label>
                                                    <input type="text" name="note"   value="<?=$lead->note;?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Status</label>
                                                    <?php
                                                    $output='';
                                                    $st='';
                                                    foreach ($statuses as $key => $status) {
                                                        $st.='<option value="'.$status->status_id.'">'.$status->status_name.'</option>';
                                                    }
                                                    $output.='<td><select name="status" class="cho form-control ss'.$lead->lead_id.'" onchange="editStatus('.$lead->lead_id.',Number(this.value))" id="status_select"><option class="oldstatus'.$lead->lead_id.'" value="'.$lead->status.'">'.$lead->status_name.'</option>'.$st.'</select></td>';
                                                    echo $output;
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Registered</label>
                                                    <input type="text" disabled  id="date_created" value="<?=date('d-m-Y   h:m:i',strtotime($lead->date_created))?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Mental</label>
                                                    <td>
                                                        <select name="mental" class="cho form-control sss'.$lead->lead_id.'" onchange="editMental('<?=$lead->lead_id;?>',this.value)" id="mental_select">
                                                            <option selected class="oldmental<?=$lead->lead_id;?>" value="<?=$lead->mental;?>"><?=$lead->mental;?></option>
                                                            <option>None</option>
                                                            <option>Increase</option>
                                                            <option>Static</option>
                                                            <option>Self Respect</option>
                                                            <option>Distress</option>
                                                        </select>
                                                    </td>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Source</label>
                                                    <input type="text" disabled   value="<?=$lead->source;?>" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Assigned To</label>
                                                    <select disabled="" class="cho form-control" required name="supervisor" id="supervisor">
                                                        <?php
                                                        $output='';
                                                        foreach ($operators as $operator) {
                                                            if ($lead->assigned_to==$operator->user_id) {
                                                                $output.='<option selected="" value="'.$operator->user_id.'" >'.$operator->first_name.' '.$operator->last_name.'</option>';
                                                            }else{
                                                                $output.='<option value="none">None</option>';
                                                            }
                                                        }
                                                        echo $output;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Brand</label>
                                                    <input type="text" disabled   value="<?=$lead->brand;?>" class="form-control">
                                                </div>
                                            </div>


                                            <div class="col-sm-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Webform</label>
                                                    <a target="_blank" style="cursor:pointer" href="<?=$lead->webform;?>"><?=$lead->webform;?></a>
                                                </div>
                                            </div>

                                        </div>

                                        <div role="tabpanel" class="tab-pane" id="comments">

                                            <div class="col-md-12 leadElements ">
                                                <div class="card" >
                                                    <div class="card-header border-grey-1" data-background-color="blue">
                                                        <h4 class="title">Comments<button type="button" class="btn btn-white pull-right" style="padding: 6px 12px;margin:0" onclick="$('#add_note_modal').modal();" name="button">+ Comment</button></h4>
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

                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="activity">


                                            <div class="row ">
                                                <div class="col-md-6" id="tasks_">
                                                    <div class="card">
                                                        <div class="card-header border-grey-1" data-background-color="blue">
                                                            <h4 class="title">Calendar
                                                                <button type="button" class="btn btn-white pull-right" style="padding: 6px 12px;;margin:0" onclick="$('#add_task_modal').modal();" name="button">+ Task</button>
                                                            </h4>

                                                            <!-- <p class="category">Creating new user</p> -->
                                                        </div>
                                                        <div class="card-content ">
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
                                                                <button type="button" class="btn btn-white pull-right" style="padding: 6px 12px;;margin:0" onclick="$('#add_event_modal').modal();" name="button">+ Event</button>
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


                                            <div class="col-sm-12">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Data Sheets</label>
                                                    <textarea type="text" disabled  rows="4"  class="form-control"><?=$lead->data_sheets;?></textarea>
                                                </div>
                                            </div>
                                            <div class="row  ">
                                                <div class="col-md-12 scrollablec">
                                                    <div class="card" >
                                                        <div class="card-header border-grey-1" data-background-color="blue">
                                                            <h4 class="title">Evolution Form<button type="button" class="btn btn-white pull-right" style="padding: 6px 12px;margin:0" onclick="$('#add_evolution_modal').modal();" name="button">+ Evolution</button></h4>
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
                                                        <input type="text" disabled   value="<?=$lead->first_name;?>" class="form-control fn ">
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
                                                        <label class="control-label">Mobile Number</label>
                                                        <input type="text" disabled  value="<?=$lead->phone_number;?>" class="form-control pn">
                                                        <?php if ($lead->source === 'Appointment'): ?>
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
                                                                    <img  src="<?php echo URL; ?>assets/img/phone0.png" data-toggle="tooltip" data-placement="top" class="callImg material-icons call_now_btn callImg" alt="phone 1" title="Mobile"    onclick="sipCall('call-audio','<?='77'.$_SESSION['user_sip'].$lead->phone_number;?>','<?=$lead->lead_id;?>');"/>

                                                                </a>
                                                                &nbsp;
                                                                <a class="callIcons">

                                                                    <img  src="<?php echo URL; ?>assets/img/phone1.png" data-toggle="tooltip" data-placement="top" alt="phone 1" title="Office"  onclick="sipCall('call-audio','<?=$_SESSION['user_sip'].$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                                </a>
                                                                &nbsp;
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
                                                            </div>
                                                        <?php elseif($lead->source==='Academy'): ?>

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


                                                                <a class="callIcons wpIcon" target="blank" href="https://web.whatsapp.com/send?phone=<?=$lead->phone_number;?>&amp;text=&amp;source=&amp;data=">
                                                                    <img class="socialImg" src="<?php echo URL; ?>assets/img/whatsapp.png" style="width:auto;height:27px" alt="WhatsApp"/>
                                                                </a>
                                                                <a class="callIcons">
                                                                    <img  src="<?php echo URL; ?>assets/img/phone0.png" data-toggle="tooltip"  class="material-icons call_now_btn callImg" alt="phone 1" title="Mobile"    onclick="sipCall('call-audio','<?='60'.$lead->phone_number;?>','<?=$lead->lead_id;?>');"/>

                                                                </a>
                                                                <a class="callIcons">

                                                                    <img  src="<?php echo URL; ?>assets/img/phone1.png" alt="phone 1" title="Office"  onclick="sipCall('call-audio','<?='62'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                                </a>
                                                                <a class="callIcons">
                                                                    <img  src="<?php echo URL; ?>assets/img/phone3.png" alt="phone 1"  title="Random IR" onclick="sipCall('call-audio','<?='61'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                                </a>

                                                                &nbsp;
                                                                <a class="callIcons">
                                                                    <img  src="<?php echo URL; ?>assets/img/phone2.png" data-toggle="tooltip" data-placement="top" alt="phone 1"  title="Random IT" onclick="sipCall('call-audio','<?='99'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                                </a>
                                                                &nbsp;
                                                                <a class="callIcons">
                                                                    <img  src="<?php echo URL; ?>assets/img/phone4.png" data-toggle="tooltip" data-placement="top" title="Mobile Random"  onclick="sipCall('call-audio','<?='66'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                                </a>
                                                                &nbsp;
                                                                <a class="callIcons">
                                                                    <img  src="<?php echo URL; ?>assets/img/phone5.png" data-toggle="tooltip" data-placement="top" alt="phone 1"   title="Random CEL ITA" onclick="sipCall('call-audio','<?='67'.$lead->phone_number;?>','<?=$lead->lead_id;?>');" class="material-icons call_now_btn callImg"/>

                                                                </a>
                                                            </div>


                                                        <?php else: ?>

                                                            <div  class="callIconsDiv" >

                                                                <a class="callIcons wpIcon" target="blank" href="https://web.whatsapp.com/send?phone=<?=$lead->phone_number;?>&amp;text=&amp;source=&amp;data=">
                                                                    <img class="socialImg" src="<?php echo URL; ?>assets/img/whatsapp.png" style="width:auto;height:27px" alt="WhatsApp"/>
                                                                </a>
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

                                                        <?php endif; ?>
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
                                                            <h4 class="title">Comments<button type="button" class="btn btn-white pull-right" style="padding: 6px 12px;margin:0" onclick="$('#add_note_academy_modal').modal();" name="button">+ Comment</button></h4>
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
                                                <div class="col-md-12 scrollablec" id="reminders_">
                                                    <div class="card">
                                                        <div class="card-header" data-background-color="blue">
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
                                                                        <p class="category pull-right caseText">
                                                                            <font class="editreminder" onclick="editReminder(<?=$reminder->reminder_id?>,'<?=$reminder->content?>','<?=date("d-m-Y H:i:s", strtotime($reminder->start))?>')"><i class="material-icons">edit</i></font>
                                                                            <font class="deletereminder" onclick="deleteReminder(<?=$reminder->reminder_id;?>)"><i class="material-icons">delete</i></font>
                                                                            <?=$reminder->first_name." ".$reminder->last_name ?>
                                                                        </p>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                        <?=$reminder->content?>
                                                                        <p  class="category pull-right caseText" id="reminder_<?=$reminder->reminder_id?>"><?=$reminder->status ?>
                                                                            <?php if ($reminder->status=="Pending"): ?>
                                                                                <a onclick="setReminderStatus(<?=$reminder->reminder_id?>)" style="padding: 6px 12px;margin-left: 10px !important;margin:0"  class="btn btn-white">✔</a>
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

                                                <div class="col-sm-12">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Description Apertura</label>
                                                        <input  onchange="editDatasheets('<?=$lead->lead_id;?>',this.value)"  type="text" rows="4" value="<?=$lead->data_sheets;?>" class="form-control">
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
                                                        <label class="control-label">Assign to retention</label>
                                                        <select onchange="setAssigned()" style="margin:0" class="form-control" name="assigned_retention" id="assigned_retention">
                                                            <option selected value="0">None</option>
                                                            <option value="79">Christopher Nodier</option>
                                                            <option value="77">Jacob Levi</option>
                                                            <option value="78">Vitaly Kasyan</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <?php if (isset($tasks[0])) $task_date=$tasks[0]->start;
                                                else $task_date='';
                                                echo $task_date;?>

                                                <div class="col-sm-6">
                                                    <a id="transfer_number" href="http://any1coin.net/dashboard/api/transfer/?lead_id=<?php echo $lead->lead_id.'&first_name='.$lead->first_name.'&last_name='.$lead->last_name.'&phone_number='.$lead->phone_number.'&email='.$lead->email.'&source='.$lead->source.'&assigned_apertura='.$lead->assigned_to.'&status='.$lead->status.'&data_sheets='.$lead->data_sheets.'&task_date='.$task_date.'&assigned_retention='?>" class="btn btn-info pull-left"> <i class="fa fa-share"> </i> Send lead</a>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>





                <div class="col-sm-12">
                    <div class="card border_card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" name="edit_lead">

                                    <a href="../" class="btn btn-info pull-left">Back</a>
                                    <a onclick="openChangelog()" class="btn btn-info pull-left">Changelog</a>
                                    <button type="submit" class="submit-btn btn btn-warning  pull-left">Update</button>
                                    <?php
                                    $st=(isset($_GET["status"])?$_GET["status"]:"all");
                                    if ($st!='all') {
                                        if (isset($st[0])) {
                                            $st=$st[0];
                                        }
                                    }
                                    ?>
                                    <a href="../nextLead/<?=$lead->lead_id;?>/<?=$st?>/next" class="submit-btn btn btn-info  pull-right">Next</a>
                                    <a href="../nextLead/<?=$lead->lead_id;?>/<?=$st?>/previous" class="submit-btn btn btn-info  pull-right">Previous</a>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="add_note_modal" class="modal fade" role="dialog">
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
                    <?php $color= array('Appointment' => 'green','Facebook'=>'#3b5998','AnyOnePower'=>'#D2B471','Google'=>'#CB7F3C'); ?>
                    <input type="hidden" value="<?=$color[$lead->source]?>" name="color"></input>
                    <div class="col-sm-4" style=" background-color: #EEEEEE; color: #3C4858;">
                        <div class="form-group ">
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

<div id="send_email_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content" style="height:630px">
            <div class="modal-body">
                <form class="" action="<?=URL?>/api/sendEmail" method="post">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Subject</label>
                            <input type="text" required name="subject" value="" class="form-control">
                            <label class="control-label">Body</label>
                            <textarea type="text" id="editor" style="color:black" name="body" rows="5" cols="10" wrap="soft" class="form-control"></textarea>

                        </div>
                    </div>
                    <input type="hidden" value="" class="to" name="to"></input>
                    <input type="hidden" value="" class="to_name" name="to_name"></input>
                    <?php if($lead->source==='Academy'): ?>
                        <input type="hidden" value="info@academyofinvestment.com" class="from" name="from"></input>
                        <input type="hidden" value="Academy" class="from_name" name="from_name"></input>


                    <?php else: ?>
                        <input type="hidden" value="<?php echo $_SESSION['user_email'] ?>" class="from" name="from"></input>
                        <input type="hidden" value="<?php echo $_SESSION['full_name'] ?>" class="from_name" name="from_name"></input>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-submit pull-right" name="submit">Send</button>
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

    .deletereminder:hover{
        color: red;
        cursor: pointer;
    }
    .editreminder:hover{
        color: orange;
        cursor: pointer;
    }

    .emoji-wysiwyg-editor{
        height: 100px !important;
    }
    .ck-editor {
        color:black !important;
    }

    .ck .ck-content{
        min-height:350px;}
</style>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>


<script type="text/javascript">

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

    function editDatasheets(lead_id, datasheets){

        console.log(datasheets);
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
                    url: '<?=URL?>api/editDatasheets/',
                    type: 'POST',
                    data: {
                        lead_id:lead_id,
                        datasheets:datasheets,
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
<style media="screen">
    .btn_call_clicked{
        border: 1px #242525 solid;
        border-radius: 5px;
    }
</style>
<div class="modal fade" id="open_log" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style=" width: 100%;
height: 100%;
margin: 0;
padding: 0;" role="document">
        <div class="modal-content" style=" height: auto;
min-height: 100%;
border-radius: 0;">
            <div class="modal-header">
                <h5 class="modal-title" style="float: left;" >Changes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <table style="color:black !important;" class="table table-striped table-bordered table-responsive">
                    <?php
                    $output='<thead><td>Date</td><td>User</td><td>Changes</td></thead>';
                    foreach ($changelog as $log) {
                        $useri= $this->model->getUser($log['user_id']);
                        $useri=$useri->first_name." ".$useri->last_name;
                        $output.="<tr>";
                        $output.="<td>".$log['date']."</td><td>".$useri."</td>";
                        $output.="<td>";
                        $diff=explode("|",$log['diff']);
                        foreach ($diff as $d) {
                            $output.=$d."</br>";
                        }
                        $output.="</td>";

                        $output.="</tr>";
                    }
                    echo $output;
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function openChangelog(){
        $('#open_log').modal();
    }
</script>
