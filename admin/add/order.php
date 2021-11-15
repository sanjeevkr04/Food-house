<?php 
$title = "New Food | Food House";
require_once __DIR__."/../components/menu.php";

$sidebar_id = 5;
require_once __DIR__."/../components/sidebar.php";

define('REDIRECT', 'orders.php');

if(isset($_POST['submit'])){

    $food_id = $conn -> real_escape_string($_POST['food']);
    $qty = $conn -> real_escape_string($_POST['qty']);
    $c_name = $conn -> real_escape_string($_POST['name']);
    $c_email = $conn -> real_escape_string($_POST['email']);
    $c_phone = $conn -> real_escape_string($_POST['phone']);
    $c_address = $conn -> real_escape_string($_POST['address']);

    // Total price
    try{
        $res = $conn -> query("SELECT price FROM food WHERE id='$food_id'");
        $price = $res -> fetch_assoc()['price'];
        $total = $price * (int)$qty;
    }
    catch(Exception $e){
        redirectToAdmin("Food not found.", "bg-danger", REDIRECT);
    }

    $sql = "INSERT INTO orders 
    (food_id, quantity, customer_name, customer_email, customer_phone, customer_address, total_bill) VALUES
    ('$food_id', '$qty', '$c_name', '$c_email', '$c_phone', '$c_address', '$total')";

    if($conn -> query($sql)){
        redirectToAdmin("Added new order", "bg-success", REDIRECT);
    }else{
        redirectToAdmin("Something went wrong.", "bg-danger", REDIRECT);
    }
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>New order</h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST">
            <table class="form-table">
                <tr>
                    <td>Food</td>
                    <td>
                    <select id="food" name="food" class="js-choice">
                    <?php
                        $sql = "SELECT id, title FROM food ORDER BY title";
                        $res = $conn -> query($sql);

                        while($food = $res -> fetch_assoc()){
                            $food_id = $food['id'];
                            $food_title = $food['title'];

                            echo "<option value='$food_id'>$food_title</option>";
                        }
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td>Quantity : </td>
                    <td><input type="number" min="1" name="qty" id="qty" value="1" required></td>
                </tr>
                <tr><td colspan="2" class="title">Customer details</td></tr>
                <tr>
                    <td>Name : </td>
                    <td><input type="text" name="name" id="name" placeholder="Full name" required></td>
                </tr>
                <tr>
                    <td>Email : </td>
                    <td><input type="email"  name="email" id="email" placeholder="abc.gmail.com" required></td>
                </tr>
                <tr>
                    <td>Phone : </td>
                    <td><input type="tel" name="phone" id="phone" placeholder="987654321" required></td>
                </tr>
                <tr>
                    <td>Address : </td>
                    <td><textarea name="address" id="address" maxlength="1000" placeholder="Full address" required></textarea></td>
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