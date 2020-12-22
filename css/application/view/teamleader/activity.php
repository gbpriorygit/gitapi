<title>Activity</title>
<style>
    body{
        background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.2)),  url("<?php echo URL; ?>assets/img/chess.jpg");
        background-position:top;
    }
</style>
<div class="content" style="margin-top: 30px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header row" data-background-color="blue">
                      <div class="col-md-12">
                        <div class="logo">
                          <center>
                            <img style="width: 238px;margin-bottom: -45px;" src="<?php echo URL; ?>assets/img/logo_any12.png">
                          </center>
                            </div>
                          <h4 class="title">Changelog</h4>
                       </div>

                      <div class="container-fluid">
                          <div class="row">
                              <form action="" method="GET" id="main_form">
                                  <ul class="card nav nav-pills nav-pills-warning nav-pills-icons justify-content-center filter_data" role="tablist" style="display:">
                                    <center>
                                      <h1 style= "margin:0;padding:0;font-size: 18px; color:whitesmoke;">	ONE WORLD ONE COIN</h1>
                                    </center>
                                      <div class="row" style="margin-left:5px;margin-right:5px">
                                          <div class="col-md-3">
                                             <div class="form-group label-floating ">
                                                 <label class="control-label">User</label>
                                                 <select class="form-control" name="user" id="user">
                                                     <option value='%'>All </option>
                                                     <?php
                                                         $output='';
                                                         foreach ($operators as $operator) {
                                                             $output.='<option value="'.$operator->user_id.'" >'.$operator->first_name.' '.$operator->last_name.'</option>';
                                                         }
                                                         echo $output;
                                                     ?>
                                                 </select>
                                             <span class="material-input"></span></div>
                                         </div>
                                         <div class="col-md-3">
                                            <div class="form-group label-floating ">
                                                <label class="control-label">Lead</label>
                                                <select class="form-control" name="lead" id="lead">
                                                    <option value='%'>All</option>
                                                </select>
                                            <span class="material-input"></span></div>
                                        </div>
                                          <input class="page_val" id="page_val" type="hidden" name="page" value='<?php echo (isset($_GET['page'])?$_GET['page']:0)?>'>
                                          <div class="col-md-3">
                                            <div style="padding-top: 12px;">
                                                <input type="submit" name="" value="Search" class="btn btn-info submit_btn">
                                                <a href="#" class="btn reset_btn">Reset</a>
                                            <span class="material-input"></span></div>
                                          </div>
                                          <div class="col-md-3">
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
                                                            <span aria-hidden="true">&laquo;</span>
                                                            <span class="sr-only">Precedente</span>
                                                          </a>
                                                        </li>
                                                        <li class="page-item"><a class="page-link" onclick="$('.page_val').val($page-1)"><?=$page-1+1;?></a></li>
                                                    <?php } ?>
                                                    <li class="page-item active"><a class="page-link" onclick="$('.page_val').val($page)"><?=$page+1 ;?></a></li>
                                                    <?php if ($page<$pages-1) { ?>
                                                        <li class="page-item"><a class="page-link" onclick="$('.page_val').val($page+1)"><?=$page+1+1;?></a></li>
                                                        <li class="page-item">
                                                          <a class="page-link" onclick="$('.page_val').val($page+1)" aria-label="Successivo">
                                                            <span aria-hidden="true">&raquo;</span>
                                                            <span class="sr-only"></span>
                                                          </a>
                                                        </li>
                                                    <?php } ?>
                                                  </ul>
                                                  <!-- Total: <?=($pages==0?1:$pages-1);?> -->
                                            </div>
                                          </center>
                                          </div>
                                      </div>
                                  </ul>
                              </form>
                            </div>
                          </div>
                  </div>
                    <div class="card-content taskc scrollable">
                      <table style="color:black !important;" class="table table-striped table-bordered table-responsive">
                        <?php
                          $output='<thead><td>Date</td><td>User</td><td>Lead</td><td>Changes</td></thead>';
                          foreach ($activity as $log) {

                                  $useri= $this->model->getUser($log['user_id']);
                                  $leadi= $this->model->getLeadById($log['lead_id']);
                                  if (!isset($leadi->lead_id)) {
                                    continue;
                                  }
                                  $useri=$useri->first_name." ".$useri->last_name;
                                  $output.="<tr>";
                                      $output.="<td>".$log['date']."</td><td><a href='".URL.$_SESSION['role']."/leads/?assigned_to=".$log['user_id']."'>".$useri."</a></td>";
                                      $output.="<td><a href='".URL.$_SESSION['role']."/viewLead/".$leadi->lead_id."'>".$leadi->first_name." ".$leadi->last_name."</a></td>";
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
    </div>
</div>
<script type="text/javascript">
  $('.activityNav').addClass('active');

  var user='<?=(isset($_GET['user'])?$_GET['user']:'%')?>';
  $('[name=user]').val(user);
  var lead='<?=(isset($_GET['lead'])?$_GET['lead']:'%')?>';
  $('[name=lead]').val(lead);

  if ( $('[name=user]').val()!="%" || $('[name=lead]').val()!="%" || $page>0) {
    $('.filter_data').show();
  }

  $('.page-item').on('click',function(e) {//.pagination_btn
    e.preventDefault();
    if ( $('[name=user]').val()!=user ||  $('[name=lead]').val()!=lead) {
      $('.page_val').val(0);
    }
    document.forms[0].submit();
  });
  $(".submit_btn" ).on('click',function(e) {
    e.preventDefault();
    $('.page_val').val(0);
    document.forms[0].submit();
  });

  $('.reset_btn').on('click',function() {
    document.location.href="<?=URL.$_SESSION['role'].'/activity';?>";
  });
</script>

<style media="screen">
.chosen-container-single .chosen-single >span {
  color: black !important;
}
  /* .chosen-container-single .chosen-single {
  background: none !important;
  border-radius: 0px !important;
  border: 1px solid #ccc;
  box-shadow: none;
  } */

  /* .chosen-container .chosen-drop {
  border-color: #ccc;
  box-shadow: none;
  }

  .chosen-container-active.chosen-with-drop .chosen-single {
  background-image:none;
  border: 1px solid #ccc;
  box-shadow: none; */
  }
