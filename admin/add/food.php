<?php 
$title = "New Food | Food House";
require_once __DIR__."/../components/menu.php";

$sidebar_id = 4;
require_once __DIR__."/../components/sidebar.php";
require_once __DIR__."/../utils/file-uploader.php";

define('REDIRECT', 'foods.php');
define('IMG_TARGET', "../../images/food/");

if(isset($_POST['submit']) && isset($_FILES['image']['name'])){

    $title = $conn -> real_escape_string($_POST['title']);
    $price = $conn -> real_escape_string($_POST['price']);
    $category = $conn -> real_escape_string($_POST['category']);
    $description = $conn -> real_escape_string($_POST['description']);

    $source_path = $_FILES['image']['tmp_name'];
    $file_name = $conn -> real_escape_string($_FILES['image']['name']);
    

    if($file_name = upload_file(IMG_TARGET, $file_name, $source_path)){
        
        $sql = "INSERT INTO food (title, image_name, price, description, category_id) VALUES('$title', '$file_name', '$price', '$description', '$category')";

        if($conn -> query($sql)){
            redirectToAdmin("Added new food '$title'", "bg-success", REDIRECT);
        }else{
            redirectToAdmin("Something went wrong.", "bg-danger", REDIRECT);
        }
    }else{
        redirectToAdmin("Unable to upload file", "bg-danger", REDIRECT);
    }
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>Add new food</h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data">
            <table class="form-table">
                <tr>
                    <td>Title : </td>
                    <td><input type="text" name="title" id="title" placeholder="Food title" required></td>
                </tr>
                <tr>
                    <td>Image : </td>
                    <td><input type="file" accept="image/*" name="image" id="image" required></td>
                </tr>
                <tr>
                    <td>Price (in ₹) : </td>
                    <td><input type="number" step="any" min="0" name="price" id="price" placeholder="₹......" required></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                    <select id="categories" name="category" class="js-choice">
                    <?php
                        $sql = "SELECT id, title FROM category";
                        $res = $conn -> query($sql);

                        while($cat = $res -> fetch_assoc()){
                            $cat_id = $cat['id'];
                            $cat_title = $cat['title'];

                            echo "<option value='$cat_id'>$cat_title</option>";
                        }
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td>Description : </td>
                    <td><textarea name="description" id="desc" maxlength="1000" placeholder="Write something about this food...." required></textarea></td>
                </tr>
            </table>   
        </form>
    </div>
</div>
<?php require_once __DIR__."/../components/footer.php" ?>

<script>
    const element = document.querySelector('.js-choice');
  const choices = new Choices(element);
</script>