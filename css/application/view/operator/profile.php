<title>My Profile</title>


<div class="content" style="margin-top: 30px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title"></h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-content table-responsive">
                        <div class="row">
                            <div class="col-md-3 ml-auto mr-auto text-center"></div>
                            <div class="col-md-6 ml-auto mr-auto text-center">
                                <ul style="max-width: fit-content;" class="max-width: fit-content; card nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
<!--                                    <li class="nav-item">-->
<!--                                          <a class="nav-link" target="_blank" href="https://web.skype.com" role="tablist">-->
<!--                                              Skype-->
<!--                                          </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="https://web.whatsapp.com" role="tablist">-->
<!--                                            WhatsApp-->
<!--                                        </a>-->
<!--                                    </li>-->
                                     <?php
                                     $output='';
                                     if ($show_fop == 1) {
                                     $output='<li class="nav-item"><a class="nav-link" target="_blank" href="http://'.SIP_SERVER.'/fop2/?exten='.$_SESSION["user_sip"].'&pass='.$_SESSION["user_sip"].'" role="tablist">FOP2</a></li><li class="nav-item"><a class="nav-link" target="_blank" href="http://'.SIP_SERVER.'/fop2/calldetailrecords.php?exten='.$_SESSION["user_sip"].'&pass='.$_SESSION["user_sip"].'&dbgrid_page=1&dbgrid_action=search" role="tablist">CDR</a></li>';
                                  }
                                     echo $output;
//                                     echo $pwd->password;
                                     ?>

                                    <li class="nav-item">
                                        <a class="nav-link" target="_blank"  href="<?=URL?>/operator/links/documents" role="tablist">
                                            DOC
                                        </a>
                                    </li>
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="--><?//=URL?><!--/operator/links/social" role="tablist">-->
<!--                                            Social Media Company-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="--><?//=URL?><!--/operator/links/formation" role="tablist">-->
<!--                                            Formation-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="#" role="tablist">-->
<!--                                            Signal & Analisys-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="#" role="tablist">-->
<!--                                            Customer-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="--><?//=URL?><!--/operator/links/partners" role="tablist">-->
<!--                                            Partners-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="--><?//=URL?><!--/operator/links/website" role="tablist">-->
<!--                                            Website-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="--><?//=URL?><!--/operator/links/forum" role="tablist">-->
<!--                                            Forum-->
<!--                                        </a>-->
<!--                                    </li>-->
                                    <li class="nav-item">
                                        <a class="nav-link" target="_blank" href="<?=URL?>/operator/links/cv" role="tablist">
                                            CV
                                        </a>
                                    </li>
<!--                                    <li class="nav-item">-->
<!--                                        <a class="nav-link" target="_blank" href="--><?//=URL?><!--/operator/links/companycontact" role="tablist">-->
<!--                                            Company Contact-->
<!--                                        </a>-->
<!--                                    </li>-->
                                </ul>
                            </div>
                            <div class="col-md-3 ml-auto mr-auto text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Listen</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-content table-responsive">
                      <iframe src="http://<?=SIP_SERVER;?>/fop2/?exten=<?=$_SESSION['user_sip'];?>&pass=<?=$_SESSION['user_sip'];?>" width="100%" height="500px"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">CDR</h4>
                        <p class="category"></p>
                    </div>
                    <div class="card-content table-responsive">
                      <iframe src="http://<?=SIP_SERVER;?>/fop2/calldetailrecords.php?exten=<?=$_SESSION['user_sip'];?>&pass=<?=$_SESSION['user_sip'];?>&dbgrid_page=1&dbgrid_action=search" width="100%" height="500px"></iframe>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
</div>
