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

    if(isset($_REQUEST['btnsub']))
    {
      $rpname = $_REQUEST['rpname'];
      $subcatid=$_REQUEST['subcatid'];
      $price = $_REQUEST['price'];
      $ava = $_REQUEST['ava'];
      $size = $_REQUEST['size[]'];
      $qty = $_REQUEST['qty'];
      $rpdetail = $_REQUEST['rpdetail'];
      $fb = $_REQUEST['fb'];
      $rpcolour = $_REQUEST['rpcolour'];
      //$gen = $_REQUEST['gen'];
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
      ->getReference('Project/RentProduct')
      ->push([
          'subcatid' => $subcatid,  
          'rent_product_name' => $rpname,
          'price' => $price,
          'availability' => $ava,
          'size' => $size,
          'qty' => $qty,
          'RentProduct_detail' => $rpdetail,
          'fabric' => $fb,
          'RentProduct_colour' => $rpcolour,
          //'gender' => $gen,
          'photo' =>$photo,
      ])->getKey();
      header("location:rpshow.php");
    }

    include_once("header.php");
?>
<br>
        <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Insert Rent Product</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" enctype="multipart/form-data" id="form-sample-1" method="post" >
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">RentProduct Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="rpname" id="rpname" placeholder="Enter rent product name" required>
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
                                            ?>                                
                                                <option value='<?php echo $key;?>'><?php echo $row['subcat'];?> </option>                            
                                            <?php
                                            }
                                            ?>
                                        </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Price Per Day</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" name="price" id="price" placeholder="Enter Type" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Availability</label>
                                <div class="col-sm-10">
                                    <select name="ava" class="form-control" >
                                        <option>Select</option>
                                        <option>Available</option>
                                        <option>Unavailable</option>
                                        <option>Coming Soon</option>
                                    </select>    
                                </div>
                            </div>

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
                                    <input class="form-control" type="text" name="qty" id="qty" placeholder="Enter QTY" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">RentProduct Detail</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="rpdetail" id="rpdetail" placeholder="Enter Product Details" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fabric</label>
                                <div class="col-sm-10">
                                    <select name="fb" class="form-control">
                                        <option>Select Fabric</option>
                                        <option>Silk</option>
                                        <option>Cotton</option>
                                        <option>Rayon</option>
                                        <option>Georgette</option>
                                    </select>    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">RentProduct Colour</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="rpcolour" id="rpcolour" placeholder="Enter Product Colour" required>
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
                                                    <input class="form-control" type="file" onchange="previewImage(event)" name="f1" id="f1" required>
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