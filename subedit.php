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
    $url="Project/subcategory/$id";
    $record=$database->getReference($url)->getSnapshot()->getValue();
    print_r($record);
    $file1=$record['photo'];
    $path="https://firebasestorage.googleapis.com/v0/b/ethincelegance.appspot.com/o/$file1?alt=media";
    
}

if (isset($_POST['edit']))
{
   
    $scname=$_POST['scname'];
    $photo=$_FILES['f1']['name'];

    if ($_FILES['f1']['name'] != "") {
        $datalist1 = $database->getReference($url)->getSnapshot()->getValue();
        $existingFile = $bucket->object($datalist1['photo']);
        if ($existingFile->exists()) {
            $existingFile->delete();
        } 
        $database->getReference($url)->update(
            [
                'subcat' => $scname,
                'photo' =>$photo,
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
                'subcat' => $scname,
                'photo' => $file1
            ]
        );
    }
    
         
    // echo $record;
    header("Location:subshow.php");

}
include_once("header.php");

?>

        <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Insert SubCategory</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">SubCategory Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text"  name="scname" value="<?php echo trim($record['subcat']) ?>" required>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label class="col-sm-2 col-form-label">SubCategory Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="scname" required>
                                </div>
                            </div>
                             -->
                            <script type="text/javascript">
                                function previewImage(event) {
                                    var input = event.target;
                                    var image = document.getElementById('preview');
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();
                                        reader.onload = function(e) {
                                        image.src = e.target.result;
                                        }
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                            </script>
                            <style>
                                #preview {
                                    width: 200px;
                                    height: 140px;
                                }
                            </style>
                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">File To Upload</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="file" onchange="previewImage(event)" name="f1" >
                                                    <img id="preview" src="<?php echo $path ?>">
                                                </div>
                            </div>                
                            <div class="form-group row">        
                                <div class="col-sm-10 ml-sm-auto mt-5">
                                    <input class="btn btn-info" type="submit" name="edit" value="Edit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>


<?php
    include_once("footer.php");
?>