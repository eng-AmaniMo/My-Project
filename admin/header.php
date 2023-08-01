
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- MORRIS CHART STYLES-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body style="background-color: slategray;">
    <div id="wrapper" >
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0; background-color:slategray; height:10vh">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="background-color: rgb(50, 87, 112); height:10vh; padding-top:2.5rem" href="index.php">Dashboard</a>
            </div>
            <div style="color: white; padding: 12px 50px 12px 50px; float: right; font-size: 16px; display:flex;"> 
            <?php
             if($_SESSION['user_info'])
             {
                 echo "<h4 style='margin-right:500px'> Welcome " . $_SESSION['user_info']['full_name'] . "</h4>";
             }
            ?>
            <a href="../logout.php" style="background-color: rgb(50, 87, 112); margin-top:1.5rem" class="btn btn-success square-btn-adjust">Logout</a> </div>
        </nav>

        <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse" >
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="users.php"><i class="fa fa-users "></i>Users</a>
                    </li>
                    <li>
                        <a href="categories.php"><i class="fa fa-tasks"></i>Categories </a>
                    </li>
                    <li>
                        <a href="products.php"><i class="fa fa-bars"></i>Products</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bars"></i>Blogs</a>
                    </li>
                </ul>
            </div>
        </nav>