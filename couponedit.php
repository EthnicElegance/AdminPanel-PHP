<?php
    require_once("config.php");

    require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;

    $storage = (new Factory())
    ->withServiceAccount('jsonkeys/ethincelegance-firebase-adminsdk-jfli6-ab8269909a.json')
    ->withDefaultStorageBucket('ethincelegance.appspot.com')
    ->createStorage();

    $bucket = $storage->getBucket();

     if(isset($_REQUEST['id']))
     {
        $id=$_REQUEST['id'];
        echo $id;
        $url="Project/Coupon/$id";
        $record1=$database->getReference($url)->getSnapshot()->getValue();
        print_r($record1);
        $file1=$record1['photo'];
        $path="https://firebasestorage.googleapis.com/v0/b/ethincelegance.appspot.com/o/$file1?alt=media";

     }

     if (isset($_POST['edit']))
     {
        $couponname = $_REQUEST['couponname'];
        $coupdiscount=$_REQUEST['coupdiscount'];
        $exdatetime = $_REQUEST['exdatetime'];
        $amount = $_REQUEST['amount'];
        $photo=$_FILES['f1']['name'];

        if ($_FILES['f1']['name'] != "") 
        {
            $datalist1 = $database->getReference($url)->getSnapshot()->getValue();
            $existingFile = $bucket->object($datalist1['photo']);
            
            if ($existingFile->exists()) {
                $existingFile->delete();
            } 
            $database->getReference($url)->update(
                [  
                    'Coupon_name' => $couponname,  
                    'Coupon_discount' => $coupdiscount,
                    'Expire_DateTime' => $exdatetime,
                    'Amount' => $amount,
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
        else
        {
            $database->getReference($url)->update(
                [
                    'Coupon_name' => $couponname,  
                    'Coupon_discount' => $coupdiscount,
                    'Expire_DateTime' => $exdatetime,
                    'Amount' => $amount,
                    'photo' =>$file1
                ]
            );
        }    
        // echo $datalistSubcat;
        header("Location:couponshow.php");
     }

    include_once("header.php");
?>
<br>
        <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Insert Coupon</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Coupon Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="couponname" value="<?php echo trim($record1['Coupon_name']) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Coupon Discount</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="coupdiscount" value="<?php echo trim($record1['Coupon_discount']) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Expire_DateTime</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="date" name="exdatetime" value="<?php echo trim($record1['Expire_DateTime']) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" name="amount" value="<?php echo trim($record1['Amount']) ?>">
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
                                                    <input class="form-control" type="file" onchange="previewImage(event)" name="f1">
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