<?php 
$title = "Feedbacks | Food House";
include('components/menu.php');

$sidebar_id = 6;
include('components/sidebar.php');
?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>Feedbacks</h1>
        </div>

    <?php
        $sql = "SELECT * FROM feedback";
        if($res = $conn -> query($sql)){
            ?>
            <div class="summary">
                <h3>Total feedbacks : <?php echo mysqli_num_rows($res) ?></h3>
            </div>
            <table>
                <tr>
                    <th id="sn">S.N</th>
                    <th id="name">Name</th>
                    <th id="email">Email</th>
                    <th id="date">Date & Time</th>
                </tr>
                <?php
                $sn = 1;
                while($feed = $res -> fetch_assoc()){
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn++ ?></td>
                        <td><a href="<?php echo SITEURL."admin/edit/feedback.php?id=".$feed['id'] ?>"><?php echo $feed['name'] ?></a></td>
                        <td><?php echo $feed['email'] ?></td>
                        <td class="text-center" ><?php echo $feed['date'] ?></td>
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