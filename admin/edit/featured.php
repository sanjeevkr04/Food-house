<?php 
$title = "Edit Featured | Food House";
require_once __DIR__."/../components/menu.php";

require_once __DIR__."/../components/sidebar.php";

define('REDIRECT', 'index.php');

if(isset($_POST['submit'])){

    $food_id = $conn -> real_escape_string($_POST['food_id']);
    $type = $conn -> real_escape_string($_POST['type']);
    if(isset($_POST['default_id'])){
        $default_id = $conn -> real_escape_string($_POST['default_id']);

        if($default_id <> $food_id){
            $sql = "UPDATE $type SET featured=0 WHERE id='$default_id'";
            $conn -> query($sql);
        }else{
            redirectToAdmin("Updated successfully.", "bg-success", REDIRECT);
        }
    }

    $sql = "UPDATE $type SET featured=1 WHERE id='$food_id'";
    if($conn -> query($sql)){
        redirectToAdmin("Updated successfully.", "bg-success", REDIRECT);
    }else{
        redirectToAdmin("Failed to update.", "bg-danger", REDIRECT);
    }
    
}

if(isset($_GET['type'])){
    $type = $_GET['type'];

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT id, title FROM $type WHERE id='$id'";
        if($res = $conn -> query($sql)){
            $default_food = $res -> fetch_assoc();
        }else{
            redirectToAdmin("Food not found.", "bg-warning", REDIRECT);
        }
    }

}else{
    redirectToAdmin("Invalid request.", "bg-warning", REDIRECT);
}

?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1><?php echo isset($default_food) ? $default_food['title'] : "Select ".$type ?></h1>
            <input type="submit" form="admin-form" name="submit" value="Save" class="btn btn-outline btn-secondary px-4">
        </div>
        <?php require __DIR__."/../components/error.php"; ?>
        <form id="admin-form" action="" method="POST">
            <?php 
                if(isset($_GET['id'])){
                    echo "<input type='hidden' name='default_id' value='$id' >";
                }
            ?>
            <input type="hidden" name='type' value="<?php echo $type ?>" >
            <table class="form-table" style="margin-top: 3rem;">
                <tr>
                    <td  style="text-transform: capitalize;"><?php echo $type ?></td>
                    <td>
                    <select id="food" name="food_id" class="js-choice">
                    <?php
                        if(isset($default_food)){
                            $food_id = $default_food['id'];
                            $food_title = $default_food['title'];
                            echo "<option value='$food_id' selected>$food_title</option>";
                        }

                        $sql = "SELECT id, title FROM $type WHERE featured=0 ORDER BY title";
                        if($res = $conn -> query($sql)){
                            while($food = $res -> fetch_assoc()){
                                $food_id = $food['id'];
                                $food_title = $food['title'];
    
                                echo "<option value='$food_id'>$food_title</option>";
                            }
                        }
                    ?>
                    </select>
                    </td>
                </tr>
            </table>   
        </form>
    </div>
</div>

<?php require_once __DIR__."/../components/footer.php"; ?>

<script>
    const element = document.querySelector('.js-choice');
    const choices = new Choices(element);
</script>