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
                <h2><i class="fa fa-tasks"></i> Categories</h2>

            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-8">
                <!-- Form Elements -->

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-plus-circle"></i> Add New Category
                    </div>
                    <?php
                            if (isset($_POST['submit'])) 
                            {
                                $name = trim(ucfirst($_POST['name']));
                                $image = $_FILES['file'];

                                $image_name= $image['name'];
                                $image_type= $image['type'];
                                $image_tmp= $image['tmp_name'];

                                $errors = array();

                                $extensions=array('jpg','gif','png');
                                $file_explode=explode('.',$image_name);
                                $file_extension=strtolower(end($file_explode));

                                if(!in_array($file_extension,$extensions))
                                    {
                                        $errors['image_extension'] = "<div> File Extension is Not Valid </div>";
                                    }
                                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) 
                                    {
                                        $errors['numeric_name'] = "<div> Only Letters and White Space Allowed </div>";
                                    }
                        
                                if(empty($errors))
                                    {
                                        if (move_uploaded_file($image_tmp, "upload/".$image_name))
                                        {
                                            $sql = "INSERT into category (name, image) values (?,?) ";
                                            $stm = $con -> prepare($sql);
                                            $stm -> execute(array($name, $image_name));

                                            if ($stm -> rowCount()) 
                                            {
                                                echo "<div class='alert alert-success'> One Row Inserted </div>";
                                            } 
                                            else 
                                            {
                                                echo "<div class='alert alert-danger'> One Row has not Inserted </div>";
                                            }
                                        }
                                        else 
                                        {
                                            echo "<div class='alert alert-danger'>No File Uploaded</div>";
                                        }
                                    }
                                }
                            ?>
                    <div class="panel-body">
                        <div class="row">  

                            <div class="col-md-12">
                                <form role="form" method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Please Enter Name of the Category" class="form-control" required/>
                                        <i style="color: red;">
                                            <?php if (isset($errors['numeric_name'])) echo $errors['numeric_name'] ?>
                                        </i>    
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="file" class="form-control">
                                        <i style="color: red;">
                                            <?php if(isset( $errors['image_extension'] )) echo  $errors['image_extension'] ?>
                                        </i> 
                                    </div>
                                    <div style="float:right;">
                                        <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
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
                        <i class="fa fa-tasks"></i> Categories
                    </div>

                    <?php
                    if (isset($_GET['action'], $_GET['id'])) 
                    {
                        $id = $_GET['id'];
                        switch ($_GET['action']) 
                        {
                            case "delete":
                                $sql = "DELETE from category where id=:categoryId";
                                $stm = $con -> prepare($sql);
                                $stm -> execute(array("categoryId" => $id));
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
                            <table class="table table-striped table-bordered table-hover " id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "select * from category";
                                    $stm = $con -> prepare($sql);
                                    $stm -> execute();
                                    if ($stm -> rowCount()) 
                                    {
                                        foreach ($stm -> fetchAll() as $row) 
                                        {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $row['id'];  ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><img src="upload/<?php echo $row['image'] ?>" width="50px"></td>
                                        <td>
                                            <a href="editcategory.php?action=edit&id=<?php echo $row['id'] ?>" class='btn btn-success'>
                                                Edit
                                            </a>
                                            <a onclick="return confirm('Are You Sure You Want to Delete this Record?');" 
                                                href="?action=delete&id=<?php echo $row['id'] ?>" class='btn btn-danger' id="delete">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php  
                                        }
                                    } 
                                    else 
                                    {
                                    ?>

                                    <div class='alert alert-danger'>No Row </div>
                                    <?php 
                                    }
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

