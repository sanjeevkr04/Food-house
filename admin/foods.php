<?php 
$title = "Foods | Food House";
include('components/menu.php');

$sidebar_id = 4;
include('components/sidebar.php');

define('IMG_TARGET', "../images/food/");
?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>Foods</h1>
            <a class="btn btn-outline btn-secondary" href="<?php echo SITEURL."admin/add/food.php" ?>">Add new</a>
        </div>

    <?php
        $sql = "SELECT 
        f.id, 
        f.title, 
        f.image_name, 
        f.price,  
        f.active, 
        c.title as category 
        from food f inner JOIN category c on f.category_id = c.id
        ORDER BY f.title";
        if($res = $conn -> query($sql)){
            ?>
            <div class="summary">
                <h3>Total foods : <?php echo mysqli_num_rows($res) ?></h3>
            </div>
            <table>
                <tr>
                    <th id="sn">S.N</th>
                    <th id="name">Name</th>
                    <th id="image">Image</th>
                    <th id="price">Price</th>
                    <th id="category">Category</th>
                    <th id="active">Active</th>
                </tr>
                <?php
                $sn = 1;
                while($food = $res -> fetch_assoc()){
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn++ ?></td>
                        <td><a href="<?php echo SITEURL."admin/edit/food.php?id=".$food['id'] ?>"><?php echo $food['title'] ?></a></td>
                        <td class="text-center">
                            <img src="<?php echo IMG_TARGET.$food['image_name'] ?>" alt="<?php echo $food['image_name'] ?>">
                        </td>
                        <td class="text-center">₹<?php echo $food['price'] ?></td>
                        <td class="text-center"><?php echo $food['category'] ?></td>
                        <td class="text-center"><?php echo $food['active']? file_get_contents("../icons/ok.svg") : file_get_contents("../icons/cancel.svg") ?></td>
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