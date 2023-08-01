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
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            //$pass = sha1($password);


            $errors=array();

            if(empty($errors))
            {
                $sql="SELECT * FROM user WHERE username=:userName /*AND password=:pass*/";
                $stm = $con -> prepare($sql);
                $stm -> execute(array("userName" => $username/*, "pass" => $password*/));
                $row = $stm -> fetch();
                if($stm -> rowCount() == 1)
                {
                    //if(password_verify($password, $row['password']))
                    //{
                        $_SESSION['user_info'] = $row;
                        if ($_SESSION['user_info']['role_id'] == 1)
                        {
                            header("location: home.php");
                        }
                        else
                        {
                            header("location: admin/index.php");
                        }
                    //}
                }
                else 
                {
                    $errors['wrong'] = "Username or Password are wrong";
                }
            }
        }
        ?>
    
    <section class="login">
        <div class="form-container">
            <form action="" method="post">
                <h3> Login </h3>
                <i style="color: red;">
                    <?php if(isset( $errors['taken'] )) echo  $errors['taken']  ?>
                </i>
                <input type="hidden" name="id" value="<?php echo $id ?>" >
                <input type="text" name="username" placeholder="username" class="box" required>
                <input type="password" name="password" placeholder="password" class="box" required>
                <input type="submit" name="submit" value="login" class="btn" style="margin: 10px 0; width: 8rem; height: 2.7rem; margin-top: 2rem; border-radius: 0.5rem;outline: none;border: none; padding: 0rem 0.5rem 0.2rem 0.5rem; text-align: center; background-color:rgba(50, 87, 112, 0.692); color:white; font-size: 1.4rem;">
                <p>don't have an account? <a href="register.php">register now</a></p>
            </form>
        </div>
    </section>
    <!-- Footer -->
    <?php include('include/footer.php'); ?> 
