<?php
//connect to database

$dsn='mysql:host=localhost;dbname=home_furniture';
$user='root';
$pass='';
$option=array(
    PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8',
);
try{
$con=new PDO($dsn,$user,$pass,$option);

}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>