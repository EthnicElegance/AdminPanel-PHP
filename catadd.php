<?php
    require_once("config.php");

    require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;

    $storage = (new Factory())
    ->withServiceAccount('jsonkeys/ethincelegance-firebase-adminsdk-jfli6-ab8269909a.json')
    ->withDefaultStorageBucket('ethincelegance.appspot.com')
    ->createStorage();

    $bucket = $storage->getBucket();
    if(isset($_REQUEST['btnsub']))
    {
      $des=$_REQUEST['cdes'];
      $type=$_REQUEST['ctype'];
      $name=$_REQUEST['cname'];
      $photo=$_FILES['f1']['name'];

      if($_FILES['f1']['name']){
        $bucket->upload(
            file_get_contents($_FILES['f1']['tmp_name']),
            [
            'name' =>$_FILES['f1']['name']
            ]
        );
      
      }

      $new = $database
      ->getReference('Project/category')
      ->push([
          'name' => $name,
          'type' => $type,
          'description' => $des,
          'photo' =>$photo,
      ])->getKey();
      header("location:catshow.php");
    }

    include_once("header.php");
?>

<!-- <div id="main">
            START PAGE CONTENT-->

            <!-- <div class="page-heading">
                <h1 class="page-title">Add Category</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="la la-home font-20"></i></a>
                    </li>
                    <li class="breadcrumb-item">Basic Form</li> -->
                <!-- </ol>
            </div>  -->
<br/>        

<div class="ibox">            
            <div class="ibox-head">
                        <div class="ibox-title">Add Category</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
            </div>
            <!-- <div class="page-content fade-in-up">
                <div class="row">
                <div class="col-md-6">
                        <div class="ibox"> -->
            <div class="ibox-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Category Name</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="cname" id="cname" placeholder="Enter Category Name">
                                        </div>
                    </div>
                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Type</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="ctype" id="ctype" placeholder="Enter Type">
                                        </div>
                    </div>
                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10">
                                            <textarea cols="20" rows="10" class="form-control" name="cdes" id="cdes"></textarea>        
                                        </div>
                    </div>
                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">File To Upload</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="file" name="f1" id="f1">
                                         </div>
                    </div>                
                                    <!-- <div class="form-group row">
                                        <div class="col-sm-10 ml-sm-auto">
                                            <label class="ui-checkbox ui-checkbox-gray">
                                                <input type="checkbox">
                                                <span class="input-span"></span>Remamber me</label>
                                        </div>
                                    </div> -->
                    <div class="form-group row">
                                        <div class="col-sm-10 ml-sm-auto mt-5">
                                            <input class="btn btn-info" type="submit" name="btnsub" value="submit">
                                        </div>
                    </div>
                </form>
            </div>
                        <!-- </div>
                    </div>
                </div>
            </div> -->
        <!-- </div> -->
    </div>

<?php
    include_once("footer.php");
?>