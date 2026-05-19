<?php
include("db.php");

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $brand_name = htmlspecialchars(trim($_POST['brand_name'] ?? ''));
    $category   = htmlspecialchars(trim($_POST['category'] ?? ''));
    $color      = htmlspecialchars(trim($_POST['color'] ?? ''));
    $size       = htmlspecialchars(trim($_POST['size'] ?? ''));
    $price      = htmlspecialchars(trim($_POST['price'] ?? ''));

    // VALIDATION
    if (
        empty($brand_name) ||
        empty($category) ||
        empty($color) ||
        empty($size) ||
        empty($price)
    ) {

        $message = "All fields are required!";
        $message_type = "error";

    } elseif (!is_numeric($price)) {

        $message = "Price must be numeric!";
        $message_type = "error";

    } else {

        // INSERT DATA
        $stmt = $conn->prepare("INSERT INTO laruga_villarobe 
        (brand_name, category, color, size, price) 
        VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssd", $brand_name, $category, $color, $size, $price);

        if ($stmt->execute()) {

            $message = "Clothing brand added successfully!";
            $message_type = "success";

        } else {

            $message = "Database Error: " . $stmt->error;
            $message_type = "error";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Add Clothing Brand</title>

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
            background-repeat:no-repeat;
        }

        .container{
            width:430px;
            background:rgba(255,255,255,0.95);
            backdrop-filter:blur(10px);
            padding:30px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,0.4);
        }

        h2{
            text-align:center;
            margin-bottom:25px;
            color:#111;
            font-size:28px;
        }

        label{
            display:block;
            margin-top:15px;
            margin-bottom:6px;
            font-weight:500;
            color:#333;
        }

        input,
        select{
            width:100%;
            padding:13px;
            border:1px solid #ccc;
            border-radius:10px;
            outline:none;
            transition:0.3s;
            font-size:14px;
        }

        input:focus,
        select:focus{
            border-color:#000;
            box-shadow:0 0 8px rgba(0,0,0,0.2);
        }

        button{
            width:100%;
            padding:14px;
            margin-top:25px;
            border:none;
            border-radius:12px;
            background:#111;
            color:white;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#333;
            transform:scale(1.02);
        }

        /* SUCCESS MESSAGE */

        .message{
            padding:20px;
            border-radius:18px;
            margin-bottom:20px;
            text-align:center;
            animation:popup 0.5s ease;
        }

        .success{
            background:linear-gradient(135deg, #28a745, #43d66c);
            color:white;
            box-shadow:0 5px 20px rgba(40,167,69,0.4);
        }

        .error{
            background:linear-gradient(135deg, #dc3545, #ff6b81);
            color:white;
            box-shadow:0 5px 20px rgba(220,53,69,0.4);
        }

        /* CHECKMARK */

        .checkmark-circle{
            width:80px;
            height:80px;
            border-radius:50%;
            background:rgba(255,255,255,0.2);
            margin:0 auto 15px;
            display:flex;
            justify-content:center;
            align-items:center;
            animation:bounce 0.8s ease;
        }

        .checkmark{
            font-size:40px;
            font-weight:bold;
        }

        @keyframes popup{
            from{
                opacity:0;
                transform:scale(0.7);
            }
            to{
                opacity:1;
                transform:scale(1);
            }
        }

        @keyframes bounce{
            0%{
                transform:scale(0.5);
            }
            50%{
                transform:scale(1.2);
            }
            100%{
                transform:scale(1);
            }
        }

        /* BACK BUTTON */

        .back{
            display:block;
            text-align:center;
            margin-top:25px;
            padding:12px;
            border-radius:10px;
            background:#111;
            color:white;
            text-decoration:none;
            font-weight:600;
            transition:0.3s;
        }

        .back:hover{
            background:#333;
            transform:scale(1.02);
        }

        @media(max-width:500px){

            .container{
                width:100%;
                padding:20px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h2>👕 Add Clothing Brand</h2>

    <!-- MESSAGE -->
    <?php if($message != ""): ?>

        <div class="message <?php echo $message_type; ?>">

            <?php if($message_type == "success"): ?>

                <div class="checkmark-circle">
                    <div class="checkmark">✔</div>
                </div>

            <?php endif; ?>

            <h3><?php echo $message; ?></h3>

        </div>

    <?php endif; ?>

    <!-- FORM -->
    <form method="POST">

        <label>Brand Name</label>
        <input 
            type="text"
            name="brand_name"
            placeholder="Enter brand name"
            required
        >

        <label>Category</label>
        <select name="category" required>

            <option value="">-- Select Category --</option>
            <option>T-shirt</option>
            <option>Hoodie</option>
            <option>Pants</option>
            <option>Jacket</option>
            <option>Croptop</option>
            <option>Dress</option>
            <option>Shoes</option>
            <option>Jersey</option>
            <option>Baggy Pants</option>

        </select>

        <label>Color</label>
        <select name="color" required>

            <option value="">-- Select Color --</option>
            <option>Black</option>
            <option>White</option>
            <option>Red</option>
            <option>Pink</option>
            <option>Skyblue</option>
            <option>Gray</option>
            <option>Maroon</option>
            <option>Dark Blue</option>

        </select>

        <label>Size</label>
        <select name="size" required>

            <option value="">-- Select Size --</option>
            <option>XS</option>
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>

        </select>

        <label>Price</label>
        <input 
            type="number"
            step="0.01"
            name="price"
            placeholder="Enter price"
            required
        >

        <button type="submit">➕ Add Brand</button>

    </form>

    <!-- BACK BUTTON -->
    <a href="index.php" class="back">
        ← Back to List
    </a>

</div>

</body>
</html>