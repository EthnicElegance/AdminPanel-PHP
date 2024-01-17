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
        // echo $id;
        $url="Project/product/$id";
        
        $datalistProduct=$database->getReference($url)->getSnapshot()->getValue();
        $sid=$datalistProduct['size'];
        $url1="Project/size/$sid";        

        $datasize=$database->getReference($url1)->getSnapshot()->getValue();
        
        // print_r($datalistProduct);
        // print_r($datasize);
        //print( array_key_exists('S',$datasize) ? $datasize['S'] : '0');
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
            $new1 = $database
                ->getReference($url1)
                ->update([
                    'S' => $qty['0'],  
                    'M' => $qty['1'],
                    'L' => $qty['2'],
                    'XL' => $qty['3'],
                    'XXL' => $qty['4'],
                    'XXXL' => $qty['5'],
                    'FREESIZE' => $qty['6'],
                    'UNSTITCHED' => $qty['7'],
                ])->getKey();

                $totqty=$qty['0']+$qty['1']+$qty['2']+$qty['3']+$qty['4']+$qty['5']+$qty['6']+$qty['7'];

            $database->getReference($url)->update(
                [
                    'subcatid' => $subcatid,  
                    'product_name' => $pname,
                    'detail' => $detail,
                    'user_type' => implode(", ", $ut),
                    'retailer_price' => $rprice,
                    'customer_price' => $cprice,
                    'availability' => $ava,
                    'size' => $new1,
                    'qty' => $totqty,
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
            $new1 = $database
                ->getReference($url1)
                ->update([
                    'S' => $qty['0'],  
                    'M' => $qty['1'],
                    'L' => $qty['2'],
                    'XL' => $qty['3'],
                    'XXL' => $qty['4'],
                    'XXXL' => $qty['5'],
                    'FREESIZE' => $qty['6'],
                    'UNSTITCHED' => $qty['7'],
                ])->getKey();

            $totqty=$qty['0']+$qty['1']+$qty['2']+$qty['3']+$qty['4']+$qty['5']+$qty['6']+$qty['7'];

            $database->getReference($url)->update(
                [
                    'subcatid' => $subcatid,  
                    'product_name' => $pname,
                    'detail' => $detail,
                    'user_type' => implode(", ", $ut),
                    'retailer_price' => $rprice,
                    'customer_price' => $cprice,
                    'availability' => $ava,
                    'size' => $new1,
                    'qty' => $totqty,
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

<!-- <script>
        function toggleTextbox() {
            // Get the checkbox and textbox elements
            var checkbox1 = document.getElementById("Sc");
            var checkbox2 = document.getElementById("Mc");
            var checkbox3 = document.getElementById("Lc");
            var checkbox4 = document.getElementById("XLc");
            var checkbox5 = document.getElementById("XXLc");
            var checkbox6 = document.getElementById("XXXLc");
            var checkbox7 = document.getElementById("FreeSizec");

            var textbox1 = document.getElementById("St");
            var textbox2 = document.getElementById("Mt");
            var textbox3 = document.getElementById("Lt");
            var textbox4 = document.getElementById("XLt");
            var textbox5 = document.getElementById("XXLt");
            var textbox6 = document.getElementById("XXXLt");
            var textbox7 = document.getElementById("FreeSizet");


            // Enable or disable the textbox based on the checked state of the checkbox
            textbox1.disabled = !checkbox1.checked;
            textbox2.disabled = !checkbox2.checked;
            textbox3.disabled = !checkbox3.checked;
            textbox4.disabled = !checkbox4.checked;
            textbox5.disabled = !checkbox5.checked;
            textbox6.disabled = !checkbox6.checked;
            textbox7.disabled = !checkbox7.checked;

        }
</script> -->

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
                                    <input class="form-control" type="text" name="detail" value="<?php echo trim($datalistProduct['detail']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group row" >
                                <label class="col-sm-2">User Type</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <?php
                                        $usertype = explode(", ", $datalistProduct['user_type']);
                                        if (count($usertype) == 2) {
                                        
                                        if ($usertype['0'] == 'Retailer' && $usertype['1'] == 'Customer') {
                                    ?>
                                        <label for="checkbox1">
                                            <input class="form-control" type="checkbox" name="ut[]" id="Retailer" checked value="Retailer">Retailer
                                        </label>
                                        <label for="checkbox2">
                                            <input class="form-control" type="checkbox" name="ut[]" id="Customer" checked value="Customer">Customer
                                        </label>
                                        <?php
                                            }
                                        }
                                        elseif ($usertype['0'] == 'Retailer') {
                                     ?>
                                    <label for="checkbox1">
                                        <input class="form-control" type="checkbox" name="ut[]" id="Retailer" value="Retailer" checked>Retailer
                                    </label>
                                    <label for="checkbox2">
                                        <input class="form-control" type="checkbox" name="ut[]" id="Customer" value="Customer">Customer
                                    </label>
                                    <?php
                                        }
                                        elseif ($usertype['0'] == 'Customer') {
                                     ?>
                                    <label for="checkbox1">
                                        <input class="form-control" type="checkbox" name="ut[]" id="Retailer" value="Retailer">Retailer
                                    </label>
                                    <label for="checkbox2">
                                        <input class="form-control" type="checkbox" name="ut[]" id="Customer" checked value="Customer">Customer
                                    </label>
                                    <?php
                                        }
                                        else{
                                     ?>
                                    <label for="checkbox1">
                                        <input class="form-control" type="checkbox" name="ut[]" id="Retailer" value="Retailer">Retailer
                                    </label>
                                    <label for="checkbox2">
                                        <input class="form-control" type="checkbox" name="ut[]" id="Customer" value="Customer">Customer
                                    </label>
                                    <?php
                                        }
                                     ?>
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
                                                        <option value='<?php echo $datalistProduct['availability'];?>' selected><?php echo trim($datalistProduct['availability']) ?> </option>                            
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
                                                        <option value='<?php echo $datalistProduct['availability'];?>' selected><?php echo trim($datalistProduct['availability']) ?> </option>                            
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
                                                        <option value='<?php echo $datalistProduct['availability'];?>' selected><?php echo trim($datalistProduct['availability']) ?> </option>                            
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
                            <div class="form-group datalistProduct">
                                <label class="col-sm-2 col-form-label">Size</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="size" id="size" placeholder="Enter Size">
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Size</label>&nbsp;&nbsp;&nbsp;&nbsp;                    
                                <div class="form-check">
                                    <label for="S" class="" align="center">    S
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="<?php echo array_key_exists('S',$datasize) ? $datasize['S'] : '0' ?>"  id="St" placeholder="S Qty">
                                </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="M" class="" align="center">    M
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="<?php echo array_key_exists('M',$datasize) ? $datasize['M'] : '0' ?>" id="Mt" placeholder="M Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="L" class="" align="center">    L
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="<?php echo array_key_exists('L',$datasize) ? $datasize['L'] : '0' ?>" id="Lt" placeholder="L Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="XL" class="" align="center">    XL
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="<?php echo array_key_exists('XL',$datasize) ? $datasize['XL'] : '0' ?>" id="XLt" placeholder="XL Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="XXL" class="" align="center">    XXL
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="<?php echo array_key_exists('XXL',$datasize) ? $datasize['XXL'] : '0' ?>" id="XXLt" placeholder="XXL Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="XXXL" class="" align="center">    XXXL
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="<?php echo array_key_exists('XXXL',$datasize) ? $datasize['XXXL'] : '0' ?>" id="XXXLt" placeholder="XXXL Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="Free Size" class="" align="center">Free Size
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="<?php echo array_key_exists('FREESIZE',$datasize) ? $datasize['FREESIZE'] : '0' ?>" id="FreeSizet" placeholder="FreeSize Qty">
                                    </label>                                
                                </div>
                                <div class="form-check">
                                    <label for="Unstitched" class="" align="center">UNSTITCHED
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="<?php echo array_key_exists('UNSTITCHED',$datasize) ? $datasize['UNSTITCHED'] : '0' ?>" id="Unstitchedt" placeholder="Unstitched Qty">
                                    </label>                                
                                </div>
                            </div>
<!-- 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">QTY</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="qty" value="<?php echo trim($datalistProduct['qty']) ?>" required>
                                </div>
                            </div> -->

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
                                                        <option value='<?php echo $datalistProduct['fabric'];?>' selected><?php echo trim($datalistProduct['fabric']) ?> </option>                            
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
                                                        <option value='<?php echo $datalistProduct['fabric'];?>' selected><?php echo trim($datalistProduct['fabric']) ?> </option>                            
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
                                                        <option value='<?php echo $datalistProduct['fabric'];?>' selected><?php echo trim($datalistProduct['fabric']) ?> </option>                            
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
                                                        <option value='<?php echo $datalistProduct['fabric'];?>' selected><?php echo trim($datalistProduct['fabric']) ?> </option>                            
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