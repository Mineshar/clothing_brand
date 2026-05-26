<?php
session_start();
include("db.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['username'];

$result = mysqli_query($conn, "
SELECT * FROM orders
WHERE user='$user'
ORDER BY order_date DESC
");
?>

<h2>My Orders</h2>

<table border="1">
<tr>
    <th>Product</th>
    <th>Category</th>
    <th>Color</th>
    <th>Size</th>
    <th>Qty</th>
    <th>Total</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['brand_name'] ?></td>
    <td><?= $row['category'] ?></td>
    <td><?= $row['color'] ?></td>
    <td><?= $row['size'] ?></td>
    <td><?= $row['quantity'] ?></td>
    <td>₱<?= $row['total_price'] ?></td>
    <td><?= $row['order_date'] ?></td>
</tr>
<?php } ?>
</table>