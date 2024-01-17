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
    $path="CategoryImage/$file1";
    $object = $bucket->object($path);
    $expirationDate = new \DateTimeImmutable('2030-01-01T00:00:00Z');
    $downloadUrl = $object->signedUrl($expirationDate);

    // $path="https://firebasestorage.googleapis.com/v0/b/ethincelegance.appspot.com/o/$file1?alt=media";
    
}

if (isset($_POST['edit']))
{
   
    $cname=$_POST['name'];
    $gen=$_POST['gen'];
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
                'gender' =>  $gen,
                'photo' => $photo,
            ]
        );
        if($_FILES['f1']['name']){
            $bucket->upload(
                file_get_contents($_FILES['f1']['tmp_name']),
                [
                'name' =>"CategoryImage/".$_FILES['f1']['name']
                ]
            );
          
          }      
    }
    else{
        $database->getReference($url)->update(
            [
                'name' => $cname,
                'gender' =>  $gen,
                'photo' => $file1
            ]
        );
    }
    
         
    // echo $record;
    header("Location:catshow.php");

}

require_once("header.php");
?>

<br>
        <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit Category</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="name" value="<?php echo trim($record['name']) ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2">Gender</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="col-sm-3 from-check-input" type="radio" name="gen" id="Men" value="Men" <?php if ($record['gender']=="Men") { ?>checked<?php } ?>>
                                    <label for="Male" class="">Men</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="col-sm-2 from-check-input" type="radio" name="gen" id="Women" value="Women" <?php if ($record['gender']=="Women") { ?>checked<?php } ?>>
                                    <label for="Female" class="">Women</label>
                                </div>
                            </div>
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
                                                    <input class="form-control" type="file" onchange="previewImage(event)" name="f1" id="f1">
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