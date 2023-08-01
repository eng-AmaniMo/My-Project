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
                        <i class="fa fa-plus-circle"></i> Edit Porduct
                    </div>
                    <?php 
                    if(isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'edit')
                    {
                        $id=$_GET['id'];
                        $stm = $con -> prepare("select * from product where id=:productId");
                        $stm -> execute(array("productId" => $id));
                        if ($stm -> rowCount()) 
                        {
                            foreach ($stm->fetchAll() as $row) 
                            {
                                $id = $row['id'];
                                $name = $row['name'];
                                $image = $row['image'];
                                $price = $row['price'];
                                $color = $row['color'];
                                $features = $row['features'];
                                $dimensions = $row['dimensions'];
                                $construction = $row['construction'];
                                $additional_info = $row['additional_info'];
                                $category_id = $row['category_id'];
                                
                    if(isset($_POST['submit'])) 
                        { 
                           $name = trim(ucwords($_POST['name']));
                           $image = $_FILES['file'];
                           $price = trim($_POST['price']);

                           
                           
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
                            else
                            {
                                if (move_uploaded_file($image_tmp, "upload/".$image_name)) 
                                {
                                    $sql = "update product set name=?, image=?, price=?, color=?, features=?, dimensions=?, construction=?, additional_info=?, category_id=? where id=?";
                                    $stm = $con -> prepare($sql);
                                    $stm -> execute(array($name, $image_name, $price, $color, $features, $dimensions, $construction, $additional_info, $category_id, $id));
                                    if ($stm->rowCount()) 
                                    {
                                        echo 
                                        "<script>
                                            alert('One Row Updated');
                                            window.open('products.php','_self');
                                        </script> ";
                                    } 
                                    else 
                                    {
                                        echo "<div class='alert alert-danger'> One Row not Updated </div>" ;
                                    }
                                }
                                else 
                                {
                                    $sql = "update product set name=?, price=?, color=?, features=?, dimensions=?, construction=?, additional_info=?, category_id=? where id=?";
                                    $stm = $con -> prepare($sql);
                                    $stm -> execute(array($name, $price, $color, $features, $dimensions, $construction, $additional_info, $category_id, $id));
                                    if ($stm->rowCount()) 
                                    {
                                        echo 
                                        "<script>
                                            alert('One Row Updated');
                                            window.open('products.php','_self');
                                        </script> ";
                                    } 
                                    else 
                                    {
                                        echo "<div class='alert alert-danger'> One Row not Updated </div>" ;
                                    }
                                }
                            }                      
                        }
                        ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $id ?>" >
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Please Enter Name of the Product " class="form-control" 
                                        value="<?php echo $name ?>" required/>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['name'] )) echo  $errors['name']  ?>
                                        </i>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control" name="file"><br> 
                                        <img src="upload/<?php echo $image ?>" width="200px">
                                        <i style="color: red;">
                                            <?php if(isset( $errors['image_error'] )) echo  $errors['image_error']  ?>
                                        </i>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" name="price" placeholder="Please Enter Price of the Product " class="form-control"
                                        value="<?php echo $price ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Available Color</label>
                                        <input type="text" name="color" placeholder="Please Enter Available Color of the Product "
                                            class="form-control" value="<?php echo $color ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Features</label>
                                        <textarea placeholder="Please Enter Features of the Product" name="features" class="form-control" cols="30" rows="3">
                                        <?php echo $features ?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Dimensions</label>
                                        <textarea placeholder="Please Enter Dimensions of the Product" name="dimensions" class="form-control" cols="30" rows="3">
                                        <?php echo $dimensions ?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Construction</label>
                                        <textarea placeholder="Please Enter Construction of the Product" name="construction" class="form-control" cols="30" rows="3">
                                        <?php echo $construction ?>
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Additional Info</label>
                                        <textarea placeholder="Please Enter Additional Info of the Product" name="additional_info" class="form-control" cols="30" rows="3">
                                        <?php echo $additional_info ?>
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
                                                <?php echo $row['name'] ?>
                                            </option>
                                            <?php
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                    <div style="float:right;">
                                        <button type="submit" name="submit" class="btn btn-primary"> Edit Product </button>
                                        <button type="submit" name="cancel" class="btn btn-danger">Cancel
                                        <?php 
                                            if(isset($_POST['cancel']))
                                            {
                                                echo 
                                                "<script>
                                                    window.open('products.php','_self');
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