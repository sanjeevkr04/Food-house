<?php 
$title = "New admin | Food House";
require_once __DIR__."/../components/menu.php";

if(!$isSuperUser){
    die("Un Authorize Access");
}

$sidebar_id = 2;
require_once __DIR__."/../components/sidebar.php";

define('ADMIN', "admin.php");

if(isset($_POST['submit'])){

    $username = $conn -> real_escape_string($_POST['username']);
    $name = $conn -> real_escape_string($_POST['name']);
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];

    if(mysqli_num_rows($conn -> query("SELECT id FROM admin WHERE username='$username'"))){
        $error = "Username already exists.";
    }else if($pass1 == $pass2){
        $md5_pass = $conn -> real_escape_string(md5($pass1));
        $sql = "INSERT INTO admin (username, name, password) VALUES('$username', '$name', '$md5_pass')";
        if($res = $conn -> query($sql)){
            redirectToAdmin("Added new admin '$username' successfully.", "bg-sucess", ADMIN);
        }else{
            redirectToAdmin("Something went wrong.", "bg-danger", ADMIN);
        }
    }else{
        $error = "Both password should be same.";
    }
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>Add new admin</h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST">
            <table class="form-table">
                <tr>
                    <td>Username : </td>
                    <td><input type="text" name="username" id="username" placeholder="Enter username" required></td>
                </tr>
                <tr>
                    <td>Full name : </td>
                    <td><input type="text" name="name" id="name" placeholder="Enter name" required></td>
                </tr>
                <tr>
                    <td>Password : </td>
                    <td><input type="password" minlength="6" name="password1" id="pass1" placeholder="Enter password" required></td>
                </tr>
                <tr>
                    <td>Repeat Password : </td>
                    <td><input type="password" minlength="6" name="password2" id="pass1" placeholder="Enter password again" required></td>
                </tr>
            </table>   
        </form>
    </div>
</div>
<?php require_once __DIR__."/../components/footer.php" ?>