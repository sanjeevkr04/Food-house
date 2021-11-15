<?php 
include('../config/constants.php');

if(isset($_SESSION['user'])){
    header('location:'. SITEURL . 'admin');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Food House</title>
    <link rel="stylesheet" href="../styles/login.css">
</head>
<body>
    <div class="container">
        <h1>Food House</h1>
        <form action="" method="post">
            <?php 
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            ?>
            <input id="username" class="input" type="text" name="username" required>
            <input id="password" class="input" type="password" name="password" required>
            <input class="btn" type="submit" value="Login" name="submit">
        </form>
    </div>
</body>
</html>

<?php
if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $res = $conn -> query($sql);

    if(mysqli_num_rows($res) == 1){
        $_SESSION['user'] = $username;
        header('location:'.SITEURL .'admin/');
    }else{
        $_SESSION['login'] = "<p class='error'>Invalid Credentials</p>";
    }
}
?>