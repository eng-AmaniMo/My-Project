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
                        <i class="fa fa-plus-circle"></i> Add New User
                    </div>
                    <?php 
                        if(isset($_POST['submit'])) 
                        { 
                            $name = trim(ucwords($_POST['name']));
                            $username = trim($_POST['username']);
                            $email = trim($_POST['email']);
                            $password = trim($_POST['password']);
                            $con_password = trim($_POST['con_password']);
                            $role_id  = $_POST['role_id'];

                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
                                $sql = "INSERT INTO user(full_name, username, email, password, role_id) VALUES (?,?,?,?,?)";
                                $stm = $con -> prepare($sql);
                                $stm -> execute(array($name, $username, $email, $hashed_password, $role_id));
                                if ($stm -> rowCount()) 
                                {
                                    echo "<div class='alert alert-success'>One Row Inserted</div>" ;
                                } 
                                else 
                                {
                                    echo "<div class='alert alert-danger'>One Row has not Inserted <br> Username or Email is Already Used</div>" ;
                                }
                            }
                        }
                        ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" method="POST">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Please Enter your Full Name " class="form-control" required/>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['name'] )) echo  $errors['name']  ?>
                                        </i>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="PLease Enter Username" required/>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['username'] )) echo  $errors['username']  ?>
                                        </i>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="PLease Enter Eamil" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Please Enter password" required>
                                        <i style="color: red;">
                                            <?php if(isset( $errors['password'] )) echo  $errors['password']  ?>
                                        </i>                                    
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con_password" class="form-control" placeholder="Please Enter confirm password" required>
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
                                                <option value = <?php echo $row['id'] ?>> 
                                                    <?php echo $row['name'] ?>
                                                </option>
                                            <?php
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                    <div style="float:right;">
                                        <button type="submit" name="submit" class="btn btn-primary">Add User</button>
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
                        <i class="fa fa-users"></i> Users
                    </div>
                    <?php
                    if (isset($_GET['action'], $_GET['id'])) 
                    {
                        $id = $_GET['id'];

                        $sql="select status from user where id=:userId";
                        $stm = $con -> prepare($sql);
                        $stm -> execute(array("userId" => $id));
                        $row = $stm -> fetch();
                        $status=$row['status'];
                        
                        switch ($_GET['action']) 
                        {
                            case "delete":
                                $sql = "DELETE from user where id=:userId";
                                $stm = $con -> prepare($sql);
                                $stm -> execute(array("userId" => $id));
                                if($stm -> rowCount() == 1)
                                {
                                    echo "<div class='alert alert-success'> One Row Deleted </div>";
                                }
                                break;

                            case "status":
                                if($status=="Inactive")
                                {
                                    $sql = "update user set status='Active' where id=:userId";
                                    $stm = $con -> prepare($sql);
                                    $stm -> execute(array("userId" => $id));
                                    if($stm -> rowCount() == 1)
                                    {
                                        echo "<div class='alert alert-success'> User Status Updated to Active </div>";
                                    }  
                                }     
                                else // ($status=="Active")
                                {
                                    $sql = "update user set status='Inactive' where id=:userId";
                                    $stm = $con -> prepare($sql);
                                    $stm -> execute(array("userId" => $id));
                                    if($stm -> rowCount() == 1)
                                    {
                                        echo "<div class='alert alert-success'> User Status Updated to Inactive </div>";
                                    }  
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
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql="select * from user";
                                        $stm = $con -> prepare($sql);
                                        $stm -> execute();

                                        if($stm -> rowCount())
                                        {
                                            foreach ($stm -> fetchAll() as $row) 
                                            {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $row['full_name']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['password']; ?></td>
                                        <td>
                                        <?php 
                                            $sql = "select * from role where id=:role_id";
                                            $stm = $con -> prepare($sql);
                                            $stm -> execute(array("role_id" => $row['role_id']));
                                            foreach ($stm -> fetchAll() as $roleRow) 
                                            {
                                               echo $roleRow['name'];
                                            } 
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($row['status']=='Inactive')
                                                    echo "<span> Inactivated </span>";    
                                                else
                                                    echo "<span> Activated </span>";         
                                            ?>
                                        </td>
                                        <td>
                                            <a href="edituser.php?action=edit&id=<?php echo $row['id'] ?>" class='btn btn-success'>
                                                Edit
                                            </a>
                                            <a onclick="return confirm('Are You Sure You Want to Delete this Record?');" 
                                                href="?action=delete&id=<?php echo $row['id'] ?>" class='btn btn-danger' id="delete">
                                                Delete
                                            </a>
                                            <a href="?action=status&id=<?php echo $row['id'] ?>">
                                                <?php 
                                                    if($row['status']=='Inactive')
                                                        echo "<span class='btn btn-success' style='border-radius:50%'> 1 </span>";    
                                                    else
                                                        echo "<span class='btn btn-danger' style='border-radius:50%'> 0 </span>";         
                                                ?>
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