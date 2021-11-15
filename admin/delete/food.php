<?php
require_once __DIR__."/../utils/login_check.php";

if(isset($_POST['submit'])){
    $id = $conn -> real_escape_string($_POST['id']);

    $sql = "DELETE FROM food WHERE id='$id'";
    if($conn -> query($sql)){
        $_SESSION['message'] = array(
            "msg"=>"Successfully deleted",
            "class"=>"bg-success"
        );
        header('location: '.SITEURL."admin/foods.php");
    }
}
$_SESSION['message'] = array(
    "msg"=>"Invalid request",
    "class"=>"bg-danger"
);
header('location: '.SITEURL."admin/foods.php");
?>