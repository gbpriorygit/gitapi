<title>CV</title>
<div class="content" style="margin-top: 30px;">
    <div class="container-fluid">
    <div class="row">


        <?php if ($this->model->hasCV()): ?>
          <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">
                                CV
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="row" id="cv">
                            <div class="card-content table-responsive">
                                <table class="table table-hover">
                                  <iframe src="<?=URL.'api/getCV/' ?>" width="100%" height="700px"></iframe>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <?php else: ?>
          <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">
                                Upload CV
                        </h4>
                    </div>
                    <div class="card-content">
                        <div class="row" id="cv">
                            <form action="<?=URL?>operator/uploadCV" enctype="multipart/form-data" method="POST" class="col-sm-12 dz-parent">
                                <div id="zdrop" class="fileuploader">
                                    <div id="upload-label" >
                                        <span class="title">
                                          <input  accept="application/pdf" name="cv" type="file" />
                                        </span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info pull-right">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

      </div>
    </div>
</div>
