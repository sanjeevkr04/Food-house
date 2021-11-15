<?php 
$title = "Edit category | Food House";
require_once __DIR__."/../components/menu.php";

$sidebar_id = 3;
require_once __DIR__."/../components/sidebar.php";
require_once __DIR__."/../utils/file-uploader.php";

define('REDIRECT', 'categories.php');
define('IMG_TARGET', "../../images/category/");

if(isset($_POST['submit'])){

    $id = $conn -> real_escape_string($_POST['id']);
    $title = $conn -> real_escape_string($_POST['title']);
    $active = isset($_POST['active']);

    if(isset($_FILES['image'])){
        $img_src = $_FILES['image']['tmp_name'];
        $img_name = $conn -> real_escape_string($_FILES['image']['name']);

        if($img_name = upload_file(IMG_TARGET, $img_name, $img_src)){
            $conn -> query("UPDATE category SET image_name='$img_name' WHERE id='$id'");
        }


    }

    $sql = "UPDATE category SET title='$title', active='$active' WHERE id='$id'";

    if($conn -> query($sql)){
        redirectToAdmin("Category '$title' Updated successfully.", "bg-success", REDIRECT);
    }else{
        redirectToAdmin("Failed to update Category '$title'", "bg-danger", REDIRECT);
    }
    
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM category WHERE id='$id'";
    if($res = $conn -> query($sql)){
        $category = $res -> fetch_assoc();
    }else{
        redirectToAdmin("Category not found.", "bg-warning", REDIRECT);
    }

}else{
    redirectToAdmin("Invalid category.", "bg-warning", REDIRECT);
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1><?php echo $category['title'] ?></h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id ?>" >
            <table class="form-table">
                <tr>
                    <td>Title : </td>
                    <td><input type="text" name="title" id="title" value="<?php echo $category['title'] ?>" placeholder="Category title" required></td>
                </tr>
                <tr>
                    <td>Current Image : </td>
                    <td>
                        <a href="<?php echo IMG_TARGET.$category['image_name'] ?>" target="_blank">
                            <img src="<?php echo IMG_TARGET.$category['image_name'] ?>" alt="<?php echo $category['image_name'] ?>">
                        </a>
                        <input type="file" name="image" id="image" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td>Is Active : </td>
                    <td><input type="checkbox" name="active" id="active" <?php echo $category['active']? 'checked': '' ?>></td>
                </tr>
            </table>   
        </form>
        <div class="actions">
            <button class="btn btn-outline btn-danger px-4" onclick="toggleModal()">delete</button>
        </div>
    </div>

    <div class="modal-back" id="modal">
        <div class="modal">
            <h2 class="text-center">Delete category?</h2>
            <h3 class="text-center text-danger"><?php echo $category['title'] ?></h3>
            <div class="actions">
                <button class="btn btn-outline btn-success px-4" onclick="toggleModal()">cancel</button>
                <form id="modal-form" style="display:none;" method="POST" action="<?php echo SITEURL."admin/delete/category.php"?>">
                    <input type="hidden" name="id" value="<?php echo $category['id'] ?>">
                </form>
                <button class="btn btn-outline btn-danger px-4" name="submit" form="modal-form">delete</button>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__."/../components/footer.php"; ?>