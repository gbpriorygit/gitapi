<title>Uploads</title>
<style>

    body{ background-image: linear-gradient(rgba(0,0,0,0.1) , rgba(0,0,0,0.2) ), url("../../assets/img/bg_7.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: bottom;}

    .doc_upload{display: flex;
        align-items: center;
        justify-content: space-around;}
    .td_custom{padding: 27px 0!important;}

    .card{background: #00000052!important;}
    .card-header{text-align: center;
        background: linear-gradient(to top, #0f0c29, #0a2048, #24243e)!important;}
    .card-header h4 {font-size:22px;margin-bottom:0!important;}
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
                        <div class="card-header border-grey-1" data-background-color="blue">
                            <h4 class="title">Uploads
                                <button type="button" class="btn btn-white pull-right" style="padding: 6px 12px;;margin:0" onclick="$('#add_upload_modal').modal();" name="button">+ Upload</button>
                            </h4>

                            <!-- <p class="category">Creating new user</p> -->
                        </div>
                        <div class="card-content">
                            <div class="row">

                                <div>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs mb-20" role="tablist">
                                        <?php foreach($users as $key=>$user): ?>
                                            <li role="presentation" class="uploadTabs <?php if($key==0) echo 'active';?>"><a href="#<?=$user->user_id?>" role="tab" data-toggle="tab"><?=$this->model->user_tab($user)?></a></li>
                                        <?php endforeach; ?>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">

                                        <?php foreach($users as $key=>$user): ?>
                                            <div role="tabpanel" class="tab-pane  <?php if($key==0) echo 'active';?>" id="<?=$user->user_id?>">
                                            <div class="">
                                                <table class="table table-hover">

                                                    <thead>

                                                    <tr>

                                                     <th>Check</th>
                                                     <th>File</th>
                                                     <th>Upload Time</th>
                                                     <th>Read Time</th>
                                                     <th>Remove</th>


                                                    </tr>
                                                    </thead>

                                                    <?php
                                                    $documents=$this->model->getUploads($user->user_id);
                                                    $output='';
                                                    foreach ($documents as $doc) {
                                                        $docname=explode("/",$doc->url);


                                                        if ($doc->seen==1) {$output.="<tr class=''><td class='td_custom' style='color:#09BDC5;font-size:18px;font-weight: 900' >✓✓</td><td class='td_custom'><a target='_blank' href=".URL."api/getUploadAdmin/".$doc->document_id.">".$docname[count($docname)-1]."</a></td><td class='td_custom'>$doc->date</td><td class='td_custom'>$doc->seen_time</td><td><a class='btn'href=".URL."api/deleteUpload/".$doc->document_id.">x</a></td></tr>";
                                                       }else {$output.="<tr class=''><td class='td_custom' style='font-size:18px;font-weight: 900'>✓</td><td class='td_custom'><a target='_blank' href=".URL."api/getUploadAdmin/".$doc->document_id.">".$docname[count($docname)-1]."</a></td><td class='td_custom'>$doc->date</td><td class='td_custom'>$doc->seen_time</td><td><a class='btn'href=".URL."api/deleteUpload/".$doc->document_id.">x</a></td></tr>";
                                                            }

                                                        }


                                                    echo $output;
                                                    ?>
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





            </form>
        </div>
    </div>
</div>

<div id="add_upload_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="height:200px;  background-color: #EEEEEE; color: #3C4858;">
            <div class="modal-body">
                <form action="<?=URL?>admin/uploadFile" enctype="multipart/form-data" method="POST" class="col-sm-12 dz-parent">

                    <div class="col-sm-8">
                        <div class="form-group">
                            <label style="font-size: 20px" class="control-label">Choose File</label>

                                <div id="zdrop" class="fileuploader">
                                    <div id="upload-label" >
                                      <span class="title" style="color:black">
                                        <input  accept="application/pdf" name="documents" type="file" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4" style=" background-color: #EEEEEE; color: #3C4858;">
                        <div class="form-group " >
                            <label class="control-label">User</label>
                            <select name="user_id" id="">
                                <?php foreach($users as $u) {
                                    echo '<option value="' . $u->user_id . '">' . $u->first_name . ' ' . $u->last_name . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                </form>
            </div>
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
<!--                    <input type="hidden" value="--><?//=$lead->lead_id;?><!--" name="lead_id"></input>-->
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
<!--                    <input type="hidden" value="--><?//=$lead->lead_id;?><!--" name="lead_id"></input>-->
                    <input type="hidden" value="1" name="add_note"></input>

                    <a class="btn btn-submit pull-right" name="submit">Submit</a>
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
    .call_now_btn{
        display: none;
    }
</style>

<script type="text/javascript">

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
    $('.uploadNav').addClass('animationbtn');
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
</script>
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
    function setAssigned() {
        var transfer_number = document.getElementById("transfer_number").href;
        var assigned_ret = document.getElementById("assigned_retention").value;
        console.log(assigned_ret);
        var fixed_a = transfer_number.concat(assigned_ret);
        console.log('fixed: ', fixed_a);
        document.getElementById("transfer_number").href = fixed_a;
    }
</script>
