<?php 
$title = "New Category | Food House";
require_once __DIR__."/../components/menu.php";

$sidebar_id = 3;
require_once __DIR__."/../components/sidebar.php";
require_once __DIR__."/../utils/file-uploader.php";

define('CATEGORY', 'categories.php');
define('IMG_TARGET', "../../images/category/");

if(isset($_POST['submit']) && isset($_FILES['image']['name'])){

    $title = $conn -> real_escape_string($_POST['title']);
    $source_path = $_FILES['image']['tmp_name'];
    $file_name = $conn -> real_escape_string($_FILES['image']['name']);
    

    if($file_name = upload_file(IMG_TARGET, $file_name, $source_path)){
        $sql = "INSERT INTO category (title, image_name) VALUES('$title', '$file_name')";
        if($conn -> query($sql)){
            redirectToAdmin("Added new category '$title'", "bg-success", CATEGORY);
        }else{
            redirectToAdmin("Something went wrong.", "bg-danger", CATEGORY);
        }
    }else{
        redirectToAdmin("Unable to upload file", "bg-danger", CATEGORY);
    }
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>Add new category</h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data">
            <table class="form-table">
                <tr>
                    <td>Title : </td>
                    <td><input type="text" name="title" id="title" placeholder="Category title" required></td>
                </tr>
                <tr>
                    <td>Image : </td>
                    <td><input type="file" accept="image/*" name="image" id="image" required></td>
                </tr>
            </table>   
        </form>
    </div>
</div>
<?php require_once __DIR__."/../components/footer.php" ?>