<title>Leads</title>
<style>body{
   background-image:linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.5)),  url("<?php echo URL; ?>assets/img/bp_new.jpg");}
   background-position:top;
</style>
            <div class="content" style="margin-top: 30px">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header row border-grey" data-background-color="blue">
                                    <div class="col-md-12">
                                      <div class="logo">
                                        <center>
                                          <img style="width: 238px;margin-bottom: -45px;" src="<?php echo URL; ?>assets/img/logo_any12.png">
                                        </center>

                                          </div>

                                        <div class="card-icon sbtn" style="float:right;cursor:pointer;">
                                            <i class="material-icons">search</i>
                                          </div>
                                        <h4 class="title"><?php echo $countleads;?></h4>
                                     </div>
                                     <?php
                                        $assigned_to= (isset($_GET['assigned_to'])?$_GET['assigned_to']:'%');
                                        $status=      (isset($_GET['status'])?$_GET['status']:'%');
                                        $source=      (isset($_GET['source'])?$_GET['source']:'%');
//                                        $assigned_from=(isset($_GET['assigned_from'])?$_GET['assigned_from']:'%');
//                                        $level=       (isset($_GET['level'])?$_GET['level']:'%');
//                                        $mental=       (isset($_GET['mental'])?$_GET['mental']:'%');
                                      ?>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <form action="" method="GET" id="main_form">
                                                <ul class="card nav nav-pills nav-pills-warning nav-pills-icons justify-content-center filter_data" role="tablist" >
                                                  <center>
                                                    <h1 style= "margin:0;padding:0;font-size: 18px; color:whitesmoke;">	ONE WORLD ONE COIN</h1>
                                                  </center>
                                                    <div class="row" style="margin-left:5px;margin-right:5px">
                                                        <div class="col-md-4">
                                                            <div class="form-group label-floating ">
                                                                <label class="control-label">Search</label>
                                                                <input type="text" class="form-control" value="<?=(isset($_GET['search_'])?$_GET['search_']:'')?>" name="search_" id="search_">
                                                            <span class="material-input"></span></div>
                                                        </div>

                                                        <input class="page_val" id="page_val" type="hidden" name="page" value='<?php echo (isset($_GET['page'])?$_GET['page']:0)?>'>
                                                        <div class="col-md-4">
                                                            <center >
                                                                <div style="padding-top: 12px;">
                                                                    <input type="submit" name="" value="Search" class="btn btn-info submit_btn">
                                                                    <a style="cursor:pointer;" class="btn btn-info" onclick="exportLeads()">Export</a>
                                                                    <a href="#" class="btn reset_btn">Reset</a>
                                                                <span class="material-input"></span></div>
                                                            </center>
                                                        </div>
                                                        <div class="col-md-4">
                                                          <style media="screen">
                                                          .card [data-background-color] a {
                                                                color: white !important;
                                                              }
                                                              .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span {
                                                                background-color: #bfac71!important;
                                                                border-color: #bfac71!important;
                                                                color: white;
                                                              }
                                                              .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
                                                                background-color: #ba9c55!important;
                                                                border-color: #ba9c55;
                                                              }
                                                          </style>
                                                          <center style="padding-top: 10px;">
                                                          <div class="dataTables_paginate paging_full_numbers" id="datatables_paginate">
                                                              <?php if (isset($_GET['page'])) {
                                                                  $page=(int)$_GET['page'];
                                                              }else{
                                                                  $page=0;
                                                              } ?>
                                                              <script type="text/javascript">
                                                                  $page=<?=$page?>;
                                                              </script>

                                                                <ul class="pagination" style="cursor:pointer;">
                                                                  <?php if ($page>0) { ?>
                                                                      <li class="page-item">
                                                                        <a class="page-link" onclick="$('.page_val').val($page-1)" aria-label="Precedentes">
                                                                          <span aria-hidden="true"><i class="material-icons">keyboard_arrow_left</i></span>
                                                                          <span class="sr-only">Precedente</span>
                                                                        </a>
                                                                      </li>
                                                                      <?php if ($page>1) { ?>
                                                                      <li class="page-item"><a class="page-link" onclick="$('.page_val').val($page-2)"><?=$page-1;?></a></li>
                                                                    <?php } ?>
                                                                      <li class="page-item"><a class="page-link" onclick="$('.page_val').val($page-1)"><?=$page-1+1;?></a></li>
                                                                  <?php } ?>
                                                                  <li class="page-item active"><a class="page-link" onclick="$('.page_val').val($page)"><?=$page+1 ;?></a></li>
                                                                  <?php if ($page<$pages-1) { ?>
                                                                      <li class="page-item"><a class="page-link" onclick="$('.page_val').val($page+1)"><?=$page+1+1;?></a></li>

                                                                      <?php if ($page<$pages-2) { ?>
                                                                        <li class="page-item"><a class="page-link" onclick="$('.page_val').val($page+2)"><?=$page+1+2;?></a></li>
                                                                      <?php } ?>
                                                                      <?php if ($page<$pages-3) { ?>
                                                                        <li class="page-item"><a class="page-link" onclick="$('.page_val').val($page+3)"><?=$page+1+3;?></a></li>
                                                                      <?php } ?>
                                                                    <?php if ($page<$pages-4) { ?>
                                                                        <li class="page-item"><a class="page-link" onclick="$('.page_val').val($page+4)"><?=$page+1+4;?></a></li>

                                                                    <?php } ?>
                                                                      <li class="page-item">
                                                                        <a class="page-link" onclick="$('.page_val').val($page+1)" aria-label="Successivo">
                                                                          <span aria-hidden="true"><i class="material-icons">keyboard_arrow_right</i></span>
                                                                          <span class="sr-only"></span>
                                                                        </a>
                                                                      </li>
                                                                  <?php } ?>
                                                                  <li class="page-itebm">
                                                                    <a class="showtotalplbtn" href="#"><i class="material-icons">close</i></a></br>
                                                                    <a  href="#" class="page-link showtotalpl" style="color:black !important;background:white;margin:15px;display:none">
                                                                      <?=($pages==0?1:$pages);?> Pages / <?=$countleads;?> Leads
                                                                    </a>
                                                                  </li>

                                                                </ul>

                                                          </div>
                                                        </center>
                                                        </div>
                                                    </div>
                                                </ul>

                                          </div>
                                        </div>
                                </div>
                                <center id="selectallbtn" style="display:none"><a class="btn" onclick="allselected=true;$('.dlttxt').html('Remove '+countleads);">Select all <?=$countleads;?> leads</a></center>
                                <?php
                                    $query = $_GET;
                                    if (!isset($query['orderdir'])) {
                                      $query['orderdir']="DESC";
                                      echo "<script>var orderdir_='';</script>";
                                    }else {
                                      if ($query['orderdir']=="DESC") {
                                          echo "<script>var orderdir_='↓';</script>";
                                          $query['orderdir']="ASC";
                                      }elseif ($query['orderdir']=="ASC") {
                                          echo "<script>var orderdir_='↑';</script>";
                                          $query['orderdir']="DESC";
                                      }
                                    }
                                ?>
                                <div class="card-content table-responsive box-outer">
                                    <a class="arrow-left arrow" id="arrowLeft"><i class="fa fa-chevron-left"></i></a>
                                    <a class="arrow-right arrow" id="arrowRight"><i class="fa fa-chevron-right"></i></a>
                                    <div class=" box-inner">
                                    <table class="table table-hover table-leads">
                                        <thead>
                                            <th><strong><input class="check_all" type="checkbox" onclick="checkAll(this);"></input></strong></th>
                                            <th><strong>
                                              <a id="first_name_" href="<?php $query['orderby'] = 'first_name';$newget = http_build_query($query); echo URL; ?>?<?php echo $newget; ?>">Full Name</a></strong></br>
                                              <input type="text" value="<?=(isset($_GET['full_name'])?$_GET['full_name']:'')?>" name="full_name" id="full_name">
                                            </th>
                                            <th>
                                              <strong>Phone Number</strong></br>
                                              <input type="text" value="<?=(isset($_GET['phone_number'])?$_GET['phone_number']:'')?>" name="phone_number" id="phone_number">
                                            </th>
                                            <th>
                                              <strong>Email</strong></br>
                                              <input type="text" value="<?=(isset($_GET['email'])?$_GET['email']:'')?>" name="email" id="email">
                                            </th>
                                            <th><strong>
                                              <a id="status_" href="<?php $query['orderby'] = 'status';$newget = http_build_query($query);echo URL; ?>?<?php echo $newget; ?>">Status</strong></a></br>
                                              <select data-placeholder=" " class="cho" multiple name="status[]" id="status">
                                                  <!-- <option value='%'>All</option> -->
                                                  <!-- <option value='%'>&nbsp;</option> -->

                                                  <?php
                                                      $output='';
                                                      foreach ($statuses as $status1) {
                                                          $output.='<option value="'.$status1->status_id.'" >'.$status1->status_name.' | '.$this->model->countBy($assigned_to,$status1->status_id,$source).'</option>';//| '.$this->model->countBy($assigned_to,$status1->status_id,$source).'
                                                      }
                                                      echo $output;
                                                  ?>
                                              </select>
                                            </th>
                                            <th><strong>Ratting</strong></th>

