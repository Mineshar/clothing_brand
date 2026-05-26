<?php
session_start();
include("db.php");

// 🔐 MUST BE LOGGED IN
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['username'];

$result = mysqli_query($conn, "
SELECT * FROM orders
WHERE user = '$user'
ORDER BY order_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo $user; ?></h2>

<h3>Your Orders</h3>

<table border="1" cellpadding="10">
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

<br>

<a href="index.php">Back to Shop</a> |
<a href="logout.php">Logout</a>

</body>
</html>