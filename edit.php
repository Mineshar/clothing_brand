<?php
session_start();
include("db.php");

// CHECK LOGIN
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// CHECK ID
if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit();
}

$id = intval($_GET['id']);

// FETCH PRODUCT
$result = mysqli_query($conn, "SELECT * FROM laruga_villarobe WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Product not found.";
    exit();
}

$message = "";
$message_type = "";

// UPDATE PRODUCT
if (isset($_POST['update'])) {

    $brand_name = trim($_POST['brand_name']);
    $category   = trim($_POST['category']);
    $color      = trim($_POST['color']);
    $size       = trim($_POST['size']);
    $price      = trim($_POST['price']);
    $stock      = trim($_POST['stock']);

    if (
        empty($brand_name) ||
        empty($category) ||
        empty($color) ||
        empty($size) ||
        empty($price) ||
        empty($stock)
    ) {
        $message = "All fields are required!";
        $message_type = "error";

    } elseif (!is_numeric($price)) {
        $message = "Price must be numeric!";
        $message_type = "error";

    } elseif (!is_numeric($stock)) {
        $message = "Stock must be numeric!";
        $message_type = "error";

    } else {

        $stmt = $conn->prepare("
            UPDATE laruga_villarobe
            SET brand_name=?, category=?, color=?, size=?, price=?, stock=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "sssssii",
            $brand_name,
            $category,
            $color,
            $size,
            $price,
            $stock,
            $id
        );

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Update failed!";
            $message_type = "error";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;

            /* 🖼️ CLOTHING BRAND BACKGROUND ONLY */
            background:
            linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
            url('https://images.unsplash.com/photo-1521335629791-ce4aec67dd49?q=80&w=1600&auto=format&fit=crop');

            background-size:cover;
            background-position:center;
        }

        .container{
            width:450px;
            padding:30px;
            border-radius:20px;
            background:rgba(255,255,255,0.12);
            backdrop-filter:blur(18px);
            border:1px solid rgba(255,255,255,0.2);
            box-shadow:0 20px 60px rgba(0,0,0,0.5);
        }

        h2{
            text-align:center;
            color:#fff;
            margin-bottom:20px;
            font-size:26px;
        }

        label{
            display:block;
            margin-top:10px;
            margin-bottom:5px;
            color:#e5e7eb;
            font-size:13px;
        }

        input{
            width:100%;
            padding:12px;
            border-radius:10px;
            border:1px solid rgba(255,255,255,0.2);
            background:rgba(0,0,0,0.3);
            color:white;
            outline:none;
        }

        input:focus{
            border-color:#60a5fa;
            box-shadow:0 0 10px rgba(96,165,250,0.4);
        }

        button{
            width:100%;
            margin-top:20px;
            padding:12px;
            border:none;
            border-radius:12px;
            background:linear-gradient(135deg,#4e73df,#6c5ce7);
            color:white;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            transform:translateY(-2px);
        }

        .message{
            padding:12px;
            border-radius:10px;
            margin-bottom:15px;
            text-align:center;
            color:white;
        }

        .error{ background:#e74c3c; }
        .success{ background:#2ecc71; }

        a{
            display:block;
            text-align:center;
            margin-top:15px;
            color:white;
            text-decoration:none;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>✏️ Edit Product</h2>

    <?php if ($message != ""): ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Brand Name</label>
        <input type="text" name="brand_name" value="<?php echo $row['brand_name']; ?>">

        <label>Category</label>
        <input type="text" name="category" value="<?php echo $row['category']; ?>">

        <label>Color</label>
        <input type="text" name="color" value="<?php echo $row['color']; ?>">

        <label>Size</label>
        <input type="text" name="size" value="<?php echo $row['size']; ?>">

        <label>Price</label>
        <input type="number" name="price" value="<?php echo $row['price']; ?>">

        <label>Stock</label>
        <input type="number" name="stock" value="<?php echo $row['stock']; ?>">

        <button type="submit" name="update">Update Product</button>

    </form>

    <a href="index.php">← Back to Dashboard</a>

</div>

</body>
</html>