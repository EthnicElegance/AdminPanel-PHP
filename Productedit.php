<?php
    require_once("config.php");

    require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;

    $storage = (new Factory())
    ->withServiceAccount('jsonkeys/ethincelegance-firebase-adminsdk-jfli6-ab8269909a.json')
    ->withDefaultStorageBucket('ethincelegance.appspot.com')
    ->createStorage();

    $bucket = $storage->getBucket();
    $datalistSubcat = $database->getReference('Project/subcategory')->getSnapshot()->getValue();

     if(isset($_REQUEST['id']))
     {
        $id=$_REQUEST['id'];
        echo $id;
        $url="Project/product/$id";
        $datalistProduct=$database->getReference($url)->getSnapshot()->getValue();
        print_r($datalistProduct);
        $file1=$datalistProduct['photo'];
        $path="https://firebasestorage.googleapis.com/v0/b/ethincelegance.appspot.com/o/$file1?alt=media";
     }

     if (isset($_POST['edit']))
     {
   
        $pname = $_REQUEST['pname'];
        $subcatid=$_REQUEST['subcatid'];
        $detail = $_REQUEST['detail'];
        $ut = $_REQUEST['ut'];
        $rprice = $_REQUEST['rprice'];
        $cprice = $_REQUEST['cprice'];
        $ava = $_REQUEST['ava'];
        $size = $_REQUEST['size'];
        $qty = $_REQUEST['qty'];
        $gen = $_REQUEST['gen'];
        $fb = $_REQUEST['fb'];
        $pcolour = $_REQUEST['pcolour'];
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
                    'subcatid' => $subcatid,  
                    'product_name' => $pname,
                    'detail' => $detail,
                    'user_type' => $ut,
                    'retailer_price' => $rprice,
                    'customer_price' => $cprice,
                    'availability' => $ava,
                    'size' => $size,
                    'qty' => $qty,
                    'gender' => $gen,
                    'fabric' => $fb,
                    'product_colour' => $pcolour,
                    'photo' =>$photo
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
                    'subcatid' => $subcatid,  
                    'product_name' => $pname,
                    'detail' => $detail,
                    'user_type' => $ut,
                    'retailer_price' => $rprice,
                    'customer_price' => $cprice,
                    'availability' => $ava,
                    'size' => $size,
                    'qty' => $qty,
                    'gender' => $gen,
                    'product_type' => $ptype,
                    'fabric' => $fb,
                    'product_colour' => $pcolour,
                    'photo' => $file1
                ]
            );
        }    
        // echo $datalistSubcat;
        header("Location:Productshow.php");
     }
    include_once("header.php");
?>


