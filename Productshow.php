<?php
 require_once("config.php");
 use Kreait\Firebase\Factory;
 $storage = (new Factory())
 ->withServiceAccount('jsonkeys/ethincelegance-firebase-adminsdk-jfli6-ab8269909a.json')
 ->withDefaultStorageBucket('ethincelegance.appspot.com')
 ->createStorage();

 $bucket = $storage->getBucket();

  if (isset($_REQUEST['id']))
  {
      $id=$_REQUEST['id'];
      $url="Project/product/$id";
      $datalistProduct=$database->getReference($url)->getSnapshot()->getValue();
      $sid=$datalistProduct['size'];
      $url1="Project/size/$sid";

      $datalist1 = $database->getReference($url)->getSnapshot()->getValue();
      $existingFile = $bucket->object($datalist1['photo']);
      if ($existingFile->exists()) {
          $existingFile->delete();
      } 
      $record=$database->getReference($url)->remove();
      $record1=$database->getReference($url1)->remove();
         
     header("location:Productshow.php");
  }
  $datalist = $database->getReference('Project/product')->getSnapshot()->getValue();

    include_once("header.php");
?>
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">DataTables</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="la la-home font-20"></i></a>
                    </li>
                    <!-- <li class="breadcrumb-item">DataTables</li> -->
                </ol>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Product</div>
                        <a class="btn btn-info" href="Productadd.php"><i class="fa fa-plus fa-lg"></i> Add</a>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>IMAGES</th>
                                    <th>PRODUCT NAME</th>
                                    <th>SUB CATEGORY</th>
                                    <th>PRODUCT DETAILS</th>
                                    <th>USER TYPE</th>
                                    <th>RETAILER PRICE</th>
                                    <th>CUSTOMER PRICE</th>
                                    <th>AVAILABILITY</th>
                                    <th>SIZE</th>
                                    <th>QTY</th>
                                    <th>GENDER</th>
                                    <th>FABRIC</th>
                                    <th>COLOR</th>
                                    <th>OP</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>IMAGES</th>
                                    <th>PRODUCT NAME</th>
                                    <th>SUB CATEGORY</th>
                                    <th>PRODUCT DETAILS</th>
                                    <th>USER TYPE</th>
                                    <th>RETAILER PRICE</th>
                                    <th>CUSTOMER PRICE</th>
                                    <th>AVAILABILITY</th>
                                    <th>SIZE</th>
                                    <th>QTY</th>
                                    <th>GENDER</th>
                                    <th>FABRIC</th>
                                    <th>COLOR</th>
                                    <th>OP</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    foreach($datalist as $key=>$row)
                                    {
                                        $file1=$row['photo'];
                                        $path="https://firebasestorage.googleapis.com/v0/b/ethincelegance.appspot.com/o/$file1?alt=media";
                                ?>
                                    <tr>
                                        <td><img class='img-circle' src='<?php echo $path;?>' width=60px height=60px /></td>
                                        <td><?=$row['product_name'];?></td>
                                        <?php 
                                        $id=$row['subcatid'];
                                        $id1=$row['size'];
                                        $datalistCat = $database->getReference("Project/subcategory/$id")->getSnapshot()->getValue();
                                        $datalistsize = $database->getReference("Project/size/$id1")->getSnapshot()->getValue();
                                        $datalistsizekey = $database->getReference("Project/size/$id1")->getKey();

                                        ?>
                                        <td><?= $datalistCat['subcat'] ?></td>
                                        <td><?=$row['detail'];?></td>
                                        <td><?=$row['user_type'];?></td>
                                        <td><i class="fa fa-inr"></i><?=$row['retailer_price'];?></td>
                                        <td><i class="fa fa-inr"></i><?=$row['customer_price'];?></td>
                                        <td><?=$row['availability'];?></td>
                                        <td><?php foreach ($datalistsize as $key1 => $value1) {
                                                if ($value1 > 0) {
                                                    echo "$key1: $value1<br>";
                                                }
                                        }?></td>
                                        <td><?=$row['qty'];?></td>
                                        <td><?=$row['gender'];?></td>
                                        <td><?=$row['fabric'];?></td>
                                        <td><?=$row['product_colour'];?></td>
                                        
                                        <td>
                                        <a class="edit" href="Productedit.php?id=<?php echo $key?>" ><i class="fa fa-pencil" style="color:#243c64;"></i></a>
                                        <a class="delete" href="Productshow.php?id=<?php echo $key?>" onclick="return confirm('Are you sure you want to delete <?=$row['product_name'];?>');"><i class="fa fa-trash" style="color:#243c64;"></i></a>  
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            
<?php
    include_once("footer.php");
?>