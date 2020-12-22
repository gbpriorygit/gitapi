<title>Create Lead</title>
<div class="content">
    <div class="container-fluid">
        <div class="row">
        <form method="POST" enctype="multipart/form-data" id="form" >
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Lead Details</h4>
                    </div>
                    <div class="card-content">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">First Name</label>
                                    <input type="text" autocomplete="off" required  name="first_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                  <label class="control-label">Last name</label>
                                    <input type="text" autocomplete="off" required  name="last_name" class="form-control">
                                </div>
                            </div>

                             <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" autocomplete="off" required  name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Phone Number</label>
                                    <input type="text" autocomplete="off" required name="phone_number" value="" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="create_lead">
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-sm-12">
                <div class="card">
                     <div class="card-content">
                        <div class="col-sm-12">
                            <input type="hidden" name="create_contract" value="true">
                            <a href="../"  style="color: black;border: 1px solid black" class="btn btn-white pull-left">Cancel</a>
                            <button type="submit" class="submit-btn btn btn-info pull-right">Create</button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

          </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(window).ready(function(){
  $('#form').on('submit',function(e){
      if (!validate()) {
          e.preventDefault();
      };
  });

  $('.createLeadNav').addClass('active');

  function validate(){
    var valid=true;
    // if (typeof($('[name="phone_number"]').val())!='undefined') {
    //   var a=Number($('[name="phone_number"]').val());
    //   if ($('[name="phone_number"]').val().length< 10 || $('[name="phone_number"]').val().length>13 || !a) {
    //     $.notify({
    //       icon: "done",
    //       message: "Invalid phone number!"
    //     },{
    //       type: 'danger',
    //       timer: 300,
    //       placement: {
    //         from: 'top',
    //         align: 'right'
    //       }
    //     });
    //     $('[name="phone_number"]').focus();
    //     valid=false;
    //   };
    // };
    return valid;
  }

  $("input[type='text']").keyup(function () {
    this.value=this.value.replace("\n"," ");
    this.value=this.value.replace("\'","");
    this.value=this.value.replace("\"","");
  });
});
</script>
