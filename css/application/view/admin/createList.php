<title>Create List</title>
            <div class="content" style="margin-top: 20px;">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="blue">
                                    <h4 class="title">New List</h4>
                                </div>
                                <div class="card-content">
                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">List Name</label>
                                                    <input type="text" name="list_name" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">List Source</label>
                                                    <input type="text" name="source" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">Description</label>
                                                    <input type="text" name="list_description" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="create_list">
                                        <button type="submit" class="btn btn-info pull-right">Create List</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $('.listsNav').addClass('animationbtn');
            </script>
