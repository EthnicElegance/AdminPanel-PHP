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
      $new1 = $database
      ->getReference('Project/size')
      ->push([
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

      $new = $database
      ->getReference('Project/RentProduct')
      ->push([
          'subcatid' => $subcatid,  
          'RentProduct_name' => $rpname,
          'price' => $price,
          'availability' => $ava,
          'size' => $new1,
          'qty' => $totqty,
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
<script>
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
</script>

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
                                    <input class="form-control" type="number" name="price" id="price" placeholder="Enter Price per day" required>
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
                                <label class="col-sm-2 col-form-label">Size</label>&nbsp;&nbsp;&nbsp;&nbsp;                    
                                <div class="form-check">
                                    <label for="S" class="" align="center">    S
                                    <input class="form-control-col-sm-2" type="checkbox" id="Sc" name="size[]" onclick="toggleTextbox()" value="S">
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="0" id="St" disabled placeholder="S Qty">
                                </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="M" class="" align="center">    M
                                    <input class="form-control-col-sm-2" type="checkbox" id="Mc" name="size[]" onclick="toggleTextbox()" value="M">
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="0" id="Mt" disabled placeholder="M Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="L" class="" align="center">    L
                                    <input class="form-control-col-sm-2" type="checkbox" id="Lc" name="size[]" onclick="toggleTextbox()" value="L">
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="0" id="Lt" disabled placeholder="L Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="XL" class="" align="center">    XL
                                    <input class="form-control-col-sm-2" type="checkbox" id="XLc" name="size[]" onclick="toggleTextbox()" value="XL">
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="0" id="XLt" disabled placeholder="XL Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="XXL" class="" align="center">    XXL
                                    <input class="form-control-col-sm-2" type="checkbox" id="XXLc" name="size[]" onclick="toggleTextbox()" value="XXL">
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="0" id="XXLt" disabled placeholder="XXL Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="XXXL" class="" align="center">    XXXL
                                    <input class="form-control-col-sm-2" type="checkbox" id="XXXLc" name="size[]" onclick="toggleTextbox()" value="XXXL">
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="0" id="XXXLt" disabled placeholder="XXXL Qty">
                                    </label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="form-check">
                                    <label for="Free Size" class="" align="center">Free Size
                                    <input class="form-control-col-sm-2" type="checkbox" id="FreeSizec" name="size[]" onclick="toggleTextbox()" value="FreeSize">
                                    <input class="form-control-col-sm-2" type="text" name="qty[]" value="0" id="FreeSizet" disabled placeholder="FreeSize Qty">
                                    </label>                                
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