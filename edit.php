<?php
include("db.php");

$id = $_GET['id'];

// FETCH DATA
$result = mysqli_query($conn, "SELECT * FROM laruga_villarobe WHERE id=$id");
$row = mysqli_fetch_assoc($result);

// UPDATE
if (isset($_POST['update'])) {

    // ✅ MATCH THESE WITH YOUR INPUT NAMES
    $brand_name = $_POST['brand_name'];
    $category   = $_POST['category'];
    $color      = $_POST['color'];
    $size       = $_POST['size'];
    $price      = $_POST['price'];

    // ✅ MATCH THESE WITH YOUR DATABASE COLUMNS
    $sql = "UPDATE laruga_villarobe SET 
            brand_name='$brand_name',
            category='$category',
            color='$color',
            size='$size',
            price='$price'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>

<h2>Edit Product</h2>

<form method="POST">

    <!-- ✅ IMPORTANT: name MUST match $_POST -->
    <input type="text" name="brand_name" value="<?php echo $row['brand_name']; ?>" required><br><br>

    <input type="text" name="category" value="<?php echo $row['category']; ?>" required><br><br>

    <input type="text" name="color" value="<?php echo $row['color']; ?>" required><br><br>

    <input type="text" name="size" value="<?php echo $row['size']; ?>" required><br><br>

    <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required><br><br>

    <button type="submit" name="update">Update</button>

</form>

<br>
<a href="index.php">Back</a>

</body>
</html>