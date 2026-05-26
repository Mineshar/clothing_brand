<?php
session_start();

// 🔐 CHECK IF USER HAS VALID ROLE
if (!isset($_SESSION['role']) ||
    ($_SESSION['role'] != "admin" && $_SESSION['role'] != "customer")) {

    header("Location: login.php");
    exit();
}
?>
include("db.php");

if (!isset($_GET['id'])) {

    echo "No product selected.";
    exit();
}

$id = intval($_GET['id']);

// FETCH PRODUCT

$result = mysqli_query($conn,
"SELECT * FROM laruga_villarobe WHERE id = $id");

$row = mysqli_fetch_assoc($result);

if (!$row) {

    echo "Product not found.";
    exit();
}

// UPDATE PRODUCT

$message = "";
$message_type = "";

if (isset($_POST['update'])) {

    $brand_name = htmlspecialchars(trim($_POST['brand_name']));
    $category   = htmlspecialchars(trim($_POST['category']));
    $color      = htmlspecialchars(trim($_POST['color']));
    $size       = htmlspecialchars(trim($_POST['size']));
    $price      = htmlspecialchars(trim($_POST['price']));
    $stock      = htmlspecialchars(trim($_POST['stock']));

    // VALIDATION

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
            SET
                brand_name = ?,
                category   = ?,
                color      = ?,
                size       = ?,
                price      = ?,
                stock      = ?
            WHERE id = ?
        ");

        $stmt->bind_param(
            "ssssdii",
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

            $message = "Database Error!";
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

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{

    min-height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=1600&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
}

/* 📦 CONTAINER */

.container{

    width:450px;

    background:rgba(255,255,255,0.12);

    backdrop-filter:blur(18px);

    padding:35px;

    border-radius:22px;

    border:1px solid rgba(255,255,255,0.2);

    box-shadow:0 20px 60px rgba(0,0,0,0.5);
}

/* 🏷️ TITLE */

.title{

    text-align:center;

    color:white;

    font-size:30px;

    font-weight:900;

    margin-bottom:20px;
}

.title span{

    color:#00d9a5;
}

/* LABEL */

label{

    display:block;

    margin-top:12px;

    margin-bottom:6px;

    color:white;

    font-size:14px;
}

/* INPUT */

input,
select{

    width:100%;

    padding:12px;

    border:none;

    border-radius:12px;

    outline:none;

    background:rgba(255,255,255,0.15);

    color:white;

    font-size:14px;

    transition:0.3s;
}

input:focus,
select:focus{

    background:rgba(255,255,255,0.22);

    box-shadow:0 0 10px rgba(255,255,255,0.2);
}

option{

    color:black;
}

/* BUTTON */

.btn{

    width:100%;

    margin-top:22px;

    padding:13px;

    border:none;

    border-radius:14px;

    background:linear-gradient(135deg, #4e73df, #6c5ce7);

    color:white;

    font-size:15px;

    font-weight:bold;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{

    transform:translateY(-2px);

    box-shadow:0 10px 20px rgba(0,0,0,0.3);
}

/* MESSAGE */

.message{

    padding:14px;

    border-radius:12px;

    margin-bottom:15px;

    text-align:center;

    color:white;

    font-weight:bold;
}

.success{

    background:#00b894;
}

.error{

    background:#e74c3c;
}

/* BACK */

.back{

    display:block;

    margin-top:15px;

    text-align:center;

    text-decoration:none;

    color:white;

    padding:12px;

    border-radius:12px;

    background:rgba(255,255,255,0.12);

    transition:0.3s;
}

.back:hover{

    background:rgba(255,255,255,0.2);
}

</style>

</head>

<body>

<div class="container">

    <h2 class="title">

        Edit <span>Product</span>

    </h2>

    <?php if($message != ""): ?>

        <div class="message <?php echo $message_type; ?>">

            <?php echo $message; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <!-- BRAND -->

        <label>Brand Name</label>

        <input type="text"
               name="brand_name"
               value="<?php echo htmlspecialchars($row['brand_name']); ?>"
               required>

        <!-- CATEGORY -->

        <label>Category</label>

        <select name="category" required>

            <option value="<?php echo $row['category']; ?>">
                <?php echo $row['category']; ?>
            </option>

            <option>T-shirt</option>
            <option>Hoodie</option>
            <option>Pants</option>
            <option>Jacket</option>
            <option>Dress</option>

        </select>

        <!-- COLOR -->

        <label>Color</label>

        <select name="color" required>

            <option value="<?php echo $row['color']; ?>">
                <?php echo $row['color']; ?>
            </option>

            <option>Black</option>
            <option>White</option>
            <option>Red</option>
            <option>Blue</option>
            <option>Gray</option>

        </select>

        <!-- SIZE -->

        <label>Size</label>

        <select name="size" required>

            <option value="<?php echo $row['size']; ?>">
                <?php echo $row['size']; ?>
            </option>

            <option>XS</option>
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>

        </select>

        <!-- PRICE -->

        <label>Price</label>

        <input type="number"
               name="price"
               value="<?php echo $row['price']; ?>"
               required>

        <!-- STOCK -->

        <label>Stock</label>

        <input type="number"
               name="stock"
               value="<?php echo $row['stock']; ?>"
               required>

        <!-- BUTTON -->

        <button type="submit"
                name="update"
                class="btn">

            <i class="fa-solid fa-pen"></i>

            Update Product

        </button>

    </form>

    <!-- BACK -->

    <a href="index.php" class="back">

        <i class="fa-solid fa-arrow-left"></i>

        Back to Dashboard

    </a>

</div>

</body>
</html>