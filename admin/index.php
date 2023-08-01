<?php 
 session_start(); 
 if (isset($_SESSION['user_info']))
 {
 include('header.php');
 require('../include/dbconnect.php');
?>
<!-- /. NAV SIDE  -->
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fa fa-dashboard "></i> Dashboard</h2>

            </div>
        </div>

        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-red set-icon">
                        <i class="fa fa-users"></i>
                    </span>

                    <!-- users -->
                    <div class="text-box">
                        <p class="main-text">

                            <?php
                            $sql = "select * from user";
                            $stm = $con -> prepare($sql);
                            $stm -> execute();
                            // print the result
                            echo  $stm -> rowCount();
                            ?>

                        Users </p>
                        <br>
                        <br>
                    </div>
                    <a href="users.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- categories -->
            <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-green set-icon">
                        <i class="fa fa-tasks"></i>
                    </span>
                    <div class="text-box">
                        <p class="main-text"> 

                            <?php
                            $sql = "select * from category";
                            $stm = $con -> prepare($sql);
                            $stm -> execute();
                            // print the result 
                            echo $stm -> rowCount();
                            ?>
                            
                        Categories </p>
                        <br>
                        <br>
                    </div>
                    <a href="categories.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- products -->
            <div class="col-md-4 col-sm-6 col-xs-6">
                <div class="panel panel-back noti-box">
                    <span class="icon-box bg-color-blue set-icon">
                        <i class="fa fa-table"></i>
                    </span>
                    <div class="text-box">
                        <p class="main-text"> 
                            
                            <?php
                            $sql = "select * from product";
                            $stm = $con -> prepare($sql);
                            $stm -> execute();
                            // print the result
                            echo $stm -> rowCount();
                            ?>
                            
                        Products</p>
                        <br>
                        <br>
                    </div>
                    <a href="prducts.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->

<?php
 include('footer.php');
 }
 else
 {
    echo "<div style='text-align: center;
        font-family: sans-serif;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        margin-top: 0;
        background-color: #f2dede;
        border-color: #ebccd1;'>
            <a href='../index.php' style='text-align: center; color: #a94442;'> Please Login </a> 
        </div>" ;
 }
?>