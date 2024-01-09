<?php

require_once("config.php");
require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;

    $storage = (new Factory())
    ->withServiceAccount('jsonkeys/ethincelegance-firebase-adminsdk-jfli6-ab8269909a.json')
    ->withDefaultStorageBucket('ethincelegance.appspot.com')
    ->createStorage();
    
    $bucket = $storage->getBucket();
if (isset($_REQUEST['id']))
{
    $id=$_REQUEST['id'];
    echo $id;
    $url="Project/category/$id";
    $record=$database->getReference($url)->getSnapshot()->getValue();
    print_r($record);
    $file1=$record['photo'];
    $path="https://firebasestorage.googleapis.com/v0/b/ethincelegance.appspot.com/o/$file1?alt=media";
    
}

if (isset($_POST['edit']))
{
   
    $cname=$_POST['cname'];
    $ctype=$_POST['ctype'];
    $cdes=$_POST['cdes'];
    $photo=$_FILES['f1']['name'];

    if ($_FILES['f1']['name'] != "") {
        $datalist1 = $database->getReference($url)->getSnapshot()->getValue();
        $existingFile = $bucket->object($datalist1['photo']);
        if ($existingFile->exists()) {
            $existingFile->delete();
        } 
        $database->getReference($url)->update(
            [
                'name' => $cname,
                'type' =>  $ctype,
                'description' =>  $cdes,
                'photo' => $photo,
            ]
        );
        if($_FILES['f1']['name']){
            $bucket->upload(
                file_get_contents($_FILES['f1']['tmp_name']),
                [
                'name' =>$_FILES['f1']['name']
                ]
            );
          
          }      
    }
    else{
        $database->getReference($url)->update(
            [
                'name' => $cname,
                'type' =>  $ctype,
                'description' =>  $cdes,
                'photo' => $file1
            ]
        );
    }
    
         
    // echo $record;
    header("Location:catshow.php");

}

require_once("header.php");
?>

<br/>        

<div class="ibox">            
            <div class="ibox-head">
                        <div class="ibox-title">Edit Category</div>
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
                                            <input class="form-control" type="text" name="cname" id="cname" placeholder="Enter Category Name" value="<?php echo trim($record['name']) ?>">
                                        </div>
                    </div>
                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Type</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="ctype" id="ctype" placeholder="Enter Type" value="<?php echo trim($record['type']) ?>">
                                        </div>
                    </div>
                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Description</label>
                                        <div class="col-sm-10">
                                            <textarea cols="20" rows="10" class="form-control" name="cdes" id="cdes"><?php echo trim($record['description']) ?></textarea>        
                                        </div>
                    </div>
                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">File To Upload</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="file"  name="f1" id="f1">

                                            <img src='<?php echo $path;?>' width=100px height=100px /></td>
                                         </div>
                    </div>  
                    <div class="form-group row">
                                        <div class="col-sm-10 ml-sm-auto mt-5">
                                            <input class="btn btn-info" type="submit" name="edit" value="Edit">
                                        </div>
                    </div>
                </form>
            </div>
                        <!-- </div>
                    </div>
                </div>
            </div>
        </div> -->
</div>
<?php
    include_once("footer.php");
?>