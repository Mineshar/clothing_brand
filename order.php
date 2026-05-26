<?php
include("db.php");

$message = "";

if(isset($_POST['order'])){

    $customer_name = $_POST['customer_name'];
    $product_id    = $_POST['product_id'];
    $quantity      = $_POST['quantity'];

    // GET PRODUCT

    $product_query = mysqli_query($conn,
    "SELECT * FROM laruga_villarobe WHERE id='$product_id'");

    $product = mysqli_fetch_assoc($product_query);

    if($product){

        $current_stock = $product['stock'];

        // CHECK STOCK

        if($quantity > $current_stock){

            $message = "❌ Not enough stock available.";

        } else {

            // INSERT ORDER

            mysqli_query($conn,
            "INSERT INTO orders
            (customer_name, product_id, quantity)
            VALUES
            ('$customer_name','$product_id','$quantity')");

            // UPDATE STOCK

            $new_stock = $current_stock - $quantity;

            mysqli_query($conn,
            "UPDATE laruga_villarobe
            SET stock='$new_stock'
            WHERE id='$product_id'");

            $message = "✅ Order placed successfully!";
        }

    } else {

        $message = "❌ Product not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Customer Order</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{

    height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    background:
    linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1400&auto=format&fit=crop');

    background-size:cover;
}

.container{

    width:420px;

    background:white;

    padding:30px;

    border-radius:18px;

    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

h2{

    text-align:center;

    margin-bottom:20px;

    color:#40345f;
}

input, select{

    width:100%;

    padding:12px;

    margin-bottom:15px;

    border-radius:10px;

    border:1px solid #ccc;
}

button{

    width:100%;

    padding:13px;

    border:none;

    border-radius:12px;

    background:linear-gradient(135deg,#00b894,#00cec9);

    color:white;

    font-weight:bold;

    cursor:pointer;

    transition:0.3s;
}

button:hover{

    transform:translateY(-2px);
}

.message{

    padding:12px;

    margin-bottom:15px;

    border-radius:10px;

    text-align:center;

    background:#40345f;

    color:white;
}

.back{

    display:block;

    text-align:center;

    margin-top:15px;

    text-decoration:none;

    color:#40345f;

    font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

    <h2>
        <i class="fa-solid fa-cart-shopping"></i>
        Customer Order
    </h2>

    <?php
    if($message != ""){
        echo "<div class='message'>$message</div>";
    }
    ?>

    <form method="POST">

        <input type="text"
               name="customer_name"
               placeholder="Customer Name"
               required>

        <select name="product_id" required>

            <option value="">Select Product</option>

            <?php

            $products = mysqli_query($conn,
            "SELECT * FROM laruga_villarobe");

            while($row = mysqli_fetch_assoc($products)){

                echo "
                <option value='{$row['id']}'>
                    {$row['brand_name']}
                    ({$row['stock']} stocks)
                </option>";
            }

            ?>

        </select>

        <input type="number"
               name="quantity"
               placeholder="Quantity"
               required>

        <button type="submit" name="order">

            <i class="fa-solid fa-bag-shopping"></i>

            Place Order

        </button>

    </form>

    <a href="index.php" class="back">

        ← Back to Dashboard

    </a>

</div>

</body>
</html>