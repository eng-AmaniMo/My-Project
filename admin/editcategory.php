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
                        <i class="fa fa-plus-circle"></i> Edit Category
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <?php
                            if(isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'edit')
                            {
                                $id=$_GET['id'];
                                $stm = $con -> prepare("select * from category where id=:categoryId");
                                $stm -> execute(array("categoryId" => $id));
                                if ($stm -> rowCount()) 
                                {
                                    foreach ($stm->fetchAll() as $row) 
                                    {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $image = $row['image'];
                                   
                            if (isset($_POST['submit'])) 
                            {
                                $id = $_POST['id'];
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

                                else
                                {
                                    if (move_uploaded_file($image_tmp, "upload/".$image_name)) 
                                    {
                                        move_uploaded_file($image_tmp, "upload/".$image_name); 
                                        $sql = "update category set name=? , image=? where id=?";
                                        $stm = $con->prepare($sql);
                                        $stm -> execute(array($name, $image_name, $id));
                                        if ($stm->rowCount()) 
                                        {
                                            echo 
                                            "<script>
                                                alert('One Row Updated');
                                                window.open('categories.php','_self');
                                            </script> ";
                                        } 
                                        else 
                                        {
                                            echo "<div class='alert alert-danger'>One Row not Updated </div>";
                                        }
                                    }
                                    else
                                    {
                                        $sql = "update category set name=? where id=?";
                                        $stm = $con->prepare($sql);
                                        $stm -> execute(array($name, $id));
                                        if ($stm->rowCount()) 
                                        {
                                            echo 
                                            "<script>
                                                alert('One Row Updated');
                                                window.open('categories.php','_self');
                                            </script> ";
                                        } 
                                        else 
                                        {
                                            echo "<div class='alert alert-danger'>One Row not Updated </div>";
                                        }
                                    }
                                }
                            }
                            ?>
                            <div class="col-md-12">
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $id ?>" >
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Please Enter Name of the Category" class="form-control"
                                        value="<?php echo $name ?>" required />
                                        <i style="color: red;">
                                            <?php if (isset($errors['numeric_name'])) echo $errors['numeric_name'] ?>
                                        </i> 
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="file" class="form-control"> <br> 
                                        <img src="upload/<?php echo $image ?>" width="200px">
                                        <i style="color: red;">
                                            <?php if(isset( $errors['image_extension'] )) echo  $errors['image_extension'] ?>
                                        </i>
                                        </div>
                                    <div style="float:right;">
                                        <button type="submit" name="submit" class="btn btn-primary">Edit Category</button>
                                        <button type="submit" name="cancel" class="btn btn-danger">Cancel
                                            <?php 
                                            if(isset($_POST['cancel']))
                                            {
                                                echo 
                                                "<script>
                                                    window.open('categories.php','_self');
                                                </script> ";
                                            }
                                            ?>
                                        </button>
                                    </div>
                            </div>
                            </form>
                            <?php 
                                } } } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <hr />
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
</div>


<?php
include('footer.php');
?>
