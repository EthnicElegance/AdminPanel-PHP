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
     $url="Project/category/$id";
     $datalist1 = $database->getReference($url)->getSnapshot()->getValue();
     $existingFile = $bucket->object($datalist1['photo']);
     if ($existingFile->exists()) {
         $existingFile->delete();
     } 
     $record=$database->getReference($url)->remove();
         
     header("location:catshow.php");
 }
 $datalist = $database->getReference('Project/category')->getSnapshot()->getValue();

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
                        <div class="ibox-title">Category</div>
                        <a class="btn btn-info" href="catadd.php">
  <i class="fa fa-plus fa-lg"></i> Add</a>

                        <!-- <a class="add" href="catadd.php" style="color:#243c64;"><i class="fa fa-plus" style="color:#243c64;"></i>Add</a>
             -->
                    </div>
                    <div class="ibox-body">
                        <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th>CATAGORY NAME</th>
                                    <th>TYPE</th>
                                    <th>DESCRIPTION</th>
                                    <th>Photo</th>
                                    <th>OPERATIONS</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>CATAGORY NAME</th>
                                    <th>TYPE</th>
                                    <th>DESCRIPTION</th>
                                    <th>Photo</th>
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
                                        <td><?=$row['name'];?></td>
                                        <td><?=$row['type'];?></td>
                                        <td><?=$row['description'];?></td>
                                        <td><img src='<?php echo $path;?>' width=100px height=100px /></td>
                                        <td>
                                        <a class="edit" href="edit.php?id=<?php echo $key?>" ><i class="fa fa-pencil" style="color:#243c64;"></i></a>
                                        <a class="delete" href="catshow.php?id=<?php echo $key?>" onclick="return confirm('Are you sure you want to delete <?=$row['name'];?>');"><i class="fa fa-trash" style="color:#243c64;"></i></a>  
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