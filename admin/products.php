<?php 
 session_start(); 
 include('header.php');
 require('../include/dbconnect.php');
?>
<!-- /. NAV SIDE  -->
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fa fa-items"></i>Products</h2>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-8">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-plus-circle"></i> Add New Porduct
                    </div>
                    <?php 
                    if(isset($_POST['submit'])) 
                        { 
                           $name = trim(ucwords($_POST['name']));
                           $image = $_FILES['file'];
                           $price = trim($_POST['price']);
                           $color = trim(ucwords($_POST['color']));
                           
                           $features = trim($_POST['features']);
                           $dimensions = trim($_POST['dimensions']);
                           $construction = trim($_POST['construction']);
                           $additional_info = trim($_POST['additional_info']);
                           $category_id  = $_POST['category_id'];                          
                           $image_name = $image['name'];
                           $image_type = $image['type'];
                           $image_tmp= $image['tmp_name'];

                           $errors=array();

                           $extensions=array('jpg','gif','png');
                           $file_explode=explode('.',$image_name);
                           $file_extension=strtolower(end($file_explode));

                            if(!in_array($file_extension,$extensions))
                            {
                              $errors['image_error'] = "<div style='color:red'>File Extensions is Not Valid</div>";
                            }
                            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) 
                            {
                                $errors['name'] = "Only Letters and White Space Allowed" ;
                            }
                            if(empty($errors))
                            {
                                if (move_uploaded_file($image_tmp, "upload/".$image_name)) 
                                {
                                    $sql = "INSERT INTO product(name, image, price, color, features, dimensions, construction, additional_info, category_id) VALUES (?,?,?,?,?,?,?,?,?)";
                                    $stm = $con -> prepare($sql);
                                    $stm -> execute(array($name, $image_name, $price, $color, $features, $dimensions, $construction, $additional_info, $category_id));
                                    if ($stm->rowCount()) 
                                    {
                                        echo "<div class='alert alert-success'>One Row Inserted</div>" ;
                                    } 
                                    else 
                                    {
                                        echo "<div class='alert alert-danger'>One Row has not Inserted</div>" ;
                                    }
                                }
                                else 
                                {
                                    echo "<div class='alert alert-danger'>No File Uploaded </div>";
                                }
                            }                      
                        }
                        ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Please Enter Name of the Product "
                                            class="form-control" required/>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['name'] )) echo  $errors['name']  ?>
                                        </i>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control" name="file">
                                        <i style="color: red;">
                                            <?php if(isset( $errors['image_error'] )) echo  $errors['image_error']  ?>
                                        </i>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" name="price" placeholder="Please Enter Price of the Product "
                                            class="form-control" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Available Color</label>
                                        <input type="text" name="color" placeholder="Please Enter Available Color of the Product "
                                            class="form-control"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Features</label>
                                        <textarea placeholder="Please Enter Features of the Product" name="features" class="form-control" cols="30" rows="3">

                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Dimensions</label>
                                        <textarea placeholder="Please Enter Dimensions of the Product" name="dimensions" class="form-control" cols="30" rows="3">
                                            
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Construction</label>
                                        <textarea placeholder="Please Enter Construction of the Product" name="construction" class="form-control" cols="30" rows="3">
                                            
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Additional Info</label>
                                        <textarea placeholder="Please Enter Additional Info of the Product" name="additional_info" class="form-control" cols="30" rows="3">
                                            
                                        </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Category Type</label>
                                        <select class="form-control" name="category_id">
                                            <?php    
                                                $sql = "select * from category" ;
                                                $stm = $con -> prepare($sql);
                                                $stm -> execute();
                                                foreach ($stm->fetchAll() as $row) 
                                                {
                                            ?>
                                            <option value = <?php echo $row['id'] ?>> 
                                                <?php echo  $row['name'] ?>
                                            </option>
                                            <?php
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                    <div style="float:right;">
                                        <button type="submit" name="submit" class="btn btn-primary"> Add Product </button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />

        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-task"></i> Products
                    </div>
                    <?php
                    if (isset($_GET['action'], $_GET['id'])) 
                    {
                        $id = $_GET['id'];
                        switch ($_GET['action']) 
                        {
                            case "delete":
                                $sql = "DELETE from product where id=:productId";
                                $stm = $con -> prepare($sql);
                                $stm -> execute(array("productId" => $id));
                                if($stm -> rowCount() == 1)
                                {
                                    echo "<div class='alert alert-success'> One Row Deleted </div>";
                                }
                                break;

                            default:
                                echo "ERROR";
                                break;
                        }
                    }
                    ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Available Color</th>
                                        <th>Features</th>
                                        <th>Dimensions</th>
                                        <th>Construction</th>
                                        <th>Additional Info</th>
                                        <th>Category Type</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql="select * from product";
                                        $stm = $con -> prepare($sql);
                                        $stm -> execute();

                                        if($stm -> rowCount())
                                        {
                                            foreach ($stm -> fetchAll() as $row) 
                                            {
                                    ?>
                                        <tr class="odd gradeX">
                                        <td><?php echo $row['name']; ?></td>
                                        <td><img src="upload/<?php echo $row['image'] ?>" width="40px"></td>                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['color']; ?></td>
                                        <td><?php echo $row['features']; ?></td>
                                        <td><?php echo $row['dimensions']; ?></td>
                                        <td><?php echo $row['construction']; ?></td>
                                        <td><?php echo $row['additional_info']; ?></td>
                                        
                                        <td>
                                            <?php 
                                            $sql = "select * from category where id=:category_id";
                                            $stm = $con -> prepare($sql);
                                            $stm -> execute(array("category_id" => $row['category_id']));
                                            foreach ($stm -> fetchAll() as $categoryRow) 
                                            {
                                               echo $categoryRow['name'];
                                            } 
                                            ?>
                                        </td>
                                        <td>
                                            <a href="editproduct.php?action=edit&id=<?php echo $row['id'] ?>" class='btn btn-success'>
                                                Edit
                                            </a>
                                            <a onclick="return confirm('Are You Sure You Want to Delete this Record?');" 
                                                href="?action=delete&id=<?php echo $row['id'] ?>" class='btn btn-danger' id="delete">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                        }}  
                                    ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--End Advanced Tables -->

            </div>
            <!-- /. ROW  -->
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
</div>

<?php
include('footer.php');
?>