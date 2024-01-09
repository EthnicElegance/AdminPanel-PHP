<?php

    require_once("config.php");
    if(isset($_REQUEST['id']))
    {
        $id=$_REQUEST['id'];
        echo $id;
        $url="Project/subcategory/$id";
        $record=$database->getReference($url)->getSnapshot()->getValue();
        print_r($record);
    }

    if (isset($_POST['bt']))
    {
        $pname=$_POST['pname'];
        $price=$_POST['price'];
        $record=$database->getReference($url)->update(
            [
                'pname' => $pname,
                'price' =>  $price
         ]
        );
   
     
        echo $record;
        header("Location:subshow.php");

    }

    require_once("header.php");
?>

<form class="form-horizontal" method="post" novalidate="novalidate">
<div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit Product</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" id="form-sample-1" method="post" novalidate="novalidate">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="pname" id="pname" value="<?php echo trim($record['pname']) ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="price" id="price" value="<?php echo trim($record['price']) ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 ml-sm-auto">
                                    <input class="btn btn-info" type="submit" name="bt"  value="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</form>


<?php
    include_once("footer.php");
?>