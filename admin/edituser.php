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
                <h2><i class="fa fa-users"></i> Users</h2>
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-8">
                <!-- Form Elements -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-plus-circle"></i> Edit User
                    </div>
                    <?php 
                        if(isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'edit')
                        {
                            $id=$_GET['id'];
                            $stm = $con -> prepare("select * from user where id=:userId");
                            $stm -> execute(array("userId" => $id));
                            if ($stm -> rowCount()) 
                            {
                                foreach ($stm->fetchAll() as $row) 
                                {
                                    $id = $row['id'];
                                    $name = $row['full_name'];
                                    $username = $row['username'];
                                    $email = $row['email'];
                                    $password = $row['password'];
                                    $role_id = $row['role_id'];
                                    
                        if(isset($_POST['submit'])) 
                        { 
                            $name = trim(ucwords($_POST['name']));
                            $username = trim($_POST['username']);
                            $email = trim($_POST['email']);
                            $password = trim($_POST['password']);
                            $con_password = trim($_POST['con_password']);
                            $role_id  = $_POST['role_id'];

                            $errors=array();

                            $number = preg_match('@[0-9]@', $password);
                            $uppercase = preg_match('@[A-Z]@', $password);
                            $lowercase = preg_match('@[a-z]@', $password);
                            $specialChars = preg_match('@[^\w]@', $password);

                            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) 
                            {
                                $errors['name'] = "Only Letters and White Space Allowed";
                            }
                            
                            if(!preg_match('/^[a-zA-Z][0-9a-zA-Z_]{2,23}[0-9a-zA-Z]$/', $username))
                            {
                                $errors['username'] = "Username must start with a letter, can only contain letters, numbers, and the underscore character, it also should be greater than 4 and less than 20, and can not end with an underscore<br>";

                            }

                            if(strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars)
                                {
                                    $errors['password'] = "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character <br>";
                                }
                            elseif ($con_password != $password)
                            {
                                $errors['con_password'] = "Confirm Password dosn't Match with Your Password  <br>";
                            }

                            if(empty($errors))
                            {
                                $sql = "update user set full_name=?, username=?, email=?, password=?, role_id=? where id=?";
                                $stm = $con -> prepare($sql);
                                $stm -> execute(array($name, $username, $email, $password, $role_id, $id));
                                if ($stm -> rowCount()) 
                                {
                                    echo 
                                    "<script>
                                        alert('One Row Updated');
                                        window.open('users.php','_self');
                                    </script> ";
                                } 
                                else 
                                {
                                    echo "<div class='alert alert-danger'> One Row not Updated </div>" ;
                                }
                            }
                        }
                        ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" method="POST">
                                <input type="hidden" name="id" value="<?php echo $id ?>" >
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Please Enter your Full Name " class="form-control" 
                                        value="<?php echo $name ?>" required/>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['name'] )) echo  $errors['name']  ?>
                                        </i>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="PLease Enter Username"
                                        value="<?php echo $username ?>" required/>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['username'] )) echo  $errors['username']  ?>
                                        </i>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="PLease Enter Eamil" 
                                        value="<?php echo $email ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Please Enter password" 
                                        value="<?php echo $password ?>" required>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['password'] )) echo  $errors['password']  ?>
                                        </i>                                    
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con_password" class="form-control" placeholder="Please Enter confirm password" 
                                        value="<?php echo $password ?>" required>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['con_password'] )) echo  $errors['con_password']  ?>
                                        </i> 
                                    </div>
                                    <div class="form-group">
                                        <label>User Type</label>
                                        <select class="form-control" name="role_id">
                                            <?php 
                                                $sql = "select * from role" ;
                                                $stm = $con -> prepare($sql);
                                                $stm -> execute();
                                                foreach ($stm -> fetchAll() as $row) 
                                                {
                                            ?>
                                                <option value = <?php echo $row['id'] ?>>  <!-- Q -->
                                                    <?php echo $row['name']?>
                                                </option>
                                            <?php
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                    <div style="float:right;">
                                        <button type="submit" name="submit" class="btn btn-primary">Edit User</button>
                                        <button type="submit" name="cancel" class="btn btn-danger">Cancel
                                        <?php 
                                            if(isset($_POST['cancel']))
                                            {
                                                echo 
                                                "<script>
                                                    window.open('users.php','_self');
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