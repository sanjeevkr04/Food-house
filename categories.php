<?php
$menuId = 1;

require_once __DIR__."/components/menu.php";
?>

<div class="container section">
    <div class="categories">
        <?php
            $sql = "SELECT id, title, image_name FROM category";
            $res = $conn -> query($sql);

            while($cat = $res->fetch_assoc()){
            ?>
                <a href="<?php echo SITEURL."foods.php?c=".$cat['id'] ?>" class="card" style="background: url('./images/category/<?php echo $cat['image_name'] ?>')">
                    <h3><?php echo $cat['title'] ?></h3>
                </a>
            <?php
            }
        ?>
    </div>
</div>

<?php require_once __DIR__."/components/foter.php" ?>