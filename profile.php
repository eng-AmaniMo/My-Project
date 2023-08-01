<!-- Header  -->
<?php 
    include('include/header.php'); 
    require('include/dbconnect.php');
    session_start();
    $user_id = $_SESSION['user_info']['id'];
?> 
        <div style="padding: 12px 50px 12px 50px; float: right; font-size: 16px;">
                <?php
                if($_SESSION['user_info'])
                {
                    echo "<h4 style='margin-right:650px'> Welcome " . $_SESSION['user_info']['full_name'] . "</h4>";
                }
                ?>
                <a href="logout.php" style="background-color: rgb(50, 87, 112); margin-top:1.5rem" class="btn btn-success square-btn-adjust">Logout</a> </div>
        </div>
       <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <?php
                                        $sql="select * from user where id=:id";
                                        $stm = $con -> prepare($sql);
                                        $stm -> execute(array("id" => $user_id));

                                        if($stm -> rowCount())
                                        {
                                            foreach ($stm -> fetchAll() as $row) 
                                            {
                                    ?>
                                        <tr>
                                        <th>Name</th>
                                        <td><?php echo $row['full_name']; ?></td>
                                        </tr><tr>
                                        <th>Username</th>
                                        <td><?php echo $row['username']; ?></td>
                                        </tr><tr>
                                        <th>Email</th>
                                        <td><?php echo $row['email']; ?></td>

                                        </tr><tr>
                                        <th>Password</th>
                                        <td><?php echo $row['password']; ?></td>
                                        </tr>
                                </thead>
                                <tbody>
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
        

<!-- Footer -->
<?php include('include/footer.php'); ?> 