<!--                                            <th><strong>Mental</strong></br>-->
<!--                                              <select data-placeholder=" "  class="cho" multiple name="mental[]" id="mental">-->
<!--                                                <option>None</option>-->
<!--                                                <option>Increase</option>-->
<!--                                                <option>Static</option>-->
<!--                                                <option>Self Respect</option>-->
<!--                                                <option>Distress</option>-->
<!---->
<!--                                              </select>-->
<!--                                            </th>-->

                                            <th>
                                              <strong>
                                                <a id="last_change_" href="<?php $query['orderby'] = 'last_change';$newget = http_build_query($query);echo URL; ?>?<?php echo $newget; ?>">Last Change</a>
                                              </strong>
                                              </br>
                                              <input  autocomplete="off"  type="text"value="<?=(isset($_GET['last_change'])?$_GET['last_change']:'')?>"  name="last_change" />
                                            </th>
                                            <!-- <th><strong>Country</strong></th> -->
                                            <th><strong>Source</strong></br>
                                              <select data-placeholder=" "  class="cho" multiple name="source[]" id="source">
                                                  <!-- <option value='%'>All</option> -->
                                                  <!-- <option value='%'>&nbsp;</option> -->
                                                   <!-- | <?php //echo $this->model->countBy($assigned_to,$status,$source);?> -->
                                                  <?php
                                                      $output='';
                                                      foreach ($sources as $source1) {
                                                          $output.='<option value="'.$source1->source.'" >'.$source1->source.' | '.$this->model->countBy($assigned_to,$status,$source1->source).'</option>';
                                                      }
                                                      echo $output;
                                                  ?>
                                              </select>
                                            </th>
                                            <th><strong><a id="date_created_" href="<?php
                                                $query['orderby'] = 'date_created';
                                                $newget = http_build_query($query);
                                                echo URL; ?>?<?php echo $newget; ?>
                                              ">Registered</a></strong>
                                              </br>
                                              <input type="text" autocomplete="off" value="<?=(isset($_GET['date_created'])?$_GET['date_created']:'')?>" name="date_created" />
                                            </th>
                                            <th><strong>Assigned To</strong></br>
                                              <select data-placeholder=" "  class="cho" multiple name="assigned_to[]" id="assigned_to">
                                                  <!-- <option value='%'>All</option> -->
                                                  <!-- <option value='%'>&nbsp;</option> -->
                                                   <!-- | <?php //echo $this->model->countBy($assigned_to,$status,$source);?> -->
                                                  <?php
                                                      $output='';
                                                      foreach ($operators as $operator) {
                                                          $output.='<option value="'.$operator->user_id.'" >'.$operator->first_name.' '.$operator->last_name.' | '.$this->model->countBy($operator->user_id,$status,$source).'</option>';//
                                                      }
                                                      echo $output;
                                                  ?>
                                              </select>
                                            </th>

