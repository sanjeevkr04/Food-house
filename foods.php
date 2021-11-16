<?php
$menuId = 2;

$sql = "SELECT id, title, image_name, price FROM food";

if(isset($_GET['c'])){
    $category  = $_GET['c'];
    $sql = "SELECT id, title, image_name, price FROM food WHERE category_id = $category";
}

if(isset($_GET['search'])){
    $search  = $_GET['search'];
    $sql = "SELECT id, title, image_name, price FROM food WHERE title LIKE '%$search%'";
}

require_once __DIR__."/components/menu.php";
?>

<div class="container section">
    <div class="foods">
        <?php
            $res = $conn -> query($sql);

            while($food = $res->fetch_assoc()){
            ?>
                <div class="food">
                    <div id="<?php echo "food-".$food['id'] ?>" class="food-card">
                        <div class="food-card-front">
                            <img src="./images//food/<?php echo $food['image_name'] ?>" alt="">
                            <h3><?php echo $food['title'] ?></h3>
                            <div class="price">
                                <p>Price</p>
                                <p>₹ <?php echo $food['price'] ?></p>
                            </div>
                            <button onclick="flipcard('<?php echo 'food-'.$food['id'] ?>')">Order now</button>
                        </div>
                        <div class="food-card-back">
                            <div class="title">
                                <h3><?php echo $food['title'] ?></h3>
                                <span onclick="flipcard('<?php echo 'food-'.$food['id'] ?>')" ><?php echo file_get_contents(SITEURL."icons/flip.svg") ?></span>
                            </div>
                            <form action="<?php echo SITEURL."order.php" ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $food['id'] ?>">
                                <input type="hidden" name="price" value="<?php echo $food['price'] ?>">
                                <fieldset>
                                    <legend>Order details</legend>

                                    <label for="qty-<?php echo $food['id']?>">Quantity :</label>
                                    <input type="number" name="qty" id="qty-<?php echo $food['id']?>" min="1" value="1" oninput="onQtyChange(this, <?php echo $food['id'] ?>, <?php echo $food['price'] ?>)" required>

                                    <label for="total-<?php echo $food['id']?>">Amount :</label>
                                    <input disabled type="text" id="total-<?php echo $food['id']?>" value="₹ <?php echo $food['price'] ?>" class="disabled-input">
                                </fieldset>
                                <fieldset>
                                    <legend>Customer details</legend>

                                    <label for="name-<?php echo $food['id']?>">Name :</label>
                                    <input type="text" name="name" id="name-<?php echo $food['id']?>" required>

                                    <label for="email-<?php echo $food['id']?>">Email :</label>
                                    <input type="email" name="email" id="email-<?php echo $food['id']?>" required>

                                    <label for="phone-<?php echo $food['id']?>">Phone no.:</label>
                                    <input type="tel" name="phone" id="phone-<?php echo $food['id']?>" required>

                                    <label for="address-<?php echo $food['id']?>">Address :</label>
                                    <textarea name="address" id="address-<?php echo $food['id']?>" minlength="10" maxlength="1000"></textarea>
                                </fieldset>
                                <input type="submit" name="submit" value="Place order">
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
</div>

<?php require_once __DIR__."/components/foter.php" ?>

<script>
    function flipcard(id){
        document.getElementById(id).classList.toggle("flip")
    }

    function onQtyChange(selectedInput, id, price){
        document.getElementById(`total-${id}`).value = `₹ ${selectedInput.value * price}`;
    }
</script>