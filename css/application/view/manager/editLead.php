<title>Edit: <?php echo $lead->first_name." ".$lead->last_name;  ?></title>
<style>

body{ background-image: linear-gradient(rgba(0,0,0,0.1) , rgba(0,0,0,0.2) ), url("../../assets/img/ferrari1-min.jpg");
	background-repeat: no-repeat;
	background-size: cover;
background-position: right;}
</style>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                    <form method="POST" action="">
                        <div class="col-sm-12">
                            <div class="card ">
                                <div class="card-header" data-background-color="blue">
                                    <h4 class="title">Lead Details</h4>
                                </div>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">First Name</label>
                                                <input type="text" name="first_name" value="<?=$lead->first_name;?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                              <label class="control-label">Last name</label>
                                                <input type="text" name="last_name"  value="<?=$lead->last_name;?>" class="form-control">
                                            </div>
                                        </div>

                                         <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Email</label>
                                                <input type="text"  name="email"  value="<?=$lead->email;?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Phone Number</label>
                                                <input type="text" name="phone_number"  value="<?=$lead->phone_number;?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Alt Number</label>
                                                <input type="text" name="alt_number"  value="<?=$lead->alt_number;?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Note</label>
                                                <input type="text"  name="note"  value="<?=$lead->note;?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Data Sheets</label>
                                                <textarea type="text" name="data_sheets"  rows="4"  class="form-control"><?=$lead->data_sheets;?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group label-floating is-focused">
                                              <label class="control-label">Status</label>
                                              <select class="cho form-control"  name="status" id="status">
                                                 <?php
                                                      $output='';
                                                      foreach ($statuses as $status) {
                                                          if ($lead->status==$status->status_id) {
                                                              $output.='<option selected="" value="'.$status->status_id.'" >'.$status->status_name.'</option>';
                                                          }else{
                                                              $output.='<option value="'.$status->status_id.'" >'.$status->status_name.'</option>';
                                                          }
                                                      }
                                                      echo $output;
                                                      ?>
                                              </select>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Registered</label>
                                                <input type="text" disabled name="date_created"  id="date_created" value="<?=date('d-m-Y   h:m:i',strtotime($lead->date_created))?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Brand</label>
                                                <input type="text"   name="brand"  value="<?=$lead->brand;?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Source</label>
                                                <input type="text" list="source" autocomplete="on"  name="source" value="<?=$lead->source;?>" class="form-control">
                                                <datalist id="source">
                                                  <option value="Vtiger">
                                                  <option value="Vicidial">
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Webform</label>
                                                <input type="text" name="webform" value="<?=$lead->webform;?>" class="form-control">

                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Assigned To</label>
                                                <input type="text"    value="<?=$lead->assigned_to;?>" class="form-control">
                                            </div>
                                        </div> -->
                                        <div class="col-sm-6">
                                          <div class="form-group label-floating is-focused">
                                              <label class="control-label">Assigned To</label>
                                              <select class="cho form-control"  name="assigned_to" id="assigned_to">
                                                <option value="0">None</option>
                                                 <?php
                                                      $output='';
                                                      foreach ($operators as $operator) {
                                                          if ($lead->assigned_to==$operator->user_id) {
                                                              $output.='<option selected="" value="'.$operator->user_id.'" >'.$operator->first_name.' '.$operator->last_name.'</option>';
                                                          }else{
                                                              $output.='<option value="'.$operator->user_id.'" >'.$operator->first_name.' '.$operator->last_name.'</option>';
                                                          }
                                                      }
                                                      echo $output;
                                                      ?>
                                              </select>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card ">
                                <div class="card-content">
                                  <div class="row">
                                    <div class="col-sm-12">
                                        <a href="../viewLead/<?=$lead->lead_id;?>" class="btn btn-info pull-left">Cancel</a>
                                        <input type="hidden" name="edit_lead">
                                        <!-- <a onclick="deleteLead(<?=$lead->lead_id;?>)" class="btn btn-danger pull-left">Delete</a> -->
                                        <button type="submit" class="submit-btn btn btn-warning  pull-right">Update</button>
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


<script type="text/javascript">
  $('.leadsNav').addClass('active');
</script>
