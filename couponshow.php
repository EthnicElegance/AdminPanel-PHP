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
        $url="Project/Coupon/$id";
        $datalist1 = $database->getReference($url)->getSnapshot()->getValue();
        $existingFile = $bucket->object($datalist1['photo']);
        if ($existingFile->exists()) {
            $existingFile->delete();
        }   
        $record1=$database->getReference($url)->remove();
         
        header("location:couponshow.php");
    }
    $datalist = $database->getReference('Project/Coupon')->getSnapshot()->getValue();

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
                        <div class="ibox-title">Coupon</div>
                        <a class="btn btn-info" href="couponadd.php"><i class="fa fa-plus fa-lg"></i> Add</a>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>IMAGES</th>
                                    <th>COUPON NAME</th>
                                    <th>COUPON DISCOUNT</th>
                                    <th>EXPIRE DATE-TIME</th>
                                    <th>AMOUNT</th>
                                    <th>OPERATIONS</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>IMAGES</th>
                                    <th>COUPON NAME</th>
                                    <th>COUPON DISCOUNT</th>
                                    <th>EXPIRE DATE-TIME</th>
                                    <th>AMOUNT</th>
                                    <th>OPERATIONS</th>
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
                                        <td><?=$row['Coupon_name'];?></td>
                                        <td><?=$row['Coupon_discount'];?></td>
                                        <td><?=$row['Expire_DateTime'];?></td>
                                        <td><?=$row['Amount'];?></td>
                                        
                                        <td>
                                        <a class="edit" href="couponedit.php?id=<?php echo $key?>" ><i class="fa fa-pencil" style="color:#243c64;"></i></a>
                                        <a class="delete" href="couponshow.php?id=<?php echo $key?>" onclick="return confirm('Are you sure you want to delete <?=$row['Coupon_name'];?>');"><i class="fa fa-trash" style="color:#243c64;"></i></a>  
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