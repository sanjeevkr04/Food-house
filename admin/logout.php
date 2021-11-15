<?php 
include('../config/constants.php');

if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
}

header('location:'.SITEURL.'admin/login.php');
?>