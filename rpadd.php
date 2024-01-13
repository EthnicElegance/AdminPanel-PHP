<?php
    //require_once("config.php");

    // require __DIR__.'/vendor/autoload.php';

    // use Kreait\Firebase\Factory;

    // $storage = (new Factory())
    // ->withServiceAccount('jsonkeys/ethincelegance-firebase-adminsdk-jfli6-ab8269909a.json')
    // ->withDefaultStorageBucket('ethincelegance.appspot.com')
    // ->createStorage();

    // $bucket = $storage->getBucket();
    // if(isset($_REQUEST['btnsub']))
    // {
    //   $name=$_REQUEST['name'];
    //   $gen = $_REQUEST['gen'];
    //   $photo=$_FILES['f1']['name'];

    //   if($_FILES['f1']['name']){
    //     $bucket->upload(
    //         file_get_contents($_FILES['f1']['tmp_name']),
    //         [
    //         'name' =>$_FILES['f1']['name']
    //         ]
    //     );
      
    //   }

    //   $new = $database
    //   ->getReference('Project/category')
    //   ->push([
    //       'name' => $name,
    //       'gender' => $gen,
    //       'photo' =>$photo,
    //   ])->getKey();
    //   header("location:catshow.php");
    // }

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
                                <label class="col-sm-2 col-form-label">Sub Category</label>
                                <div class="col-sm-10">
                                    <select name="sc" class="form-control">
                                        <option>Select</option>
                                        <option>Lehenga</option>
                                        <option>Kurti</option>
                                        <option>Saree</option>
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
                                    <select name="ava" class="form-control">
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
                                    <select name="fabric" class="form-control">
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
                                    <input class="form-control" type="text" name="pcolour" id="pcolour" placeholder="Enter Product Colour" required>
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