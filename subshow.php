<?php
 require_once("config.php");
 if (isset($_REQUEST['id']))
 {
     $id=$_REQUEST['id'];
     $url="Project/subcategory/$id";
     $record=$database->getReference($url)->remove();
     header("location:subshow.php");
 }

 $datalistSubcat = $database->getReference('Project/subcategory')->getSnapshot()->getValue();

    include_once("header.php");
?>
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">DataTables</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="la la-home font-20"></i></a>
                    </li>
                    <!-- <li class="breadcrumb-item">DataTables</li> -->
                </ol>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Sub Category</div>
                        <a class="btn btn-info" href="subadd.php"><i class="fa fa-plus fa-lg"></i> Add</a>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>IMAGES</th>
                                    <th>SUB CATEGORY NAME</th>
                                    <th>CATEGORY</th>
                                    <th>OPERATIONS</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>IMAGES</th>
                                    <th>SUB CATEGORY NAME</th>
                                    <th>CATEGORY</th>
                                    <th>OPERATIONS</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    foreach($datalistSubcat as $key=>$row){
                                        $file1=$row['photo'];
                                        $path="https://firebasestorage.googleapis.com/v0/b/ethincelegance.appspot.com/o/$file1?alt=media";
                                
                                ?>
                                    <tr>
                                        <td><img class='img-circle' src='<?php echo $path;?>' width=60px height=60px /></td>
                                        <td><?= $row['subcat']; ?></td>
                                        <?php 
                                        $id=$row['catid'];
                                        $datalistCat = $database->getReference("Project/category/$id")->getSnapshot()->getValue();
                                        ?>
                                        <td><?= $datalistCat['name'] ?></td>
                                        <td>
                                        <a class="edit" href="subedit.php?id=<?php echo $key?>" ><i class="fa fa-pencil fa-fw" style="color:#243c64;"></i></a>
                                        <a class="delete" href="subshow.php?id=<?php echo $key?>" onclick="return confirm('Are you sure you want to delete <?=$row['subcat'];?>');"><i class="fa fa-trash" style="color:#243c64;"></i></a>  
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                        
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div>
                    <a class="adminca-banner" href="http://admincast.com/adminca/" target="_blank">
                        <div class="adminca-banner-ribbon"><i class="fa fa-trophy mr-2"></i>PREMIUM TEMPLATE</div>
                        <div class="wrap-1">
                            <div class="wrap-2">
                                <div>
                                    <img src="./assets/img/adminca-banner/adminca-preview.jpg" style="height:160px;margin-top:50px;" />
                                </div>
                                <div class="color-white" style="margin-left:40px;">
                                    <h1 class="font-bold">ADMINCA</h1>
                                    <p class="font-16">Save your time, choose the best</p>
                                    <ul class="list-unstyled">
                                        <li class="m-b-5"><i class="ti-check m-r-5"></i>High Quality Design</li>
                                        <li class="m-b-5"><i class="ti-check m-r-5"></i>Fully Customizable and Easy Code</li>
                                        <li class="m-b-5"><i class="ti-check m-r-5"></i>Bootstrap 4 and Angular 5+</li>
                                        <li class="m-b-5"><i class="ti-check m-r-5"></i>Best Build Tools: Gulp, SaSS, Pug...</li>
                                        <li><i class="ti-check m-r-5"></i>More layouts, pages, components</li>
                                    </ul>
                                </div>
                            </div>
                            <div style="flex:1;">
                                <div class="d-flex justify-content-end wrap-3">
                                    <div class="adminca-banner-b m-r-20">
                                        <img src="./assets/img/adminca-banner/bootstrap.png" style="width:40px;margin-right:10px;" />Bootstrap v4</div>
                                    <div class="adminca-banner-b m-r-10">
                                        <img src="./assets/img/adminca-banner/angular.png" style="width:35px;margin-right:10px;" />Angular v5+</div>
                                </div>
                                <div class="dev-img">
                                    <img src="./assets/img/adminca-banner/sprite.png" />
                                </div>
                            </div>
                        </div>
                    </a>
                </div> -->
            </div>
            <!-- END PAGE CONTENT-->
            <!-- <footer class="page-footer">
                <div class="font-13">2018 © <b>AdminCAST</b> - All rights reserved.</div>
                <a class="px-4" href="http://themeforest.net/item/adminca-responsive-bootstrap-4-3-angular-4-admin-dashboard-template/20912589" target="_blank">BUY PREMIUM</a>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer> -->
<?php
    include_once("footer.php");
?>