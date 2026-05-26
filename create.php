<?php
session_start();

// 🔐 ACCESS CONTROL (ADMIN + CUSTOMER ONLY)
if (!isset($_SESSION['role']) ||
   ($_SESSION['role'] != "admin" && $_SESSION['role'] != "customer")) {

    header("Location: login.php");
    exit();
}

include("db.php");

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $brand_name = htmlspecialchars(trim($_POST['brand_name'] ?? ''));
    $category   = htmlspecialchars(trim($_POST['category'] ?? ''));
    $color      = htmlspecialchars(trim($_POST['color'] ?? ''));
    $size       = htmlspecialchars(trim($_POST['size'] ?? ''));
    $price      = htmlspecialchars(trim($_POST['price'] ?? ''));
    $stock      = htmlspecialchars(trim($_POST['stock'] ?? ''));

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

        // 🔎 CHECK IF PRODUCT ALREADY EXISTS
        $check = $conn->prepare("
            SELECT id, stock 
            FROM laruga_villarobe
            WHERE brand_name = ?
            AND category = ?
            AND color = ?
            AND size = ?
        ");

        $check->bind_param(
            "ssss",
            $brand_name,
            $category,
            $color,
            $size
        );

        $check->execute();
        $result = $check->get_result();

        // 🔁 IF EXISTS → UPDATE STOCK
        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();

            $new_stock = $row['stock'] + $stock;

            $update = $conn->prepare("
                UPDATE laruga_villarobe
                SET stock = ?, price = ?
                WHERE id = ?
            ");

            $update->bind_param(
                "idi",
                $new_stock,
                $price,
                $row['id']
            );

            if ($update->execute()) {
                $message = "✅ Product already exists! Stock updated successfully.";
                $message_type = "success";
            } else {
                $message = "❌ Failed to update stock.";
                $message_type = "error";
            }

            $update->close();

        } else {

            // ➕ INSERT NEW PRODUCT
            $stmt = $conn->prepare("
                INSERT INTO laruga_villarobe
                (brand_name, category, color, size, price, stock)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "ssssdi",
                $brand_name,
                $category,
                $color,
                $size,
                $price,
                $stock
            );

            if ($stmt->execute()) {
                $message = "✅ New product added successfully!";
                $message_type = "success";
            } else {
                $message = "❌ Database Error: " . $stmt->error;
                $message_type = "error";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Clothing Product</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    background:
    linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1400&auto=format&fit=crop');
    background-size:cover;
    background-position:center;
}

.container{
    width:450px;
    padding:35px;
    border-radius:22px;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}

h2{
    text-align:center;
    color:#fff;
    margin-bottom:20px;
}

label{
    color:#fff;
    font-size:13px;
}

input, select{
    width:100%;
    padding:10px;
    margin:6px 0 12px;
    border-radius:10px;
    border:none;
    outline:none;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#3b82f6,#8b5cf6);
    color:white;
    font-weight:bold;
    cursor:pointer;
}

.message{
    padding:10px;
    margin-bottom:10px;
    border-radius:10px;
    color:white;
}

.success{ background:green; }
.error{ background:red; }

.back, .logout{
    display:block;
    text-align:center;
    margin-top:10px;
    padding:10px;
    border-radius:10px;
    text-decoration:none;
    color:white;
}

.back{ background:rgba(255,255,255,0.2); }
.logout{ background:red; }

</style>

</head>

<body>

<div class="container">

<h2>👕 Add Clothing Product</h2>

<?php if($message != ""): ?>
    <div class="message <?php echo $message_type; ?>">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<form method="POST">

<label>Brand Name</label>
<input type="text" name="brand_name" required>

<label>Category</label>
<select name="category" required>
<option>T-shirt</option>
<option>Hoodie</option>
<option>Pants</option>
<option>Jacket</option>
</select>

<label>Color</label>
<select name="color" required>
<option>Black</option>
<option>White</option>
<option>Red</option>
</select>

<label>Size</label>
<select name="size" required>
<option>S</option>
<option>M</option>
<option>L</option>
</select>

<label>Price</label>
<input type="number" name="price" required>

<label>Stock</label>
<input type="number" name="stock" required>

<button type="submit">Add Product</button>

</form>

<a class="back" href="index.php">Back</a>
<a class="logout" href="logout.php">Logout</a>

</div>

</body>
</html>