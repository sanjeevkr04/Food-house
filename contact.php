<?php
$menuId = 3;

require_once __DIR__."/components/menu.php";

if(isset($_POST['submit'])){
    $name = $conn -> real_escape_string($_POST['name']);
    $email = $conn -> real_escape_string($_POST['email']);
    $message = $conn -> real_escape_string($_POST['msg']);

    $sql = "INSERT INTO feedback 
    (name, email, message) VALUES
    ('$name', '$email', '$message')";

    if($conn -> query($sql)){
        $_SESSION['message'] = "Thank You for Contacting Us.";
        header("Location: ".SITEURL);
    }   
}

?>

<div class="container contact">
    <form action="" method="post">
        <h2>Contact us</h2>
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" require>
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" require>
        <label for="msg">Message: </label>
        <textarea name="msg" id="msg" minlength="10"></textarea>
        <input type="submit" value="Send" name="submit">
    </form>
</div>

<?php require_once __DIR__."/components/foter.php" ?>