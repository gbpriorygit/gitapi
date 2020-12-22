<title>Documents</title>
<div class="content" style="margin-top: 30px;">
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
              <div class="card">
                  <div class="card-header" data-background-color="blue">
                      <h4 class="title">
                              Documents
                      </h4>
                  </div>
                  <div class="card-content">
                      <div class="row" id="docs">
                          <div class="card-content table-responsive">
                              <table class="table table-hover">
                                <?php
                                  $documents=$this->model->getDocuments($_SESSION['user_id']);
                                  $output='';
                                  foreach ($documents as $doc) {
                                    $docname=explode("/",$doc->url);
                                    //print_r(count($docname));
                                    $output.="<tr><td><a target='_blank' href=".URL."api/getDocument/".$doc->document_id.">".$docname[count($docname)-1]."</a></td></tr>";
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
    </div>
</div>
