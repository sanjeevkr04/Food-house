<?php 
$title = "Admins | Food House";
require_once __DIR__."/components/menu.php";

$sidebar_id = 2;
require_once __DIR__."/components/sidebar.php";
?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>Admins</h1>
            <?php
            if($isSuperUser){
                ?><a class="btn btn-outline btn-secondary" href="<?php echo SITEURL."admin/add/admin.php" ?>">Add new</a><?php
            }
            ?>
        </div>
        
    <?php
        $sql = "SELECT id, username, name, active, superuser FROM admin";
        if($res = $conn -> query($sql)){
            ?>
            <div class="summary">
                <h3>Admin count : <?php echo mysqli_num_rows($res) ?></h3>
            </div>
            <table class="table-gray">
                <tr>
                    <th id="sn">S.N</th>
                    <th id="username">Username</th>
                    <th id="name">Name</th>
                    <th id="active">Active</th>
                    <th id="superuser">Superuser</th>
                </tr>
                <?php
                $sn = 1;
                while($admin = $res -> fetch_assoc()){
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn++ ?></td>
                        <td>
                        <?php
                        if($isSuperUser){
                            ?><a href="<?php echo SITEURL."admin/edit/admin.php?id=".$admin['id']."&u=".$admin['username'] ?>"><?php echo $admin['username'] ?></a><?php
                        }else{
                            ?><?php echo $admin['username'] ?><?php
                        }
                        ?>
                        </td>
                        <td><?php echo $admin['name'] ?></td>
                        <td class="text-center"><?php echo $admin['active']? file_get_contents("../icons/ok.svg") : file_get_contents("../icons/cancel.svg") ?></td>
                        <td class="text-center"><?php echo $admin['superuser']? file_get_contents("../icons/ok.svg") : file_get_contents("../icons/cancel.svg") ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }else{
            ?><p class="text-center">Nothing found</p><?php
        }
    ?>

    </div>
</div>
<?php include('components/footer.php'); ?>