<?php 
$title = "Orders | Food House";
include('components/menu.php');

$sidebar_id = 5;
include('components/sidebar.php');
?>
<div class="content-wrapper hide-scrollbar">
    <div class="main-content p-4">
        <div class="main-top">
            <h1>Orders</h1>
            <a class="btn btn-outline btn-secondary" href="<?php echo SITEURL."admin/add/order.php" ?>">Add new</a>
        </div>

    <?php
        $sql = "SELECT o.id, f.title as food, o.quantity, o.total_bill, o.date, o.status FROM orders o INNER JOIN food f ON o.food_id = f.id ORDER BY o.date DESC";
        if($res = $conn -> query($sql)){

            $revenueSql = "SELECT SUM(total_bill) FROM orders";
            $revenue = $conn -> query($revenueSql) -> fetch_row()[0];
            ?>
            <div class="summary">
                <h4>Total orders : <?php echo mysqli_num_rows($res) ?></h4>
                <h4 id="revenue">Revenue : ₹ <?php echo $revenue ?? 0 ?></h4>
            </div>
            <table>
                <tr>
                    <th id="sn">S.N</th>
                    <th id="food">Food</th>
                    <th id="qty">Quantity</th>
                    <th id="total">Total Bill</th>
                    <th id="date">Date</th>
                    <th id="status">Status</th>
                </tr>
                <?php
                $sn = 1;
                while($order = $res -> fetch_assoc()){
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $sn++ ?></td>
                        <td><a href="<?php echo SITEURL."admin/edit/order.php?id=".$order['id'] ?>"><?php echo $order['food'] ?></a></td>
                        <td class="text-center"><?php echo $order['quantity'] ?></td>
                        <td class="text-center">₹<?php echo $order['total_bill'] ?></td>
                        <td class="text-center"><?php echo $order['date'] ?></td>
                        <td class="text-center"><?php echo $order['status'] ?></td>
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