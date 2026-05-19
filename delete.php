<?php
include("db.php");

// Check if ID exists
if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit();
}

$id = $_GET['id'];

// Get product first (for image)
$result = mysqli_query($conn, "SELECT * FROM laruga_villarobe WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found.";
    exit();
}

// DELETE IMAGE (optional but recommended)
$image_path = "uploads/" . $product['image'];
if (file_exists($image_path)) {
    unlink($image_path);
}

// DELETE PRODUCT FROM DATABASE
mysqli_query($conn, "DELETE FROM laruga_villarobe WHERE id = $id");

// Redirect back
header("Location: index.php");
exit();
?>