<?php
    include_once("config.php");

    require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;

    $storage = (new Factory())
    ->withServiceAccount('jsonkeys/ethincelegance-firebase-adminsdk-jfli6-ab8269909a.json')
    ->withDefaultStorageBucket('ethincelegance.appspot.com')
    ->createStorage();

    $bucket = $storage->getBucket();
    $datalistCat = $database->getReference('Project/category')->getSnapshot()->getValue();
    
    if(isset($_REQUEST['btnsub']))
    {
      $scname=$_REQUEST['scname'];
      $catid=$_REQUEST['catid'];
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
      ->getReference('Project/subcategory')
      ->push([
        'catid' => $catid,
        'subcat' => $scname,
        'photo' =>$photo,
      ])->getKey();
      header("location:subshow.php");
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
                                    <input class="form-control" type="text" name="scname" placeholder="Enter SubCategory Name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category Name</label>
                                <div class="col-sm-10">
                                        <select name="catid" class="form-control" >
                                            <option>select option </option>
                                            <?php 
                                                foreach($datalistCat as $key=>$row)
                                                {
                                            ?>                                
                                                <option value='<?php echo $key;?>'><?php echo $row['name'];?> </option>                            
                                            <?php
                                            }
                                            ?>
                                        </select>
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
                                                    <input class="form-control" type="file" required onchange="previewImage(event)" name="f1" >
                                                    <img id="preview" src="Images\NoImage.jpg">
                                                </div>
                            </div>                
                            <div class="form-group row">        
                                <div class="col-sm-10 ml-sm-auto mt-5">
                                    <input class="btn btn-info" type="submit" name="btnsub" value="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>


<?php
    include_once("footer.php");
?>