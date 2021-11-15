<?php
	require_once __DIR__."/../../config/constants.php";
	$my_id = "";
	$my_username = "";
	$isSuperUser = 0;
	if (isset($_SESSION['user'])) {
		$session_user = $_SESSION['user'];
		$sql = "SELECT id, superuser FROM admin WHERE username='$session_user'";
		$res = $conn -> query($sql);
		if($user = $res -> fetch_assoc()){
			$my_id = $user['superuser'];
			$my_username = $session_user;
			$isSuperUser = $user['superuser'];
		}
	}else{
		header('location:' . SITEURL. '/admin/login.php');
	}
?>