<!--
//                                                      foreach ($assigned_froms as $asfroms) {
//
//                                                          $output.='<option value="'.$asfroms->assigned_from.'" >'.$asfroms->assigned_from.'</option>';//' | '.$this->model->countBy($operator->user_id,$status,$source,$asfroms->assigned_from).
//                                                      }
//                                                      echo $output;
//                                                  ?>
<!--                                              </select>-->
<!--                                            </th>-->
<!--                                            <th><strong>Level</strong></br>-->
<!--                                              <select data-placeholder=" "  class="cho" multiple name="level[]" id="level">-->
<!--                                                <option>High</option>-->
<!--                                                <option>Mid</option>-->
<!--                                                <option>Low</option>-->
<!--                                              </select>-->
<!--                                            </th>-->

                                        </thead>
                                        </form>
                                        <tbody>
                                            <?php
                                               $output='';

                                                foreach ($leads as $lead) {
                                                  //echo $this->model->getLastTasksAdmin($lead->lead_id);
                                                    $output.='<td><input class="check" type="checkbox" data-id="'.$lead->lead_id.'"></input></td>';
                                                    $output.='<td><a href="'.URL.$_SESSION['role'].'/viewLead/'.$lead->lead_id.'">'.$lead->first_name.' '.$lead->last_name.'</a></td>';
                                                    $output.='<td>'.$lead->phone_number.'</td>';
                                                    $output.='<td>'.$lead->email.'</td>';
                                                    $output.='<td>'.$lead->status_name.'</td>';
                                                    $output.='<td>'.$lead->status_description.'</td>';
//                                                    $output.='<td>'.$lead->mental.'</td>';

                                                    $output.='<td>'.date('d-m-Y   H:i',strtotime($lead->last_change)).'</td>';
                                                    // $output.='<td>'.$lead->country_by_ip.'</td>';
                                                    $output.='<td>'.$lead->source.'</td>';

                                                    $output.='<td>'.date('d-m-Y   H:i',strtotime($lead->date_created)).'</td>';

                                                    $operator='';
                                                    foreach($operators as $operator) {
                                                        if ($lead->assigned_to == $operator->user_id) {
                                                            $operator1 = $operator;
                                                            break;
                                                        }else {
                                                          unset($operator1);
                                                        }
                                                    }
                                                    if (isset($operator1)) {
                                                        $output.='<td>'.$operator1->first_name.' '.$operator1->last_name.'</td>';
                                                    } else {
                                                        $output.= '<td></td>';
                                                    }
//
//                                                    if ($lead->lasttask!='') {
//                                                      $output.='<td class="tolt" title="'.date('d-m-Y   H:i',strtotime($lead->lasttask)).'"><a href="'.URL.$_SESSION['role'].'/viewLead/'.$lead->lead_id.'#tasks_"><i class="material-icons">calendar_today</i></a>'.date('d-m-Y   H:i',strtotime($lead->lasttask)).'</td>';
//                                                    }else{
//                                                      $output.='<td></td>';
//                                                    }

//                                                    $output.='<td>'.$lead->assigned_from.'</td>';
//                                                    $output.='<td>'.$lead->level.'</td>';

                                                    $output.='</tr>';
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
                
                
                    var box = $(".box-inner"), x;


                    var hovered = false;
                    var loop = window.setInterval(function () {
                        if (hovered) {
                            // ...
                        }
                    }, 250);

                    var clicks=0;

                    var scrollSize=450;
                    var windowWidth=$( "table" ).width();
                    var maxClicks=Math.floor(windowWidth/scrollSize);
                    console.log('wwidth: ', windowWidth, 'scrolls: ', scrollSize, 'maxClicks: ',maxClicks);
                    $(".arrow").click(


                        function() {
                            if ($(this).hasClass("arrow-right")) {
                                if (clicks<maxClicks){
                                    clicks=clicks+1;
                                }
                                else{
                                    $('#arrowRight').css('display','none');
                                }

                                if ($(this).scrollLeft){
                                    $('#arrowLeft').css('display','inline-block');
                                }
                                console.log(clicks);

                                x = ((box.width()));
                                // console.log('im right');
                                box.animate({scrollLeft: scrollSize*clicks}
                            )
                            } else {
                                if (clicks>=1){
                                    clicks=clicks-1;
                                    $('#arrowRight').css('display','inline-block');

                                }
                                if (clicks===0){
                                    $('#arrowLeft').css('display','none');
                                }
                                // clicks=clicks-1;

                                // console.log('im left');
                                x = ((box.width()));
                                box.animate({
                                    scrollLeft: scrollSize*clicks,
                                }
                                    )
                            }
                        }
                    )

                
                var allselected=false;
                var countleads=<?=$countleads;?>;
                <?php
                if (isset($_GET['status'])) {
                    if (is_array($_GET['status'])) {
                      if ($_GET['status'][0]!='%') {
                        $status_ids=array();
                        foreach ($_GET['status'] as $value) {
                          array_push($status_ids,$value);
                        }
                        $status_ids1=implode(',', array_map('intval', $status_ids));
                        $status_ids1="[".$status_ids1."]";
                        //echo "var status_ids1=".$status_ids1.";";
                      }else{
                        $status_ids1="'%'";
                        //echo "var status_ids1='%';";
                      }
                    }else{
                      $status_ids1="'%'";
                      //echo "var status_ids1='%';";
                    }
                }else{
                  $status_ids1="'%'";
                  //echo "var status_ids1='%';";
                }
                
                if(isset($_GET['page'])){
                ?>
                    console.log('filter active');
                    $('.filter_data').css('display','block');
                    <?php
                }


//                if (isset($_GET['level'])) {
//                    if (is_array($_GET['level'])) {
//                      if ($_GET['level'][0]!='%') {
//                        $level_ids=array();
//                        foreach ($_GET['level'] as $value) {
//                          array_push($level_ids,$value);
//                        }
//                        $level_ids1=implode("','",$level_ids);
//                        $level_ids1="['".$level_ids1."']";
//                        //echo "var level_ids1=".$level_ids1.";";
//                      }else{
//                        $level_ids1="'%'";
//                        //echo "var level_ids1='%';";
//                      }
//                    }else{
//                      $level_ids1="'%'";
//                      //echo "var level_ids1='%';";
//                    }
//                }else{
//                  $level_ids1="'%'";
//                  //echo "var assigned_to_ids1='%';";
//                }

//                if (isset($_GET['mental'])) {
//                    if (is_array($_GET['mental'])) {
//                      if ($_GET['mental'][0]!='%') {
//                        $mental_ids=array();
//                        foreach ($_GET['mental'] as $value) {
//                          array_push($mental_ids,$value);
//                        }
//                        $mental_ids1=implode("','",$mental_ids);
//                        $mental_ids1="['".$mental_ids1."']";
//                        //echo "var mental_ids1=".$mental_ids1.";";
//                      }else{
//                        $mental_ids1="'%'";
//                        //echo "var mental_ids1='%';";
//                      }
//                    }else{
//                      $mental_ids1="'%'";
//                      //echo "var mental_ids1='%';";
//                    }
//                }else{
//                  $mental_ids1="'%'";
//                  //echo "var assigned_to_ids1='%';";
//                }

                if (isset($_GET['assigned_to'])) {
                    if (is_array($_GET['assigned_to'])) {
                      if ($_GET['assigned_to'][0]!='%') {
                        $assigned_to_ids=array();
                        foreach ($_GET['assigned_to'] as $value) {
                          array_push($assigned_to_ids,$value);
                        }
                        $assigned_to_ids1=implode(',', array_map('intval', $assigned_to_ids));
                        $assigned_to_ids1="[".$assigned_to_ids1."]";
                        //echo "var assigned_to_ids1=".$assigned_to_ids1.";";
                      }else{
                        $assigned_to_ids1="'%'";
                        //echo "var assigned_to_ids1='%';";
                      }
                    }else{
                      $assigned_to_ids1="'%'";
                      //echo "var assigned_to_ids1='%';";
                    }
                }else{
                  $assigned_to_ids1="'%'";
                  //echo "var assigned_to_ids1='%';";
                }

                if (isset($_GET['source'])) {
                    if (is_array($_GET['source'])) {
                      if ($_GET['source'][0]!='%') {
                        $source_ids=array();
                        foreach ($_GET['source'] as $value) {
                          array_push($source_ids,$value);
                        }
                        $source_ids1=implode("','",$source_ids);
                        $source_ids1="['".$source_ids1."']";
                        //echo "var source_ids1=".$source_ids1.";";
                      }else{
                        $source_ids1="'%'";
                        //echo "var source_ids1='%';";
                      }
                    }else{
                      $source_ids1="'%'";
                      //echo "var source_ids1='%';";
                    }
                }else{
                  $source_ids1="'%'";
                  //echo "var assigned_to_ids1='%';";
                }

//                if (isset($_GET['assigned_from'])) {
//                    if (is_array($_GET['assigned_from'])) {
//                      if ($_GET['assigned_from'][0]!='%') {
//                        $assigned_from_ids=array();
//                        foreach ($_GET['assigned_from'] as $value) {
//                          array_push($assigned_from_ids,$value);
//                        }
//                        $assigned_from_ids1=implode("','",$assigned_from_ids);
//                        $assigned_from_ids1="['".$assigned_from_ids1."']";
//                        //echo "var assigned_from_ids1=".$assigned_from_ids1.";";
//                      }else{
//                        $assigned_from_ids1="'%'";
//                        //echo "var assigned_from_ids1='%';";
//                      }
//                    }else{
//                      $assigned_from_ids1="'%'";
//                      //echo "var assigned_from_ids1='%';";
//                    }
//                }else{
//                  $assigned_from_ids1="'%'";
//                  //echo "var assigned_to_ids1='%';";
//                }

                  if (!isset($_GET['orderby'])) {
                    echo "var orderby='first_name';";
                  }else{
                    echo "var orderby='".$_GET['orderby']."';";
                  }
                 ?>
                  $("#"+orderby+"_").append('&nbsp;'+orderdir_);
                $(function() {
                  $('.reset_btn').on('click',function() {
                    document.location.href="<?=URL.$_SESSION['role'].'/leads';?>";
                  });
                  <?php
                  if (isset($_SESSION['deleted'])) {?>
                    $.notify({
                      icon: "done",
                      message: "Leads Deleted"
                    },{
                      type: 'succes',
                      timer: 300,
                      placement: {
                        from: 'top',
                        align: 'right'
                      }
                    });
                  <?php
                  unset($_SESSION['deleted']);
                }

                  if (isset($_SESSION['assigned_to'])) {?>
                    $.notify({
                      icon: "done",
                      message: "Leads Assigned"
                    },{
                      type: 'succes',
                      timer: 300,
                      placement: {
                        from: 'top',
                        align: 'right'
                      }
                    });
                  <?php
                  unset($_SESSION['assigned_to']);
                }
                  if (isset($_SESSION['lead_exist'])) {
                    if ($_SESSION['lead_exist']=='true') { ?> //if fail
                      $.notify({
                        icon: "error_outline",
                        message: "Lead exist!"
                      },{
                        type: 'danger',
                        timer: 300,
                        placement: {
                          from: 'top',
                          align: 'right'
                        }
                      });
                      <?php }
                      unset($_SESSION['lead_exist']);
                    }
                    if (isset($_SESSION['create_lead'])) {
                      if ($_SESSION['create_lead']=='fail') { ?> //if fail
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
                        unset($_SESSION['create_lead']);
                      }
                      ?>
                      $('.leadsNav').addClass('active');
                      var search_='<?=(isset($_GET['search_'])?$_GET['search_']:'')?>';

                      var assigned_to=<?=$assigned_to_ids1;?>;
                      $('#assigned_to').val(assigned_to).trigger("chosen:updated");
                      //
                      //var mental=<?//=$mental_ids1;?>//;
                      //$('#mental').val(mental).trigger("chosen:updated");

                      var status=<?=$status_ids1;?>;
                      $('#status').val(status).trigger("chosen:updated");

                      var source=<?=$source_ids1;?>;
                      $('#source').val(source).trigger("chosen:updated");
                      //
                      //var level=<?//=$level_ids1;?>//;
                      //$('#level').val(level).trigger("chosen:updated");

                      //var assigned_from=<?//=$assigned_from_ids1;?>//;
                      //$('#assigned_from').val(assigned_from).trigger("chosen:updated");

                      if ($('[name=search_]').val()!="" || $page>0) {
                        $('.filter_data').show();
                      }

                      $('.page-item').on('click',function(e) {//.pagination_btn
                        e.preventDefault();
                        if ($('[name=search_]').val()!=search_) {
                          $('.page_val').val(0);
                        }
                        document.forms[0].submit();
                      });
                      $(".submit_btn" ).on('click',function(e) {
                        e.preventDefault();
                        $('.page_val').val(0);
                        document.forms[0].submit();
                      });
                    });

                    function bulkDelete(){
                        if (allselected) {
                          $.ajax({
                              'type': "POST",
                              // 'dataType': 'json',
                              'url': window.location,
                              'data': {'all_selected':'true','action':'delete'},
                              'success': function (data) {
                        			console.log(data);
                              }
                          });
                          location.reload();
                          return;
                        }
                        var ids = [];
                        $('.check').each(function () {
                          if($(this).is(':checked'))
                            ids.push($(this).data('id'));
                        });
                        if(ids){
                          ids = JSON.stringify(ids);

                        $.ajax({
                            'type': "POST",
                            'dataType': 'json',
                            'url': '<?=URL;?>api/bulk/delete',
                            'data': {'ids':encodeURIComponent(ids)},
                            'success': function (data) {
                      			console.log(data);
                            }
                        });
                        location.reload();
                      }
                    }
                    function bulkEdit(){
                        var ids = [];

                        f=$('.bulkeditform').serialize();

                        if (allselected) {
                          fa=f+'&all_selected=true&action=edit';

                          $.ajax({
                              'type': "POST",
                              // 'dataType': 'json',
                              'url': window.location,
                              'data': fa,
                              'success': function (data) {
                        			console.log(data);
                              }
                          });
                          location.reload();
                          return;
                        }
                        $('.check').each(function () {
                          if($(this).is(':checked'))
                            ids.push($(this).data('id'));
                        });
                        if(ids){
                          ids = JSON.stringify(ids);
                          fb=f+'&ids='+encodeURIComponent(ids);

                        $.ajax({
                            'type': "POST",
                            'dataType': 'json',
                            'url': '<?=URL;?>api/bulk/edit',
                            'data': fb,
                            'success': function (data) {
                      			console.log(data);

                            }
                        });
                        location.reload();
                      }
                    }

                    function bulkAssignTo(v){
                        var ids = [];
                        var operator=v;
                        if (v=='') {
                          return;
                        }
                        if (allselected) {
                          $.ajax({
                              'type': "POST",
                              // 'dataType': 'json',
                              'url': window.location,
                              'data': {'all_selected':'true','action':'assign_to','operator':operator},
                              'success': function (data) {
                        			console.log(data);
                              }
                          });
                          location.reload();
                          return;
                        }
                        $('.check').each(function () {
                          if($(this).is(':checked'))
                            ids.push($(this).data('id'));
                        });
                        if(ids){
                          ids = JSON.stringify(ids);

                        $.ajax({
                            'type': "POST",
                            'dataType': 'json',
                            'url': '<?=URL;?>api/bulk/assign_to',
                            'data': {'ids':encodeURIComponent(ids),'operator':operator},
                            'success': function (data) {
                      			console.log(data);

                            }
                        });
                        location.reload();
                      }
                    }

                    function checkAll(source) {
                      checkboxes = $('.check');
                      for(var i=0, n=checkboxes.length;i<n;i++) {
                        checkboxes[i].checked = source.checked;
                        //show_buttons();
                      }
                    }

                    $('.check').on('click', function(){
                      if ($('.check:checked').length>0) {
                        $('.dlttxt').html('Remove '+$('.check:checked').length);
                        $('.h_buttons').show();
                      }else{
                        $('.h_buttons').hide();
                        $('.check_all').prop("checked",false);
                      }
                    });
                    $('.check_all').on('click', function(){
                      if ($('.check:checked').length>0) {
                        $('.dlttxt').html('Remove '+$('.check:checked').length);
                        $('.h_buttons').show();
                        $('#selectallbtn').show();
                        console.log("all selected");
                      }else{
                        $('.h_buttons').hide();
                        $('#selectallbtn').hide();
                        allselected=false;
                        console.log("none selected");
                      }
                    });
                    function editBtnClick(){
                      $('#bulkEditModal').modal();
                    }
                    function deleteBtnClick() {
                        swal({
                          title: 'Are you sure?',
                          text: "You won't be able to revert this!",
                          type: 'warning',
                          showCancelButton: true,
                          cancelButtonColor: '#00bcd4',
                          confirmButtonColor: '#f44336',
                          confirmButtonText: 'Remove'
                        }).then((result) => {
                          if (result.value) {
                              bulkDelete();
                          }
                        })
                    }
                    $( ".sbtn" ).click(function() {
                      $('.filter_data').toggle(300);
                        // if($('.filter_data:visible').length)
                        //     $('.filter_data').hide("slide", { direction: "right" }, 1000);
                        // else
                        //     $('.filter_data').show("slide", { direction: "right" }, 1000);
                    });

                    //function editMental(lead_id,mental){
                    //    swal({
                    //      title: 'Are you sure?',
                    //      text: "",
                    //      type: 'warning',
                    //      showCancelButton: true,
                    //      cancelButtonColor: '#777',
                    //      confirmButtonColor: '#00bcd4',
                    //      confirmButtonText: 'Change'
                    //    }).then((result) => {
                    //      if (result.value) {
                    //        $.ajax({
                    //            url: '<?//=URL?>//api/editMental/',
                    //            type: 'POST',
                    //            data: {lead_id:lead_id,
                    //                   mental:mental,
                    //                  },
                    //          })
                    //          .done(function(data) {
                    //            console.log("success");
                    //          })
                    //          .fail(function(err) {
                    //            console.log(err);
                    //          });
                    //      }else{
                    //        console.log(lead_id);
                    //        $($('.sss'+lead_id)).val($('.oldmental'+lead_id).val());
                    //      }
                    //    })
                    //}

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
                    $('.tolt').tooltip({
                        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'
                    });

                    function exportLeads() {
                      $('#exportLeadsModal').modal();
                        //window.location.href+='&export=true';
                    }

                    <?php if (!isset($_GET['date_created'])): ?>
                      $('input[name="date_created"]').daterangepicker({
                          startDate: '01-01-1970', // after open picker you'll see this dates as picked
                          endDate: new Date(),
                          locale: {
                              format: 'DD-MM-YYYY',
                              cancelLabel: 'Clear'
                          },
                          autoUpdateInput: false,
                          ranges: {
                              'Today': [moment(), moment()],
                              'This Week': [moment().startOf('week'), moment()],
                              'This Month': [moment().startOf('month'), moment().endOf('month')],
                              'All Time': ['01-01-1970',moment()]
                          }
                        });
                        $('input[name="date_created"]').on('apply.daterangepicker', function(ev, picker) {
                          $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                      });

                      $('input[name="date_created"]').on('cancel.daterangepicker', function(ev, picker) {
                          $(this).val('');
                      });
                    <?php elseif($_GET['date_created']==''): ?>
                        $('input[name="date_created"]').daterangepicker({
                            startDate: '01-01-1970', // after open picker you'll see this dates as picked
                            endDate: new Date(),
                            locale: {
                                format: 'DD-MM-YYYY',
                                cancelLabel: 'Clear'
                            },
                            autoUpdateInput: false,
                            ranges: {
                                'Today': [moment(), moment()],
                                'This Week': [moment().startOf('week'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'All Time': ['01-01-1970',moment()]
                            }
                          });
                          $('input[name="date_created"]').on('apply.daterangepicker', function(ev, picker) {
                            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                        });

                        $('input[name="date_created"]').on('cancel.daterangepicker', function(ev, picker) {
                            $(this).val('');
                        });
                    <?php else: ?>
                        $('input[name="date_created"]').daterangepicker({
                          locale: {
                             format: 'DD-MM-YYYY',
                          },
                          autoUpdateInput: true,
                          ranges: {
                              'Today': [moment(), moment()],
                              'This Week': [moment().startOf('week'), moment()],
                              'This Month': [moment().startOf('month'), moment().endOf('month')],
                              'All Time': ['01-01-1970',moment()]
                          }
                        });
                    <?php endif; ?>
                    <?php if (!isset($_GET['last_change'])): ?>
                        $('input[name="last_change"]').daterangepicker({
                            startDate: '01-01-1970', // after open picker you'll see this dates as picked
                            endDate: new Date(),
                            locale: {
                                format: 'DD-MM-YYYY',
                                cancelLabel: 'Clear'
                            },
                            autoUpdateInput: false,
                            ranges: {
                                'Today': [moment(), moment()],
                                'This Week': [moment().startOf('week'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'All Time': ['01-01-1970',moment()]
                            }
                          });
                          $('input[name="last_change"]').on('apply.daterangepicker', function(ev, picker) {
                            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                        });

                        $('input[name="last_change"]').on('cancel.daterangepicker', function(ev, picker) {
                            $(this).val('');
                        });
                    <?php elseif($_GET['last_change']==''): ?>
                        $('input[name="last_change"]').daterangepicker({
                            startDate: '01-01-1970', // after open picker you'll see this dates as picked
                            endDate: new Date(),
                            locale: {
                                format: 'DD-MM-YYYY',
                                cancelLabel: 'Clear'
                            },
                            autoUpdateInput: false,
                            ranges: {
                                'Today': [moment(), moment()],
                                'This Week': [moment().startOf('week'), moment()],
                                'This Month': [moment().startOf('month'), moment().endOf('month')],
                                'All Time': ['01-01-1970',moment()]
                            }
                          });
                          $('input[name="last_change"]').on('apply.daterangepicker', function(ev, picker) {
                            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                        });

                        $('input[name="last_change"]').on('cancel.daterangepicker', function(ev, picker) {
                            $(this).val('');
                        });
                    <?php else: ?>
                        $('input[name="last_change"]').daterangepicker({
                          locale: {
                             format: 'DD-MM-YYYY',
                          },
                          autoUpdateInput: true,
                          ranges: {
                              'Today': [moment(), moment()],
                              'This Week': [moment().startOf('week'), moment()],
                              'This Month': [moment().startOf('month'), moment().endOf('month')],
                              'All Time': ['01-01-1970',moment()]
                          }
                        });
                    <?php endif; ?>
<!--                    --><?php //if (!isset($_GET['lasttask'])): ?>
//                        $('input[name="lasttask"]').daterangepicker({
//                            startDate: '01-01-1970', // after open picker you'll see this dates as picked
//                            endDate: new Date(),
//                            locale: {
//                                format: 'DD-MM-YYYY',
//                                cancelLabel: 'Clear'
//                            },
//                            autoUpdateInput: false,
//                            ranges: {
//                                'Today': [moment(), moment()],
//                                'This Week': [moment().startOf('week'), moment()],
//                                'This Month': [moment().startOf('month'), moment().endOf('month')],
//                                'All Time': ['01-01-1970',moment()]
//                            }
//                          });
//                          $('input[name="lasttask"]').on('apply.daterangepicker', function(ev, picker) {
//                            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
//                        });
//
//                        $('input[name="lasttask"]').on('cancel.daterangepicker', function(ev, picker) {
//                            $(this).val('');
//                        });
//                    <?php //elseif($_GET['lasttask']==''): ?>
//                        $('input[name="lasttask"]').daterangepicker({
//                            startDate: '01-01-1970', // after open picker you'll see this dates as picked
//                            endDate: new Date(),
//                            locale: {
//                                format: 'DD-MM-YYYY',
//                                cancelLabel: 'Clear'
//                            },
//                            autoUpdateInput: false,
//                            ranges: {
//                                'Today': [moment(), moment()],
//                                'This Week': [moment().startOf('week'), moment()],
//                                'This Month': [moment().startOf('month'), moment().endOf('month')],
//                                'All Time': ['01-01-1970',moment()]
//                            }
//                          });
//                          $('input[name="lasttask"]').on('apply.daterangepicker', function(ev, picker) {
//                            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
//                        });
//
//                        $('input[name="lasttask"]').on('cancel.daterangepicker', function(ev, picker) {
//                            $(this).val('');
//                        });
//                    <?php //else: ?>
//                        $('input[name="lasttask"]').daterangepicker({
//                          locale: {
//                             format: 'DD-MM-YYYY',
//                          },
//                          autoUpdateInput: true,
//                          ranges: {
//                              'Today': [moment(), moment()],
//                              'This Week': [moment().startOf('week'), moment()],
//                              'This Month': [moment().startOf('month'), moment().endOf('month')],
//                              'All Time': ['01-01-1970',moment()]
//                          }
//                        });
//                    <?php //endif; ?>

                    $('.showtotalplbtn').on('click',function(event) {
                      event.preventDefault();
                        $('.showtotalpl').show();
                    })

                    $('.showtotalplbtn').blur(function(){
                       $('.showtotalpl').hide();
                    });

                    $('').click(function(){

                    });
                    $(document).ready(function() {

                      $('.bulkeditsubmit').on('click',function(event) {
                        event.preventDefault();
                        bulkEdit();
                      })


                      $('#select-all-fields').change(function() {
                          if($(this).is(":checked")) {
                              $('#export_fields option').prop('selected', true);
                          }else{
                              $('#export_fields option').prop('selected', false); // Selects all options
                          }
                          $('#export_fields').trigger("chosen:updated");
                      });

                      $('#select-all-assigned_to').change(function() {
                          if($(this).is(":checked")) {
                              $('#assigned_toe option').prop('selected', true);
                          }else{
                              $('#assigned_toe option').prop('selected', false); // Selects all options
                          }
                          $('#assigned_toe').trigger("chosen:updated");
                      });

                      $('#select-all-status').change(function() {
                        console.log("test");
                          if($(this).is(":checked")) {
                              $('#statuse option').prop('selected', true);
                          }else{
                              $('#statuse option').prop('selected', false); // Selects all options
                          }
                          $('#statuse').trigger("chosen:updated");
                      });

                      $('#select-all-source').change(function() {
                          if($(this).is(":checked")) {
                              $('#sourcee option').prop('selected', true);
                          }else{
                              $('#sourcee option').prop('selected', false); // Selects all options
                          }
                          $('#sourcee').trigger("chosen:updated");
                      });


                      $('#export_fields_chosen > ul >li >a').on('click',function(event) {
                        document.getElementById("select-all-fields").checked=false;
                      })
                    });

                  </script>
                  <style media="screen">
                  .daterangepicker{
                    color: black !important;
                  }
                  .large.tooltip-inner {
                      /* width: 350px; */
                      height: 80px;
                      font-size: large;
                    }
                    #status_chosen{
                      /* width:100% !important; */
                      color:black !important;
                    }
                    #assigned_to_chosen{
                      /* width:100% !important; */
                      color:black !important;
                    }
                    #source_chosen{
                      /* width:100% !important; */
                      color:black !important;
                    }
                    #export_fields_chosen{
                      width:100% !important;
                      color:black !important;
                    }

                    #assigned_toe_chosen{
                      width:100% !important;
                      color:black !important;
                    }
                    #sourcee_chosen{
                      width:100% !important;
                      color:black !important;
                    }
                    #statuse_chosen{
                      width:100% !important;
                      color:black !important;
                    }

                      /* .showtotalpl{
                        display: none;
                      }
                    .showtotalpl:hover,.showtotalplbtn:hover~.showtotalpl{
                        display: block;
                      } */
                    </style>
                  <div id="exportLeadsModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <!-- Modal content-->
                      <div class="modal-content" style="height:500px">
                        <div class="modal-body">
                          <form class="" action="" method="post">
                            <div class="col-sm-12">
                               <div class="form-group">
                                    <input style="color:black" type="checkbox" name="" id="select-all-fields" value="">
                                    <label class="control-label">General</label>
                                    <select class="cho" multiple name="export_fields[]" id="export_fields">
                                      <option value="full_name">Full Name</option>
                                      <option value="phone_number">Phone Number</option>
                                      <option value="alt_number">Alt Number</option>
                                      <option value="email">Email</option>
                                      <!-- <option value="status">Status</option> -->
                                      <!-- <option value="assigned_to">Assigned To</option> -->
                                      <option value="date_created">Registerd</option>
                                      <option value="brand">Brand</option>
                                      <!-- <option value="source">Source</option> -->
                                      <option value="data_sheets">Data Sheets</option>
                                      <option value="note">Note</option>
                                      <option value="last_change">Last Change</option>
                                    </select>

                                    <input style="color:black" type="checkbox" name="" id="select-all-assigned_to" value="">
                                    <label class="control-label">Assigned To</label>
                                    <select data-placeholder=" "  class="cho" multiple name="assigned_to[]" id="assigned_toe">
                                        <?php
                                            $output='';
                                            foreach ($operators as $operator) {
                                                $output.='<option value="'.$operator->user_id.'" >'.$operator->first_name.' '.$operator->last_name.'</option>';
                                            }
                                            echo $output;
                                        ?>
                                    </select>

                                    <input style="color:black" type="checkbox" name="" id="select-all-source" value="">
                                    <label class="control-label">Source</label>
                                    <select data-placeholder=" "  class="cho" multiple name="source[]" id="sourcee">
                                        <?php
                                            $output='';
                                            foreach ($sources as $source1) {
                                                $output.='<option value="'.$source1->source.'" >'.$source1->source.'</option>';
                                            }
                                            echo $output;
                                        ?>
                                    </select>

                                    <input style="color:black" type="checkbox" name="" id="select-all-status" value="">
                                    <label class="control-label">Status</label>
                                    <select data-placeholder=" " class="cho" multiple name="status[]" id="statuse">
                                        <?php
                                            $output='';
                                            foreach ($statuses as $status1) {
                                                $output.='<option value="'.$status1->status_id.'" >'.$status1->status_name.'</option>';
                                            }
                                            echo $output;
                                        ?>
                                    </select>



                               </div>
                            </div>
                            <input type="hidden" name="export" value="true">
                            <button type="submit" class="btn btn-submit pull-right" name="submit">Submit</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div id="bulkEditModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <!-- Modal content-->
                      <div class="modal-content" >
                        <div class="modal-body">
                          <div class="row ">
                            <form class="bulkeditform" action="index.html" method="post">
                              <div class="col-sm-6">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label">Status</label>
                                    <select class="form-control"  name="status0" id="status">
                                      <option value=""></option>
                                       <?php
                                            $output='';
                                            foreach ($statuses as $status) {
                                                $output.='<option value="'.$status->status_id.'" >'.$status->status_name.'</option>';
                                            }
                                            echo $output;
                                            ?>
                                    </select>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group label-floating is-focused">
                                    <label class="control-label">Assigned To</label>
                                    <select class=" form-control"  name="assigned_to0" id="assigned_to">
                                      <option value=""></option>
                                      <option value="0">None</option>
                                       <?php
                                            $output='';
                                            foreach ($operators as $operator) {
                                                $output.='<option value="'.$operator->user_id.'" >'.$operator->first_name.' '.$operator->last_name.'</option>';
                                            }
                                            echo $output;
                                            ?>
                                    </select>
                                </div>
                              </div>

                              <div class="col-sm-6">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Brand</label>
                                      <input type="text"   name="brand0" class="form-control">
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Source</label>
                                      <input type="text" list="source0" autocomplete="on"  name="source0"  class="form-control">
                                      <datalist id="source0">
                                        <option value=""></option>
                                        <?php
                                            $output='';
                                            foreach ($sources as $source1) {
                                                $output.='<option value="'.$source1->source.'" >'.$source1->source.'</option>';
                                            }
                                            echo $output;
                                        ?>
                                      </datalist>
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Note</label>
                                      <input type="text"  name="note0"   value="" class="form-control">
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Data Sheets</label>
                                      <textarea type="text" name="data_sheets0"  rows="4" class="form-control"></textarea>
                                  </div>
                              </div>
                              <div class="col-sm-3">
                                  <div class="form-group label-floating">
                                      <label class="control-label">Limit</label>
                                      <input type="number" value=""  name="limit" class="form-control">
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-submit pull-right bulkeditsubmit" name="submit">Submit</button>
                            </from>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
