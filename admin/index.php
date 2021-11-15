<?php 
$title = "Food House Administration";
include('components/menu.php');

$sidebar_id = 1;
include('components/sidebar.php');

define("CATEGORY_IMG", "../images/category/");
define("FOOD_IMG", "../images/food/");

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4 ">
        <div class="main-top">
            <h1>Dashboard</h1>
        </div>
        <div class="overview summary">
            <?php
                $sql = "SELECT (SELECT COUNT(*) FROM food WHERE active=1) as foods, COUNT(*) as orders, SUM(total_bill) as revenue FROM orders";
                if($res = $conn -> query($sql)){
                    $row = $res -> fetch_row();
                }else{
                    echo $conn -> error;
                }
            ?>
            <div class="card">
                <h2><?php echo $row[0] ?></h2>
                <h3>Foods</h3>
            </div>
            <div class="card">
                <h2><?php echo $row[1] ?></h2>
                <h3>Orders</h3>
            </div>
            <div class="card">
                <h2>₹ <?php echo $row[2] ?? 0 ?></h2>
                <h3>Tootal revenue</h3>
            </div>
        </div>
        <!-- <div>
            <canvas id="myChart"></canvas>
        </div> -->
        <div class="featured">
            <h2>Featured Categories</h2>
            <div class="card-wrapper">
                <?php
                    $maxCards = 3;
                    $sql = "SELECT id, title, image_name FROM category WHERE featured=1 LIMIT 3";
                    $res = $conn -> query($sql);
                    $count = mysqli_num_rows($res);
                    
                    for ($i=0; $i < $count; $i++) { 
                        $cat = $res -> fetch_assoc();
                        ?>
                        <a class='f-card' href="<?php echo SITEURL."admin/edit/featured.php?type=category&id=".$cat['id'] ?>">
                            <img src="<?php echo CATEGORY_IMG.$cat['image_name'] ?>" alt="<?php $cat['title'] ?>">
                            <div class="title">
                                <?php echo $cat['title'] ?>
                            </div>
                        </a>
                        <?php
                    }

                    for ($i=0; $i < $maxCards - $count; $i++) {
                        ?>
                        <a class='f-card' href="<?php echo SITEURL."admin/edit/featured.php?type=category" ?>">
                            <div class="placeholder">
                                <?php echo file_get_contents("../icons/foods.svg") ?>
                            </div>
                        </a>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class="featured">
            <h2>Featured Foods</h2>
            <div class="card-wrapper">
            <?php
                    $maxCards = 6;
                    $sql = "SELECT id, title, image_name FROM food WHERE featured=1 LIMIT 6";
                    $res = $conn -> query($sql);
                    $count = mysqli_num_rows($res);
                    
                    for ($i=0; $i < $count; $i++) { 
                        $food = $res -> fetch_assoc();
                        ?>
                        <a class='f-card' href="<?php echo SITEURL."admin/edit/featured.php?type=food&id=".$food['id'] ?>">
                            <img src="<?php echo FOOD_IMG.$food['image_name'] ?>" alt="<?php $food['title'] ?>">
                            <div class="title">
                                <?php echo $food['title'] ?>
                            </div>
                        </a>
                        <?php
                    }

                    for ($i=0; $i < $maxCards - $count; $i++) {
                        ?>
                        <a class='f-card' href="<?php echo SITEURL."admin/edit/featured.php?type=food" ?>">
                            <div class="placeholder">
                                <?php echo file_get_contents("../icons/food.svg") ?>
                            </div>
                        </a>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include('components/footer.php'); ?>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/chartSetup.js"></script> -->