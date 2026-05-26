<?php
include("db.php");

// CHECK ID

if (!isset($_GET['id'])) {

    echo "No product selected.";
    exit();
}

$id = intval($_GET['id']);

// GET PRODUCT

$result = mysqli_query(
    $conn,
    "SELECT * FROM laruga_villarobe WHERE id = $id"
);

$product = mysqli_fetch_assoc($result);

// CHECK PRODUCT

if (!$product) {

    echo "Product not found.";
    exit();
}

// DELETE WHEN CONFIRMED

if (isset($_POST['confirm_delete'])) {

    // DELETE IMAGE IF EXISTS

    if (isset($product['image'])) {

        $image_path = "uploads/" . $product['image'];

        if (
            !empty($product['image']) &&
            file_exists($image_path)
        ) {

            unlink($image_path);
        }
    }

    // DELETE DATABASE RECORD

    $delete = mysqli_query(
        $conn,
        "DELETE FROM laruga_villarobe WHERE id = $id"
    );

    if ($delete) {

        header("Location: index.php");
        exit();

    } else {

        echo "Delete failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Delete Product</title>

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

    height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
    url('https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=1600&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
}

/* 📦 CONTAINER */

.container{

    width:420px;

    background:white;

    padding:35px;

    border-radius:20px;

    text-align:center;

    box-shadow:0 10px 30px rgba(0,0,0,0.4);

    animation:fadeIn 0.5s ease;
}

@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(-20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* 🗑️ ICON */

.delete-icon{

    width:90px;
    height:90px;

    margin:auto;

    border-radius:50%;

    background:#ffe5e5;

    display:flex;
    justify-content:center;
    align-items:center;

    margin-bottom:20px;
}

.delete-icon i{

    font-size:40px;

    color:#e74c3c;
}

/* 🏷️ TITLE */

.title{

    font-size:30px;

    font-weight:900;

    color:#40345f;

    margin-bottom:10px;
}

/* 📄 TEXT */

.text{

    color:#666;

    margin-bottom:10px;

    line-height:1.6;
}

.product-name{

    font-size:18px;

    font-weight:bold;

    color:#00b894;

    margin-bottom:25px;
}

/* 🔥 BUTTONS */

.button-group{

    display:flex;

    gap:12px;

    justify-content:center;
}

.btn{

    padding:12px 22px;

    border:none;

    border-radius:12px;

    color:white;

    font-weight:bold;

    cursor:pointer;

    text-decoration:none;

    transition:0.3s;
}

.delete-btn{

    background:linear-gradient(135deg, #ff4d4d, #d63031);
}

.cancel-btn{

    background:linear-gradient(135deg, #40345f, #6c5ce7);
}

.btn:hover{

    transform:translateY(-2px);

    box-shadow:0 8px 18px rgba(0,0,0,0.25);
}

</style>

</head>

<body>

<div class="container">

    <!-- 🗑️ ICON -->

    <div class="delete-icon">

        <i class="fa-solid fa-trash"></i>

    </div>

    <!-- 🏷️ TITLE -->

    <div class="title">

        Delete Product

    </div>

    <!-- 📄 MESSAGE -->

    <div class="text">

        Are you sure you want to delete this product?

    </div>

    <div class="product-name">

        <?php echo htmlspecialchars($product['brand_name']); ?>

    </div>

    <!-- 🔥 BUTTONS -->

    <div class="button-group">

        <form method="POST">

            <button type="submit"
                    name="confirm_delete"
                    class="btn delete-btn">

                <i class="fa-solid fa-trash"></i>

                Yes, Delete

            </button>

        </form>

        <a href="index.php"
           class="btn cancel-btn">

            <i class="fa-solid fa-xmark"></i>

            Cancel

        </a>

    </div>

</div>

</body>
</html>