<?php 
$title = "Edit food | Food House";
require_once __DIR__."/../components/menu.php";

$sidebar_id = 3;
require_once __DIR__."/../components/sidebar.php";
require_once __DIR__."/../utils/file-uploader.php";

define('REDIRECT', 'foods.php');
define('IMG_TARGET', "../../images/food/");

if(isset($_POST['submit'])){

    $id = $conn -> real_escape_string($_POST['id']);
    $title = $conn -> real_escape_string($_POST['title']);
    $price = $conn -> real_escape_string($_POST['price']);
    $category = $conn -> real_escape_string($_POST['category']);
    $description = $conn -> real_escape_string($_POST['description']);
    $active = isset($_POST['active']);

    if(isset($_FILES['image'])){
        $img_src = $_FILES['image']['tmp_name'];
        $img_name = $conn -> real_escape_string($_FILES['image']['name']);

        if($img_name = upload_file(IMG_TARGET, $img_name, $img_src)){
            $conn -> query("UPDATE food SET image_name='$img_name' WHERE id='$id'");
        }else{
            $_SESSION['message'] = array(
                "msg"=>"Failed to update image",
                "class"=>"bg-warning"
            );
        }
    }

    $sql = "UPDATE food SET 
    title='$title',
    price='$price',
    category_id='$category',
    description='$description',
    active='$active', 
    WHERE id='$id'";

    if($conn -> query($sql)){
        redirectToAdmin("Food '$title' Updated successfully.", "bg-success", REDIRECT);
    }else{
        redirectToAdmin("Failed to update Food '$title'", "bg-danger", REDIRECT);
    }
    
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM food WHERE id='$id'";
    if($res = $conn -> query($sql)){
        $food = $res -> fetch_assoc();
    }else{
        redirectToAdmin("Food not found.", "bg-danger", REDIRECT);
    }

}else{
    redirectToAdmin("Invalid food id.", "bg-warning", REDIRECT);
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1><?php echo $food['title'] ?></h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id ?>" >
            <table class="form-table">
                <tr>
                    <td>Title : </td>
                    <td><input type="text" name="title" id="title" value="<?php echo $food['title'] ?>" placeholder="Food title" required></td>
                </tr>
                <tr>
                    <td>Current Image : </td>
                    <td>
                        <a href="<?php echo IMG_TARGET.$food['image_name'] ?>" target="_blank">
                            <img src="<?php echo IMG_TARGET.$food['image_name'] ?>" alt="<?php echo $food['image_name'] ?>">
                        </a>
                        <input type="file" name="image" id="image" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td>Price (in ₹) : </td>
                    <td><input type="number" min="0" step="any" name="price" id="price" value=<?php echo $food['price']?> placeholder="₹......" required></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                    <select id="categories" name="category" class="js-choice">
                    <?php
                        try{
                            $category_id = $food['category_id'];
                            $sql = "SELECT id, title FROM category";
                            $res = $conn -> query($sql);
                        }catch(Exception $e){
                            redirectToAdmin("Invalid not found.", "bg-warning", REDIRECT);
                        }

                        while($cat = $res -> fetch_assoc()){
                            $cat_id = $cat['id'];
                            $cat_title = $cat['title'];
                            $default = $cat_id == $food['category_id'] ? "selected": "";

                            echo "<option value='$cat_id' $default>$cat_title</option>";
                        }
                    ?>
                    </select>

                    </td>
                </tr>
                <tr>
                    <td>Description : </td>
                    <td><textarea name="description" id="desc" maxlength="1000" placeholder="Write something about this food...." required><?php echo $food['description'] ?></textarea></td>
                </tr>
                <tr>
                    <td>Is Active : </td>
                    <td><input type="checkbox" name="active" id="active" <?php echo $food['active']? 'checked': '' ?>></td>
                </tr>
            </table>   
        </form>
        <div class="actions">
            <button class="btn btn-outline btn-danger px-4" onclick="toggleModal()">delete</button>
        </div>
    </div>
</div>

<div class="modal-back" id="modal">
    <div class="modal">
        <h2 class="text-center">Delete food?</h2>
        <h3 class="text-center text-danger"><?php echo $food['title'] ?></h3>
        <div class="actions">
            <button class="btn btn-outline btn-success px-4" onclick="toggleModal()">cancel</button>
            <form id="modal-form" style="display:none;" method="POST" action="<?php echo SITEURL."admin/delete/food.php"?>">
                <input type="hidden" name="id" value="<?php echo $food['id'] ?>">
            </form>
            <button class="btn btn-outline btn-danger px-4" name="submit" form="modal-form">delete</button>
        </div>
    </div>
</div>

<?php require_once __DIR__."/../components/footer.php"; ?>

<script>
    const element = document.querySelector('.js-choice');
  const choices = new Choices(element);
</script>