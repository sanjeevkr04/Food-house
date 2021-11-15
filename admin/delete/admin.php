<?php
require_once __DIR__."/../utils/login_check.php";

if(!$isSuperUser){
    die("Un authorize");
}

if(isset($_POST['submit'])){
    $id = $conn -> real_escape_string($_POST['id']);
    $username = $conn -> real_escape_string($_POST['username']);

    $sql = "DELETE FROM admin WHERE id='$id' AND username='$username'";
    if($conn -> query($sql)){
        $_SESSION['message'] = array(
            "msg"=>"Successfully deleted $username",
            "class"=>"bg-success"
        );
        header('location: '.SITEURL."admin/admins.php");
    }

}
$_SESSION['message'] = array(
    "msg"=>"Invalid request",
    "class"=>"bg-danger"
);
header('location: '.SITEURL."admin/admins.php");

?>