<?php 
    session_start();

    $host =  $_SERVER['SERVER_NAME'];
    define('SITEURL', 'http://'. $host .'/restaurant/');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-house');
    date_default_timezone_set('Asia/Kolkata');

    $conn = new mysqli($host, DB_USERNAME, DB_PASSWORD);

    if($conn -> connect_error){
        die("Connection failed".$conn->connect_eooro);
    }

    $conn->select_db(DB_NAME);
    
?>