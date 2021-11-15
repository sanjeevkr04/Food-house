<?php 

    $count = 0;

    function spawn_li($icon, $title, $link = "",){
        global $sidebar_id, $count;
        $count++;

        $marker = $sidebar_id == $count? "marker": "";
        echo "
        <li class=".$marker.">
            <a href=".$link.">". file_get_contents("$icon")."".$title."</a>
        </li>
        ";
    }
?>

<div class="sidebar hide-scrollbar p-5">
    <ul>
        <?php
            spawn_li(SITEURL."icons/dashboard.svg", "Dashboard", SITEURL."admin/");
            spawn_li(SITEURL."icons/person.svg", "Admins", SITEURL."admin/admins.php");
            spawn_li(SITEURL."icons/foods.svg", "Categories", SITEURL."admin/categories.php");
            spawn_li(SITEURL."icons/food.svg", "Foods", SITEURL."admin/foods.php");
            spawn_li(SITEURL."icons/moped.svg", "Orders", SITEURL."admin/orders.php");
            spawn_li(SITEURL."icons/feedback.svg", "Feedbacks", SITEURL."admin/feedbacks.php");
        ?>
    </ul>
</div>