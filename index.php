<?php

session_start();

// 🔐 CHECK IF USER HAS VALID ROLE
if (!isset($_SESSION['role']) ||
    ($_SESSION['role'] != "admin" && $_SESSION['role'] != "customer")) {

    header("Location: login.php");
    exit();
}

include("db.php");

// 🔎 SEARCH LOGIC

$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT * FROM laruga_villarobe
            WHERE brand_name LIKE '%$search%'
            OR category LIKE '%$search%'
            OR color LIKE '%$search%'
            OR size LIKE '%$search%'
            OR price LIKE '%$search%'
            OR stock LIKE '%$search%'
            ORDER BY id ASC";

} else {

    $sql = "SELECT * FROM laruga_villarobe ORDER BY id ASC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Clothing Brand</title>

<!-- FONT AWESOME -->

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

    background:
    linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
    url('https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=1600&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
    background-attachment:fixed;

    padding:20px;
}

/* 🏷️ TITLE */

.brand-title{

    text-align:center;

    font-size:70px;

    font-weight:900;

    letter-spacing:8px;

    text-transform:uppercase;

    margin:25px 0 35px;

    color:#ffffff;

    text-shadow:2px 2px 8px rgba(0,0,0,0.7);

    animation:fadeIn 1s ease;
}

.brand-title span{

    color:#00d9a5;
}

.brand-title::after{

    content:"";

    display:block;

    width:180px;

    height:4px;

    margin:12px auto 0;

    border-radius:10px;

    background:linear-gradient(to right, #00b894, #00cec9);
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

/* 📦 CONTAINER */

.container{

    width:95%;

    margin:auto;

    background:rgba(255,255,255,0.95);

    padding:20px;

    border-radius:18px;

    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

/* 🔥 TOP BAR */

.top-bar{

    display:flex;

    justify-content:space-between;

    align-items:center;

    flex-wrap:wrap;

    gap:15px;

    margin-bottom:20px;
}

/* BUTTON GROUP */

.button-group{

    display:flex;

    gap:12px;
}

/* BUTTON */

.btn{

    padding:12px 20px;

    border-radius:12px;

    text-decoration:none;

    font-weight:600;

    color:white;

    display:flex;

    align-items:center;

    gap:8px;

    transition:0.3s;

    box-shadow:0 5px 15px rgba(0,0,0,0.25);
}

.btn:hover{

    transform:translateY(-3px);

    box-shadow:0 8px 18px rgba(0,0,0,0.35);
}

.add{

    background:linear-gradient(135deg, #00b894, #00cec9);
}

.delete-all{

    background:linear-gradient(135deg, #ff4d4d, #d63031);
}

.logout{

    background:linear-gradient(135deg, #40345f, #6c5ce7);
}

/* SEARCH */

.search-form{

    display:flex;

    align-items:center;

    gap:10px;
}

.search-box{

    padding:12px 15px;

    width:250px;

    border-radius:12px;

    border:1px solid #ccc;

    outline:none;

    transition:0.3s;
}

.search-box:focus{

    border-color:#6c5ce7;

    box-shadow:0 0 10px rgba(108,92,231,0.2);
}

.search-btn{

    padding:12px 18px;

    border:none;

    border-radius:12px;

    background:linear-gradient(135deg, #40345f, #6c5ce7);

    color:white;

    font-weight:600;

    cursor:pointer;

    transition:0.3s;
}

.search-btn:hover{

    transform:translateY(-2px);
}

/* TABLE */

table{

    width:100%;

    border-collapse:collapse;

    overflow:hidden;

    border-radius:12px;
}

th, td{

    padding:15px;

    text-align:center;

    border-bottom:1px solid #ddd;
}

th{

    background:#40345f;

    color:white;

    font-size:15px;
}

tr:nth-child(even){

    background:#f5f5f5;
}

tr:hover{

    background:#ececff;

    transition:0.3s;
}

/* STOCK DESIGN */

.stock{

    padding:6px 12px;

    border-radius:20px;

    font-weight:bold;

    color:white;

    display:inline-block;
}

.in-stock{

    background:#00b894;
}

.low-stock{

    background:#f39c12;
}

.out-stock{

    background:#e74c3c;
}

/* ACTION BUTTONS */

.action-btn{

    width:38px;
    height:38px;

    border-radius:10px;

    color:white;

    text-decoration:none;

    display:inline-flex;

    justify-content:center;

    align-items:center;

    margin:0 3px;

    transition:0.3s;
}

.edit{

    background:linear-gradient(135deg, #4e73df, #6c5ce7);
}

.delete{

    background:linear-gradient(135deg, #ff4d4d, #d63031);
}

.action-btn:hover{

    transform:scale(1.1);
}

/* RESPONSIVE */

@media(max-width:900px){

    .top-bar{

        flex-direction:column;

        align-items:flex-start;
    }

    .search-form{

        width:100%;
    }

    .search-box{

        width:100%;
    }

    table{

        font-size:13px;
    }
}

@media(max-width:768px){

    .brand-title{

        font-size:38px;
    }

    .brand-title::after{

        width:120px;
    }
}

</style>

</head>

<body>

<!-- 🏷️ TITLE -->

<h2 class="brand-title">

    <span>C</span>LOTHING <span>B</span>RAND

</h2>

<div class="container">

    <!-- 🔥 TOP BAR -->

    <div class="top-bar">

        <div class="button-group">

            <!-- ADD -->

            <a href="create.php" class="btn add">

                <i class="fa-solid fa-plus"></i>

                Add Product

            </a>

            <!-- DELETE ALL -->

            <a href="deleteall.php"
               class="btn delete-all">

               <i class="fa-solid fa-trash"></i>

               Delete All

            </a>

           
        </div>

        <!-- SEARCH -->

        <form method="GET" class="search-form">

            <input type="text"
                   name="search"
                   class="search-box"
                   placeholder="Search product..."
                   value="<?php echo htmlspecialchars($search); ?>">

            <button type="submit" class="search-btn">

                <i class="fa-solid fa-magnifying-glass"></i>

                Search

            </button>

        </form>

    </div>

    <!-- 📋 TABLE -->

    <table>

        <tr>

            <th>ID</th>
            <th>Brand Name</th>
            <th>Category</th>
            <th>Color</th>
            <th>Size</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>

        </tr>

        <?php

        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                // STOCK STATUS

                if ($row['stock'] > 10) {

                    $stockClass = "in-stock";

                } elseif ($row['stock'] > 0) {

                    $stockClass = "low-stock";

                } else {

                    $stockClass = "out-stock";
                }

                echo "

                <tr>

                    <td>{$row['id']}</td>

                    <td>{$row['brand_name']}</td>

                    <td>{$row['category']}</td>

                    <td>{$row['color']}</td>

                    <td>{$row['size']}</td>

                    <td>₱{$row['price']}</td>

                    <td>

                        <span class='stock $stockClass'>

                            {$row['stock']}

                        </span>

                    </td>

                    <td>

                        <a href='edit.php?id={$row['id']}'
                           class='action-btn edit'>

                            <i class='fa-solid fa-pen'></i>

                        </a>

                        <a href='delete.php?id={$row['id']}'
                           class='action-btn delete'>

                            <i class='fa-solid fa-trash'></i>

                        </a>

                    </td>

                </tr>
                ";
            }

        } else {

            echo "

            <tr>

                <td colspan='8'>

                    No products found

                </td>

            </tr>
            ";
        }

        ?>

    </table>

</div>

</body>
</html>