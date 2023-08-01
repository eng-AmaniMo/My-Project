
    <style>
        body
        {
            background:linear-gradient(rgba(255,255,255,.1),rgba(255,255,255,.1)),url("images/slider.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-size: 100% 100%;
            background-position: center;
            background-attachment: fixed;
        }
    </style>

    <!-- Header  -->
    <?php 
     session_start(); 
     include('include/header.php'); 
     require('include/dbconnect.php');
    ?> 
    <?php 
    if(isset($_POST['submit'])) 
    { 
        $name = trim(ucwords($_POST['name']));
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $con_password = trim($_POST['con_password']);
        //$pass = sha1($password)
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
            $sql = "INSERT INTO user(full_name, username, email, password) VALUES (?,?,?,?)";
            $stm = $con -> prepare($sql);
            $stm -> execute(array($name, $username, $email, $hashed_password));
            if ($stm -> rowCount()) 
            {
                $sql="SELECT * FROM user WHERE username=:userName /*AND password=:pass*/";
                $stm = $con -> prepare($sql);
            $stm -> execute(array("userName" => $username/*, "pass" => $password*/));
                    if($stm -> rowCount() == 1)
                    {
                        
                        $_SESSION['user_info'] = $stm -> fetch();
                        if ($_SESSION['user_info']['role_id'] == 1)
                        {
                            header("location: home.php");
                        }
                    }
            } 
            else 
            {
                $errors['taken'] = "Username or Email is Already Used";
            }
        }
    }
    ?>
    <section class="login">
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3 style="margin: 5px 0;"> Register </h3>
                <i style="color: red;">
                    <?php if(isset( $errors['taken'] )) echo  $errors['taken']  ?>
                </i>
                <input type="text" name="name" placeholder="full name" class="box" style="margin: 4px 0;" required>
                <i style="color: red;">
                    <?php if(isset( $errors['name'] )) echo  $errors['name']  ?>
                </i>
                <input type="text" name="username" placeholder="username" class="box" style="margin: 4px 0;" required>
                <i style="color: red;">
                    <?php if(isset( $errors['username'] )) echo  $errors['username']  ?>
                </i>
                <input type="email" name="email" placeholder="email" class="box" style="margin: 4px 0;" required>
                <input type="password" name="password" placeholder="password" class="box" style="margin: 4px 0;" required>
                <i style="color: red;">
                    <?php if(isset( $errors['password'] )) echo  $errors['password']  ?>
                </i> 
                <input type="password" name="con_password" placeholder="confirm password" style="margin: 4px 0;" class="box" required>
                <i style="color: red;">
                    <?php if(isset( $errors['con_password'] )) echo  $errors['con_password']  ?>
                </i> 
                <input type="submit" name="submit" value="register" class="btn" style="margin: 10px 0; width: 8rem; height: 2.7rem; margin-top: 2rem; border-radius: 0.5rem;outline: none;border: none; padding: 0rem 0.5rem 0.2rem 0.5rem; text-align: center; background-color:rgba(50, 87, 112, 0.692); color:white; font-size: 1.4rem;">
                <p style="margin: 1px 0; font-size: 20px;">already have an account? <a href="index.php">login now</a></p>
            </form>
        </div>
    </section>
    <br><br><br><br><br><br><br><br>
    <!-- Footer -->
    <?php include('include/footer.php'); ?>
    
