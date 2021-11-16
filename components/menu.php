<?php
    include_once("config/constants.php");

    if(!isset($menuId)){
        $menuId = -1;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?php echo SITEURL."/styles/style.css" ?>>
    <title>Food House</title>
</head>
<body>
    <div class="page">
        <header>
            <div class="header">
                <img src='images/logo.png' alt="" srcset="">
                <h1>Food house</h1>
                <ul>
                    <li <?php echo $menuId == 0? 'style="border-bottom: 3px solid"': "" ?>><a href="<?php echo SITEURL ?>">Home</a></li>
                    <li <?php echo $menuId == 1? 'style="border-bottom: 3px solid"': "" ?>><a href="<?php echo SITEURL."categories.php" ?>">Categories</a></li>
                    <li <?php echo $menuId == 2? 'style="border-bottom: 3px solid"': "" ?>><a href="<?php echo SITEURL."foods.php" ?>">Food</a></li>
                    <li <?php echo $menuId == 3? 'style="border-bottom: 3px solid"': "" ?>><a href="<?php echo SITEURL."contact.php" ?>">Contact</a></li>
                </ul>
            </div>
            <form action="<?php echo SITEURL."foods.php" ?>" class="searchbar" method="get">
                <input class="search" type="text" name="search" placeholder="Search for foods..." value=<?php echo isset($search)? $search: "" ?>>
                <input class="submit" type="submit" value="Search">
            </form>
        </header>