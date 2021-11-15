<?php 
$title = $_GET['u']." | Food House";
require_once __DIR__."/../components/menu.php";

require_once __DIR__."/../components/sidebar.php";

define('ADMIN', "admin.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT id, username, name, active, superuser FROM admin WHERE id='$id'";
    if($res = $conn -> query($sql)){
        $admin = $res -> fetch_assoc();
    }

}else{
    redirectToAdmin("Something went wrong.", "bg-danger", ADMIN);
}

if(!$isSuperUser && $id != $my_id){
    die("Un Authorize Access");
}

// Handle POST request
if(isset($_POST['submit'])){

    $id = $conn -> real_escape_string($_POST['id']);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if($pass1 == $pass2){
        $md5_pass = $conn -> real_escape_string(md5($pass1));
        $sql = "UPDATE admin SET password='$md5_pass' WHERE id='$id'";
        
        if($res = $conn -> query($sql)){
            redirectToAdmin("Passaward updated successfully.", "bg-sucess", ADMIN);
        }else{
            redirectToAdmin("Failed to update password.", "bg-danger", ADMIN);
        }
    }
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1><?php echo"Change password"?></h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" >
            <table class="form-table">
                <tr>
                    <td>Username : </td>
                    <td><input type="text" name="username" id="username" value="<?php echo $_GET['u'] ?>" disabled required></td>
                </tr>
                <tr>
                    <td>Password : </td>
                    <td><input type="password" name="pass1" id="pass1" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td>Confirm Password : </td>
                    <td><input type="password" name="pass2" id="pass2" placeholder="Confirm Password" required></td>
                </tr>
            </table>   
        </form>
    </div>
</div>
<?php require_once __DIR__."/../components/footer.php"; ?>