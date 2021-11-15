<?php 
$title = "Categories | Food House";
include('components/menu.php');

$sidebar_id = 3;
include('components/sidebar.php');

define('IMG_TARGET', "../images/category/");
?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>Categories</h1>
            <a class="btn btn-outline btn-secondary" href="<?php echo SITEURL."admin/add/category.php" ?>">Add new</a>
        </div>
        
        
    <?php
        $sql = "SELECT * FROM category";
        if($res = $conn -> query($sql)){
            ?>
            <div class="summary">
                <h3>Total categories : <?php echo mysqli_num_rows($res) ?></h3>
            </div>
            <table>
                <tr>
                    <th id="sn">S.N</th>
                    <th id="name">Name</th>
                    <th id="image">Image</th>
                    <th id="active">Active</th>
                </tr>
                <?php
                $sn = 1;
                while($category = $res -> fetch_assoc()){
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn++ ?></td>
                        <td><a href="<?php echo SITEURL."admin/edit/category.php?id=".$category['id'] ?>"><?php echo $category['title'] ?></a></td>
                        <td class="text-center"><img src="<?php echo IMG_TARGET.$category['image_name'] ?>" alt="<?php echo $category['image_name'] ?>"></td>
                        <td class="text-center"><?php echo $category['active']? file_get_contents("../icons/ok.svg") : file_get_contents("../icons/cancel.svg") ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }else{
            ?><p class="text-center">Nothing found</p><?php
        }
    ?>
    </div>
</div>
<?php include('components/footer.php'); ?>