<br>
        <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit Product</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="pname" value="<?php echo trim($datalistProduct['product_name']) ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">SubCategory Name</label>
                                <div class="col-sm-10">
                                        <select name="subcatid" class="form-control" >
                                            <option>select option </option>
                                            <?php 
                                                foreach($datalistSubcat as $key=>$row)
                                                {
                                                    if ($datalistProduct['subcatid'] == $key) {
                                            ?>                                
                                                        <option value='<?php echo $key;?>' selected><?php echo $row['subcat'];?> </option>                            
                                            <?php
                                            
                                                    }
                                                    else{
                                            ?>
                                                            <option value='<?php echo $key;?>'><?php echo $row['subcat'];?> </option>                            
                                            <?php
                                                        }
                                                }
                                            ?>
                                        </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product Detail</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="detail" value="<?php echo trim($datalistProduct['detail']) ?>" required>
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label class="col-sm-2">User Type</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="retailer" name="ut[]" value="Retailer">
                                    <label for="Retailer" class="">Retailer</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="cus" name="ut[]" value="Customer">
                                    <label for="Customer" class="">Customer</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Retailer Price</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="rprice" value="<?php echo trim($datalistProduct['retailer_price']) ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Customer Price</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="cprice" value="<?php echo trim($datalistProduct['customer_price']) ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Availability</label>
                                <div class="col-sm-10">
                                    <select name="ava" class="form-control" >
                                            <?php 
                                                    if ($datalistProduct['availability'] == "Available") {
                                            ?>                                
                                                        <option value='<?php echo $row['availability'];?>' selected><?php echo trim($datalistProduct['availability']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>          
                                                        <option>Available</option>
                                            <?php    
                                                    }
                                            ?>
                                            <?php
                                                    if ($datalistProduct['availability'] == "Unavailable") {
                                            ?>                                
                                                        <option value='<?php echo $row['availability'];?>' selected><?php echo trim($datalistProduct['availability']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>          
                                                    <option>Unavailable</option>
                                            <?php
                                                    }
                                            ?>
                                            <?php
                                                    if ($datalistProduct['availability'] == "Coming Soon") {
                                            ?>                                
                                                        <option value='<?php echo $row['availability'];?>' selected><?php echo trim($datalistProduct['availability']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>
                                                        <option>Coming Soon</option>
                                            <?php
                                                    }
                                            ?>
                                    </select>    
                                </div>
                            </div>
<!-- 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Size</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="size" id="size" placeholder="Enter Size">
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label class="col-sm-2">Size</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="S" name="size[]" value="S">
                                    <label for="S" class="">S</label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="M" name="size[]" value="M">
                                    <label for="M" class="">M</label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="L" name="size[]" value="L">
                                    <label for="L" class="">L</label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="XL" name="size[]" value="XL">
                                    <label for="XL" class="">XL</label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="XXL" name="size[]" value="XXL">
                                    <label for="XXL" class="">XXL</label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="XXXL" name="size[]" value="XXXL">
                                    <label for="XXXL" class="">XXXL</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="checkbox" id="Free Size" name="size[]" value="Free">
                                    <label for="Free Size" class="">Free Size</label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="form-control" type="text" name="size[]" id="size" placeholder="Enter Size" >
                                </div>&nbsp;&nbsp;&nbsp;
                                
                                <!-- <a class="delete" href="Productadd.php" onclick="return confirm('are you sure<?= $size ?>');"><i class="fa fa-trash" style="color:#243c64;"></i></a>   -->
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">QTY</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="qty" value="<?php echo trim($datalistProduct['qty']) ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">Gender</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="col-sm-3 from-check-input" type="radio" name="gen" id="Men" value="Men" <?php if ($datalistProduct['gender']=="Men") { ?>checked<?php } ?>>
                                    <label for="Male" class="">Men</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <input class="col-sm-2 from-check-input" type="radio" name="gen" checked id="Women" value="Women" <?php if ($datalistProduct['gender']=="Women") { ?>checked<?php } ?>>
                                    <label for="Female" class="">Women</label>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" >Fabric</label>
                                <div class="col-sm-10" >
                                    <select name="fb" class="form-control">
                                            <?php 
                                                    if ($datalistProduct['fabric'] == "Silk") {
                                            ?>                                
                                                        <option value='<?php echo $row['fabric'];?>' selected><?php echo trim($datalistProduct['fabric']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>          
                                                        <option>Silk</option>
                                            <?php    
                                                    }
                                            ?>
                                            <?php
                                                    if ($datalistProduct['fabric'] == "Cotton") {
                                            ?>                                
                                                        <option value='<?php echo $row['fabric'];?>' selected><?php echo trim($datalistProduct['fabric']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>          
                                                    <option>Cotton</option>
                                            <?php
                                                    }
                                            ?>
                                            <?php
                                                    if ($datalistProduct['fabric'] == "Rayon") {
                                            ?>                                
                                                        <option value='<?php echo $row['fabric'];?>' selected><?php echo trim($datalistProduct['fabric']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>
                                                        <option>Rayon</option>
                                            <?php
                                                    }
                                            ?>
                                            <?php
                                                    if ($datalistProduct['fabric'] == "Georgette") {
                                            ?>                                
                                                        <option value='<?php echo $row['fabric'];?>' selected><?php echo trim($datalistProduct['fabric']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>
                                                        <option>Georgette</option>
                                            <?php
                                                    }
                                            ?>
                                    </select>    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product Colour</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="pcolour" value="<?php echo trim($datalistProduct['product_colour']) ?>" required>
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