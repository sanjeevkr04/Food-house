<?php 
$title = $_GET['u']." | Food House";
require_once __DIR__."/../components/menu.php";

if(!$isSuperUser){
    die("Un Authorize Access");
}

$sidebar_id = 2;
require_once __DIR__."/../components/sidebar.php";

define('ADMIN', "admin.php");

if(isset($_POST['submit'])){

    $id = $conn -> real_escape_string($_POST['id']);
    $username = $conn -> real_escape_string($_POST['username']);
    $name = $conn -> real_escape_string($_POST['name']);
    $active = isset($_POST['active']);
    $superuser = isset($_POST['superuser']);

    $sql = "SELECT id, username FROM admin WHERE username='$username'";
    $res = $conn -> query($sql);

    if(mysqli_num_rows($res) == 0 || $res -> fetch_assoc()['id'] == $id){
        $update = "UPDATE admin SET username='$username', name='$name', active='$active', superuser='$superuser' WHERE id=$id";
        if($res_update = $conn -> query($update)){
            redirectToAdmin("Updated admin '$username' successfully.", "bg-sucess", ADMIN);
        }else{
            redirectToAdmin("Failed to update admin.", "bg-danger", ADMIN);
        }
    }else{
        $error = "Admin with username $username already exists.";
    }
    
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT id, username, name, active, superuser FROM admin WHERE id='$id'";
    if($res = $conn -> query($sql)){
        $admin = $res -> fetch_assoc();
    }else{
        redirectToAdmin("User not found.", "bg-warning", ADMIN);
    }

}else{
    redirectToAdmin("Something went wrong.", "bg-danger", ADMIN);
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1><?php echo $admin['name'] ?></h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" >
            <table class="form-table">
                <tr>
                    <td>Username : </td>
                    <td><input type="text" name="username" id="username" value="<?php echo $admin['username'] ?>" placeholder="Enter username" required></td>
                </tr>
                <tr>
                    <td>Full name : </td>
                    <td><input type="text" name="name" id="name" value="<?php echo $admin['name']?>" placeholder="Enter name" required></td>
                </tr>
                <tr>
                    <td>Is Active : </td>
                    <td><input type="checkbox" name="active" id="active" <?php echo $admin['active']? 'checked': '' ?>></td>
                </tr>
                <tr>
                    <td>Is Superuser : </td>
                    <td><input type="checkbox" name="superuser" id="superuser" <?php echo $admin['superuser']? 'checked': '' ?>></td>
                </tr>
            </table>   
        </form>
        <div class="actions">
            <a class="btn btn-outline px-4" href="<?php echo SITEURL."admin/edit/change-password.php?id=".$admin['id']."&u=".$admin['username'] ?>">Change password</a>
            <button class="btn btn-outline btn-danger px-4" onclick="toggleModal()">delete</button>
        </div>
    </div>
</div>

<div class="modal-back" id="modal">
    <div class="modal">
        <h2 class="text-center">Delete admin?</h2>
        <h3 class="text-center text-danger"><?php echo $admin['username'] ?></h3>
        <div class="actions">
            <button class="btn btn-outline btn-success px-4" onclick="toggleModal()">cancel</button>
            <form id="modal-form" style="display:none;" method="POST" action="<?php echo SITEURL."admin/delete/admin.php"?>">
                <input type="hidden" name="id" value="<?php echo $admin['id'] ?>">
                <input type="hidden" name="username" value="<?php echo $admin['username'] ?>">
            </form>
            <button class="btn btn-outline btn-danger px-4" name="submit" form="modal-form">delete</button>
        </div>
    </div>
</div>

<?php require_once __DIR__."/../components/footer.php"; ?>