</style>
<script type="text/javascript">
  function chosenAjax(id) {
  if (this === window) {
    return new chosenAjax(id);
  } else {
    this.e = document.querySelector(id);
  }
  return this;
  }

  chosenAjax.prototype.dropdownRemoteSearch = function (param) {
  var loading = false;
  //    console.log(param);
  var self = this;
  self.inputid = this.e.id;
  var select = document.getElementById(self.inputid);
  var url, valueField, textField, concatValueAndText, defaultSelectedBlank, enableJsonData;
  if (param) {
    url = param.url;
    valueField = param.valueField;
    textField = param.textField;
    concatValueAndText = param.concatValueAndText;
    enableJsonData = param.enableJsonData;
    defaultSelectedBlank = param.defaultSelectedBlank;
  } else {
    console.log("dropdown error not found param!!!");
  }

  var delayID=null;
  $('#' + self.inputid + '_chosen input').on('keyup',function (e) {
    if (e.keyCode==13) {
      return;
    }
    if(delayID==null){
      delayID=setTimeout(function(){
        var txtsearch=$('#' + self.inputid + '_chosen input').val();
        if (txtsearch.length < 2) {
          return;
        }
        if (window.datasearch) {
          if (window.datasearch.indexsearch == $('#' + self.inputid + '_chosen input').val()) {
            return;
          }
        }
        if (loading == true) {
          return;
        }
        $.ajax({
          url: url,
          data: {q:txtsearch},
          method: "GET",
          dataType: "json",
          crossDomain : true,
          beforeSend: function (request) {
            //request.setRequestHeader("Access-Control-Allow-Origin", "*");
            $('ul.chosen-results').empty();
            $("#" + self.inputid).empty();
            var opt = document.createElement('option');
            opt.value = "";
            select.appendChild(opt);
          }
        }).done(function (data) {
          loading = false;
          $.each(data, function (key, val) {
            var opt = document.createElement('option');
            opt.value = val[valueField];
            if (concatValueAndText) {
              opt.innerHTML = val[valueField] + " : " + val[textField];
            } else {
              opt.innerHTML = val[textField];
            }
            if (enableJsonData) {
              opt.setAttribute("json", JSON.stringify(data[key]));
            }
            select.appendChild(opt);
          });
          var datasearch = {};
          datasearch.indexsearch = $('#' + self.inputid + '_chosen input').val();
          window.datasearch = datasearch;
          var txt = $('#' + self.inputid + '_chosen input').val();
          $('#' + self.inputid).trigger("chosen:updated");
          $('#' + self.inputid + '_chosen .chosen-search input').val(txt);
          $('#' + self.inputid + '_chosen input').trigger("keyup");
        }).fail(function () {
          loading = false;
        });
        delayID=null;
      },500);
    }else{
      if(delayID){
        clearTimeout(delayID);
        delayID=setTimeout(function(){
          var txtsearch=$('#' + self.inputid + '_chosen input').val();
          if (txtsearch.length < 2) {
            return;
          }
          if (window.datasearch) {
            if (window.datasearch.indexsearch == $('#' + self.inputid + '_chosen input').val()) {
              return;
            }
          }
          if (loading == true) {
            return;
          }
          $.ajax({
            url: url,
            data: {q:txtsearch},
            method: "GET",
            dataType : "json",
            beforeSend: function () {
              $('ul.chosen-results').empty();
              $("#" + self.inputid).empty();
              var opt = document.createElement('option');
              opt.value = "";
              select.appendChild(opt);
            }
          }).done(function (data) {
            loading = false;
            $.each(data, function (key, val) {
              var opt = document.createElement('option');
              opt.value = val[valueField];
              if (concatValueAndText) {
                opt.innerHTML = val[valueField] + " : " + val[textField];
              } else {
                opt.innerHTML = val[textField];
              }
              if (enableJsonData) {
                opt.setAttribute("json", JSON.stringify(data[key]));
              }
              select.appendChild(opt);
            });
            var datasearch = {};
            datasearch.indexsearch = $('#' + self.inputid + '_chosen input').val();
            window.datasearch = datasearch;
            var txt = $('#' + self.inputid + '_chosen input').val();
            $('#' + self.inputid).trigger("chosen:updated");
            $('#' + self.inputid + '_chosen .chosen-search input').val(txt);
            $('#' + self.inputid + '_chosen input').trigger("keyup");
          }).fail(function () {
            loading = false;
          });
          delayID=null;
        },500);
      }
    }
  });
  return this;
  };

  <?php if (isset($_GET['lead'])){
      if ($_GET['lead']!='' && $_GET['lead']!='%') {
        $l=$this->model->getLeadById($_GET['lead']);
     ?>
        $("#lead").html("<option value='<?=$l->lead_id;?>' ><?=$l->first_name." ".$l->last_name;?></option><option value='%'>All</option>");
     <?php }else{ ?>
       $("#lead").html("<option value='%'>All</option>");
  <?php   } ?>

  <?php }else {?>
    $("#lead").html("<option value='%'>All</option>");
  <?php } ?>

  $("#lead").chosen({search_contains: true});
  chosenAjax("#lead").dropdownRemoteSearch({
  url: "<?=URL?>api/getLeadsChosen",
  valueField: "id",
  textField: "text",
  concatValueAndText: false,
  callBack: function () {
  }
  });
  $("#user").chosen();
</script>
