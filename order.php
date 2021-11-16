<?php
$menuId = -1;

require_once __DIR__."/components/menu.php";

if(isset($_POST['submit'])){
    $id = $conn -> real_escape_string($_POST['id']);
    $price = $conn -> real_escape_string($_POST['price']);
    $qty = $conn -> real_escape_string($_POST['qty']);
    $name = $conn -> real_escape_string($_POST['name']);
    $email = $conn -> real_escape_string($_POST['email']);
    $phone = $conn -> real_escape_string($_POST['phone']);
    $address = $conn -> real_escape_string($_POST['address']);

    $total = (float)$price * (int)$qty;

    $sql = "INSERT INTO orders 
    (food_id, quantity, customer_name, customer_email, customer_phone, customer_address, total_bill) VALUES
    ('$id', '$qty', '$name', '$email', '$phone', '$address', '$total')";

    $res = $conn -> query($sql);
}
?>

<div class="container">
<?php
if($res){
    ?>
        success
    <?php
}else{
    ?>
        error
    <?php
}
?>    
</div>

<?php require_once __DIR__."/components/foter.php" ?>