<?php
require_once __DIR__."/../utils/login_check.php";

$username = $_SESSION['user'];
$sidebar_id = 0;

if(!isset($title)){
	$title = "Food House";
}

function redirectToAdmin($message, $class, $target){
    $_SESSION['message'] = array(
        "msg"=>$message,
        "class"=>$class
    );
    header('location: '.SITEURL."admin/".$target);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
	<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

	<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script> -->

	<link rel="stylesheet" href=<?php echo SITEURL."styles/admin.css" ?>>
	<script src="<?php echo SITEURL."js/actions.js" ?>"></script>
	<title><?php echo $title ?></title>
</head>
<body>
	<div class="page">
		<header>
			<div class="header">
				<h2>Food House Administration</h2>
				<div class="menu">
					Welcome, <?php echo $my_username ?> 
					<a class="pl-2" href="<?php echo SITEURL."admin/edit/change-password.php?id=".$my_id."&u=".$my_username ?>">change password</a>
					<a class="pl-2" href="<?php echo SITEURL ?>admin/logout.php">logout</a>
				</div>
			</div>
		</header>
		<div class="container">