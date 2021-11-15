<?php 
$title = "Edit order | Food House";
require_once __DIR__."/../components/menu.php";

$sidebar_id = 5;
require_once __DIR__."/../components/sidebar.php";
require_once __DIR__."/../utils/file-uploader.php";

define('REDIRECT', 'orders.php');

$Order_status = array(
    'Ordered',
    'Preparing',
    'On delivery',
    'Dilivered'
);

if(isset($_POST['submit'])){

    $id = $conn -> real_escape_string($_POST['id']);
    $food_id = $conn -> real_escape_string($_POST['food']);
    $qty = $conn -> real_escape_string($_POST['qty']);
    $date = $conn -> real_escape_string($_POST['date']);
    $status = $conn -> real_escape_string($_POST['status']);
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

    $sql = "UPDATE orders SET 
    food_id='$food_id',
    quantity='$qty',
    date='$date',
    status='$status',
    total_bill='$total',
    customer_name='$c_name', 
    customer_email='$c_email', 
    customer_phone='$c_phone', 
    customer_address='$c_address' 
    WHERE id='$id'";

    if($conn -> query($sql)){
        redirectToAdmin("Food '$title' Updated successfully.", "bg-success", REDIRECT);
    }else{
        redirectToAdmin("Failed to update Food '$title'", "bg-danger", REDIRECT);
    }
    
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM orders WHERE id='$id'";
    if($res = $conn -> query($sql)){
        $order = $res -> fetch_assoc();
    }else{
        redirectToAdmin("Order not found.", "bg-warning", REDIRECT);
    }

}else{
    redirectToAdmin("Invalid request.", "bg-warning", REDIRECT);
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4 hide-scrollbar">
        <div class="main-top">
            <h1><?php echo $order['customer_name'] ?></h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" >
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
                            $default = $order['food_id'] == $food_id? "selected": "";

                            echo "<option value='$food_id' $default>$food_title</option>";
                        }
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td>Quantity : </td>
                    <td><input type="number" min="1" name="qty" id="qty" value="<?php echo $order['quantity'] ?>" required></td>
                </tr>
                <tr>
                    <td>Date & time : </td>
                    <td><input type="datetime-local" name="date" id="date" value="<?php echo $order['date'] ?>" required></td>
                </tr>
                <tr>
                    <td>Order status : </td>
                    <td>
                        <select name="status" id="status">
                        <?php
                            foreach($Order_status as $status){
                                $default = $status == $order['status']? "selected": "";
                                echo "<option value='$status' $default>$status</option>";
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="2" class="title">Customer details</td></tr>
                <tr>
                    <td>Name : </td>
                    <td><input type="text" name="name" id="name" placeholder="Full name" value="<?php echo $order['customer_name'] ?>" required></td>
                </tr>
                <tr>
                    <td>Email : </td>
                    <td><input type="email"  name="email" id="email" placeholder="abc.gmail.com" value="<?php echo $order['customer_email'] ?>" required></td>
                </tr>
                <tr>
                    <td>Phone : </td>
                    <td><input type="tel" name="phone" id="phone" placeholder="987654321" value="<?php echo $order['customer_phone'] ?>" required></td>
                </tr>
                <tr>
                    <td>Address : </td>
                    <td><textarea name="address" id="address" maxlength="1000" placeholder="Full address" required><?php echo $order['customer_address'] ?></textarea></td>
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
        <h2 class="text-center">Delete order?</h2>
        <div class="actions">
            <button class="btn btn-outline btn-success px-4" onclick="toggleModal()">cancel</button>
            <form id="modal-form" style="display:none;" method="POST" action="<?php echo SITEURL."admin/delete/order.php"?>">
                <input type="hidden" name="id" value="<?php echo $order['id'] ?>">
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