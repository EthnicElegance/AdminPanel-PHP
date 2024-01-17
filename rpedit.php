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
        $url="Project/RentProduct/$id";
        $datalistrp=$database->getReference($url)->getSnapshot()->getValue();
        $sid=$datalistrp['size'];
        $url1="Project/size/$sid";        

        $datasize=$database->getReference($url1)->getSnapshot()->getValue();
        
        $file1=$datalistrp['photo'];
        $path="https://firebasestorage.googleapis.com/v0/b/ethincelegance.appspot.com/o/$file1?alt=media";
     }

     if (isset($_POST['edit']))
     {
   
        $rpname = $_REQUEST['rpname'];
        $subcatid=$_REQUEST['subcatid'];
        $price = $_REQUEST['price'];
        $ava = $_REQUEST['ava'];
        
        $qty = $_REQUEST['qty'];
        $rpdetail = $_REQUEST['rpdetail'];
        $fb = $_REQUEST['fabric'];
        $rpcolour = $_REQUEST['colour'];
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
                    'RentProduct_name' => $rpname,
                    'price' => $price,
                    'availability' => $ava,
                    'size' => $new1,
                    'qty' => $totqty,
                    'RentProduct_detail' => $rpdetail,
                    'fabric' => $fb,
                    'RentProduct_colour' => $rpcolour,
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
                    'RentProduct_name' => $rpname,
                    'price' => $price,
                    'availability' => $ava,
                    'size' => $new1,
                    'qty' => $totqty,
                    'RentProduct_detail' => $rpdetail,
                    'fabric' => $fb,
                    'RentProduct_colour' => $rpcolour,
                    'photo' =>$file1
                ]
            );
        }    
        // echo $datalistSubcat;
        header("Location:rpshow.php");
     }

    include_once("header.php");
?>
<br>
        <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit Rent Product</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">RentProduct Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="rpname" value="<?php echo trim($datalistrp['RentProduct_name']) ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sub Category</label>
                                <div class="col-sm-10">
                                    <select name="subcatid" class="form-control">
                                        <option>select option </option>
                                            <?php 
                                                foreach($datalistSubcat as $key=>$row)
                                                {
                                                    if ($datalistrp['subcatid'] == $key) {
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
                                <label class="col-sm-2 col-form-label">Price Per Day</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" name="price" value="<?php echo trim($datalistrp['price']) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Availability</label>
                                <div class="col-sm-10">
                                    <select name="ava" class="form-control">
                                    <?php 
                                                    if ($datalistProduct['availability'] == "Available") {
                                            ?>                                
                                                        <option value='<?php echo $datalistProduct['availability'];?>' selected><?php echo trim($datalistrp['availability']) ?> </option>                            
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
                                                        <option value='<?php echo $datalistProduct['availability'];?>' selected><?php echo trim($datalistrp['availability']) ?> </option>                            
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
                                                        <option value='<?php echo $datalistProduct['availability'];?>' selected><?php echo trim($datalistrp['availability']) ?> </option>                            
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

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">RentProduct Detail</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="rpdetail" value="<?php echo trim($datalistrp['RentProduct_detail']) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fabric</label>
                                <div class="col-sm-10">
                                    <select name="fabric" class="form-control">
                                    <?php 
                                                    if ($datalistrp['fabric'] == "Silk") {
                                            ?>                                
                                                        <option value='<?php echo $datalistrp['fabric'];?>' selected><?php echo trim($datalistrp['fabric']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>          
                                                        <option>Silk</option>
                                            <?php    
                                                    }
                                            ?>
                                            <?php
                                                    if ($datalistrp['fabric'] == "Cotton") {
                                            ?>                                
                                                        <option value='<?php echo $datalistrp['fabric'];?>' selected><?php echo trim($datalistrp['fabric']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>          
                                                    <option>Cotton</option>
                                            <?php
                                                    }
                                            ?>
                                            <?php
                                                    if ($datalistrp['fabric'] == "Rayon") {
                                            ?>                                
                                                        <option value='<?php echo $datalistrp['fabric'];?>' selected><?php echo trim($datalistrp['fabric']) ?> </option>                            
                                            <?php
                                                    }
                                                    else {
                                            ?>
                                                        <option>Rayon</option>
                                            <?php
                                                    }
                                            ?>
                                            <?php
                                                    if ($datalistrpt['fabric'] == "Georgette") {
                                            ?>                                
                                                        <option value='<?php echo $datalistrp['fabric'];?>' selected><?php echo trim($datalistrp['fabric']) ?> </option>                            
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
                                <label class="col-sm-2 col-form-label">RentProduct Colour</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="colour" value="<?php echo trim($datalistrp['RentProduct_colour']) ?>">
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