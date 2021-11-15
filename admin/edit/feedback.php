<?php 
$title = "Edit Feedback | Food House";
require_once __DIR__."/../components/menu.php";

$sidebar_id = 6;
require_once __DIR__."/../components/sidebar.php";

define('REDIRECT', 'feedbacks.php');

if(isset($_POST['submit'])){

    $id = $conn -> real_escape_string($_POST['id']);
    $name = $conn -> real_escape_string($_POST['name']);
    $email = $conn -> real_escape_string($_POST['email']);
    $date = $conn -> real_escape_string($_POST['date']);
    $feedback = $conn -> real_escape_string($_POST['feedback']);

    $sql = "UPDATE feedback SET 
    name='$name',
    email='$email',
    date='$date',
    message='$feedback'
    WHERE id='$id'";

    if($conn -> query($sql)){
        redirectToAdmin("Feedback Updated successfully.", "bg-success", REDIRECT);
    }else{
        redirectToAdmin("Failed to update feedback", "bg-danger", REDIRECT);
    }
    
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM feedback WHERE id='$id'";
    if($res = $conn -> query($sql)){
        $feed = $res -> fetch_assoc();
    }else{
        redirectToAdmin("Feedback not found.", "bg-warning", REDIRECT);
    }

}else{
    redirectToAdmin("Invalid request.", "bg-warning", REDIRECT);
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1><?php echo $feed['name'] ?></h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id ?>" >
            <table class="form-table">
                <tr>
                    <td>Name : </td
                    >
                    <td><input type="text" name="name" id="name" placeholder="Full name" value="<?php echo $feed['name'] ?>" required></td>
                </tr>
                <tr>
                    <td>Email : </td>
                    <td><input type="email"  name="email" id="email" placeholder="abc.gmail.com" value="<?php echo $feed['email'] ?>" required></td>
                </tr>
                <tr>
                    <td>Date & time : </td>
                    <td><input type="datetime-local" name="date" id="date" value="<?php echo $feed['date'] ?>" required></td>
                </tr>
                <tr>
                    <td>Feedback : </td>
                    <td><textarea name="feedback" id="feedback" maxlength="1000" placeholder="Feedback message" required><?php echo $feed['message'] ?></textarea></td>
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
        <h2 class="text-center">Delete feedback?</h2>
        <div class="actions">
            <button class="btn btn-outline btn-success px-4" onclick="toggleModal()">cancel</button>
            <form id="modal-form" style="display:none;" method="POST" action="<?php echo SITEURL."admin/delete/feedback.php"?>">
                <input type="hidden" name="id" value="<?php echo $order['id'] ?>">
            </form>
            <button class="btn btn-outline btn-danger px-4" name="submit" form="modal-form">delete</button>
        </div>
    </div>
</div>

<?php require_once __DIR__."/../components/footer.php"; ?>