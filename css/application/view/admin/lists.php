<title>Lists</title>
<style>
    body{
        background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.1)),  url("<?php echo URL; ?>assets/img/bg_1.jpg");
        background-position:bottom;
    }
    .card{background: #00000052!important;}
    .card-header{text-align: center;background: linear-gradient(to top, #0f0c29, #0a2048, #24243e)!important;}
    .card-header h4 {font-size:22px;margin-bottom:0!important; margin: auto;}
    .create_button{background: linear-gradient(to left, #9cafd4, #072b73)!important;transition: .5s all;}
    .create_button:hover{background: linear-gradient(to right, #9cafd4, #072b73)!important;}
    .delete_button{background: linear-gradient(to right, #e4c5c9, #93291e)!important;transition: .5s all;}
    .delete_button:hover{background: linear-gradient(to left, #e4c5c9, #93291e)!important;}
    .nav-pills>li>a:hover{background: transparent!important}
    .listLeads{
        display:none;
    }
    .listRecycle{
        display:none;
    }
</style>
<div class="content" style="margin-top: 20px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 ml-auto mr-auto text-center"></div>
            <div class="col-md-6 ml-auto mr-auto text-center">
                <ul style="max-width: fit-content;margin:auto;margin-bottom:7rem;" class="navButtons nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                    <li class="nav-item  navBtnShadow navBtnLeft">
                        <a class="nav-link animationbtn1 pageButtons" href="createList" role="tablist">
                            <i class="material-icons">add</i>
                            New List
                        </a>
                    </li>
                    <li class="nav-item navBtnShadow">
                        <a class="nav-link animationbtn1 pageButtons" href="<?=URL.$_SESSION['role'].'/createLead';?>" role="tablist">
                            <i class="material-icons">add</i>
                            New Lead
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3 ml-auto mr-auto text-center"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex;" data-background-color="blue">
                        <h4 style="margin-top: 4px;" class="title">Lists</h4>
                        <a onclick="backButtonClick()" class="backButton btn btn-primary" style="display:none; margin-left: 10px;background: rgba(123,9,0,0.75); padding:5px 15px">Back <i class="fa fa-arrow-left"></i></a>
                    </div>
                    <div class="card-content table-responsive">
                        <table class="table table-lists">
                            <thead >
                            <th>List Name</th>
                            <th class="listField">Source</th>
                            <th class="listField">Description</th>
                            <th class="listField">Count</th>
                            <th class="listCount leadsToggle"  onclick="toggleLeads()" ><a class="btn btn-primary" style="margin: 0;background: #0c7b0cbf !important;padding: 5px 12px;">Leads Count <i class="fa fa-arrow-right"></i></a></th>
                            <th class="listCount listLeads">R-New</th>
                            <th class="listCount listLeads">Low</th>
                            <th class="listCount listLeads">Mid</th>
                            <th class="listCount listLeads">High</th>
                            <th class="listCount listLeads">Stock</th>
                            <th class="listCount listLeads">No Answer</th>
                            <th class="listCount listLeads">Inactive N.A</th>
                            <th class="listCount listLeads">FTD</th>
                            <th class="listCount listLeads">Existing</th>
                            <th class="listCount listLeads">Wrong Nr</th>
                            <th class="listCount listLeads">Inactive N.I</th>
                            <th class="listCount listLeads">Attempting</th>
                            <th class="listCount listLeads">Promo</th>
                            <th class="listCount recycleToggle"  onclick="toggleRecycle()" style="width: 15%"><a class="btn btn-primary"  style="margin: 0;background: rgba(123,9,0,0.75) !important;padding: 5px 12px;">Recycle <i class="fa fa-arrow-right"> </i></a></th>
                            <th class="listCount listRecycle">Wrong</th>
                            <th class="listCount listRecycle">Inactive N.A</th>
                            <th class="listCount listRecycle">Inactive N.I</th>

                            <th class="listField"><center>Action</center></th>
                            </thead>
                            <tbody>
                            <?php
                            $output='';
                            foreach ($lists as $list) {

                                $output.='<tr><td><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&email=&source%5B%5D='.$list->list_name.'&note=&last_change=&brand=&date_created=&lasttask=">'.$list->list_name.'</a>&nbsp;<i onclick="editListName('.$list->list_id.',\''.$list->list_name.'\')"  class="material-icons">edit</i></td>
                                                                <td class="listField">'.$list->source.'&nbsp;<i onclick="editListSource('.$list->list_id.',\''.$list->list_name.'\')"  class="material-icons">edit</i></td>
                                                                <td class="listField">'.$list->list_description.'</td>
                                                                <td class="listField">'.$this->model->countList($list->list_id).'</td>
                                                                <td class="listCount leadsToggle"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&email=&list_id='.$list->list_id.'&note=&last_change=&brand=&date_created=&lasttask=">'.$this->model->countListLeads($list->list_id).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=1&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 1).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=3&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 3).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=4&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 4).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=5&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 5).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=6&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 6).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=7&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 7).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=8&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 8).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=9&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 9).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=10&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 10).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=11&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 11).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=13&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 13).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=14&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 14).'</a></td>
                                                                <td class="listCount listLeads"><a href="'.URL.$_SESSION['role'].'/leads?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=15&note=&last_change=&date_created=">'.$this->model->countListBy(0, $list->list_id, 15).'</a></td>
                                                                <td class="listCount recycleToggle"><a href="'.URL.$_SESSION['role'].'/recycle?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&note=&last_change=&brand=&date_created=&lasttask=&assigned_from=">'.$this->model->countListRecycle($list->list_id).'</a></td>
                                                                <td class="listCount listRecycle"><a href="'.URL.$_SESSION['role'].'/recycle?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=11&note=&last_change=&brand=&date_created=&lasttask=&assigned_from=">'.$this->model->countListBy(1, $list->list_id, 11).'</a></td>
                                                                <td class="listCount listRecycle"><a href="'.URL.$_SESSION['role'].'/recycle?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=8&note=&last_change=&brand=&date_created=&lasttask=&assigned_from=">'.$this->model->countListBy(1, $list->list_id, 8).'</a></td>
                                                                <td class="listCount listRecycle"><a href="'.URL.$_SESSION['role'].'/recycle?search_=&page=0&full_name=&phone_number=&list_id='.$list->list_id.'&email=&status%5B%5D=13&note=&last_change=&brand=&date_created=&lasttask=&assigned_from=">'.$this->model->countListBy(1, $list->list_id, 13).'</a></td>';
                                $output.='<td class="listField"><center>
                                                                <a class="btn create_button btn-info" href="'.URL.$_SESSION['role'].'/uploadLeads/'.$list->list_id.'">Upload Leads</a>
                                                                <a onclick="deleteList('.$list->list_id.')" class="btn delete_button">Delete</a>
                                                                </center></td></tr>';
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
    $('.listsNav').addClass('animationbtn');
    <?php
    if (isset($_SESSION['edit_list'])) {
    if ($_SESSION['edit_list']=='success') { ?>//if edit success
    $.notify({
        icon: "done",
        message: "Changes saved!"
    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });

    <?php } elseif($_SESSION['edit_list']=='fail') { ?> //if fail
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
    unset($_SESSION['edit_list']);
    }

    if (isset($_SESSION['delete_list'])) {
    if ($_SESSION['delete_list']=='success') { ?>//if edit success
    $.notify({
        icon: "done",
        message: "List Deleted!"

    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });

    <?php } elseif($_SESSION['delete_list']=='fail') { ?> //if fail
    $.notify({
        icon: "error_outline",
        message: "List deletion failed!"
    },{
        type: 'danger',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
    <?php }
    unset($_SESSION['delete_list']);
    }

    if (isset($_SESSION['create_list'])) {
    if ($_SESSION['create_list']=='success') { ?>//if edit success
    $.notify({
        icon: "done",
        message: "New List created!"
    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });

    <?php } elseif($_SESSION['create_list']=='fail'){ ?> //if fail
    $.notify({
        icon: "error_outline",
        message: "List creation failed!"

    },{
        type: 'danger',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
    <?php }
    unset($_SESSION['create_list']);
    }
    if (isset($_SESSION['import_list'])) {
    if ($_SESSION['import_list']=='success') { ?>//if edit success
    $.notify({
        icon: "done",
        message: "List Imported!"
    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });

    <?php } elseif($_SESSION['import_list']=='fail'){ ?> //if fail
    $.notify({
        icon: "error_outline",
        message: "List import failed!"

    },{
        type: 'danger',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
    <?php }
    unset($_SESSION['import_list']);
    }

    if (isset($_SESSION['delete_list'])) {
    if ($_SESSION['delete_list']=='success') { ?>//if edit success
    $.notify({
        icon: "done",
        message: "List Deleted!"
    },{
        type: 'success',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
    <?php } elseif($_SESSION['delete_list']=='fail') { ?> //if fail
    $.notify({
        icon: "error_outline",
        message: "List deletion failed!"
    },{
        type: 'danger',
        timer: 300,
        placement: {
            from: 'top',
            align: 'right'
        }
    });
    <?php }
    unset($_SESSION['delete_list']);
    }
    ?>
    function deleteList(list_id) {
        swal({
            title:'Are you sure?',
            text: "All leads in this list will be deleted! ",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#00bcd4',
            confirmButtonColor: '#f44336',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.value) {
                window.location.href='?deleteList=true&list_id='+list_id;
            }
        })
    }

    function editListName(list_id,content){
        var inputValue =content;
        var {value: content1} =  Swal.fire({
            title: 'Rename List',
            input: 'text',
            inputValue: inputValue,
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write something!'
                }else{
                    $.ajax({
                        url: '<?=URL?>api/editListName/'+list_id,
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

    function editListSource(list_id,content){
        var inputValue =content;
        var {value: content1} =  Swal.fire({
            title: 'Rename Source',
            input: 'text',
            inputValue: inputValue,
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'You need to write something!'
                }else{
                    $.ajax({
                        url: '<?=URL?>api/editListSource/'+list_id,
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

    function toggleLeads() {

        // $("button").click(function(){
        $(".listLeads").toggle();
        $(".listField").toggle();
        $(".recycleToggle").toggle();
        $(".backButton").toggle();

        // });

        // var x = document.getElementsByClassName("listLeads");
        // if (x.style.display === "none") {
        //     x.style.display = "block";
        // } else {
        //     x.style.display = "none";
        // }
    }

    function toggleRecycle() {
        $(".listRecycle").toggle();
        $(".listField ").toggle();
        $(".leadsToggle").toggle();
        $(".backButton").toggle();
    }

    function backButtonClick() {
        $(".listRecycle").hide();
        $(".listField ").show();
        $(".leadsToggle").show();
        $(".recycleToggle").show();

        $(".listLeads").hide();
        $(".backButton").toggle();
    }

</script>
