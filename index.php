<?php
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

    background-size: cover;
    background-position: center;
    background-attachment: fixed;

    padding:20px;
}

/* 🏷️ TITLE */

.brand-title {

    text-align: center;

    font-size: 55px;

    font-weight: 900;

    letter-spacing: 5px;

    color: #ffffff;

    margin: 20px 0;

    text-shadow: 2px 2px 15px rgba(0,0,0,0.8);
}

.brand-title span {

    color: #00b894;
}

/* 📦 CONTAINER */

.container {

    width: 92%;

    margin: auto;

    background: rgba(255,255,255,0.95);

    padding: 20px;

    border-radius: 15px;

    box-shadow: 0 10px 25px rgba(0,0,0,0.4);
}

/* 🔥 TOP BAR */

.top-bar {

    display: flex;

    justify-content: space-between;

    align-items: center;

    flex-wrap: wrap;

    gap:15px;

    margin-bottom: 20px;
}

/* 🔥 BUTTON GROUP */

.button-group{
    display:flex;
    gap:12px;
}

/* 🔥 BUTTONS */

.btn{
    padding:12px 20px;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    color:white;
    display:flex;
    align-items:center;
    gap:8px;
    box-shadow:0 5px 15px rgba(0,0,0,0.25);
    transition:all 0.3s ease;
    position:relative;
    overflow:hidden;
}

.btn i{
    font-size:15px;
}

.btn::before{
    content:"";
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background:rgba(255,255,255,0.2);
    transition:0.4s;
}

.btn:hover::before{
    left:100%;
}

.btn:hover{
    transform:translateY(-3px) scale(1.03);
    box-shadow:0 8px 18px rgba(0,0,0,0.35);
}

.add{
    background:linear-gradient(135deg, #00b894, #00cec9);
}

.delete-all{
    background:linear-gradient(135deg, #ff4d4d, #d63031);
}

/* 🔎 SEARCH */

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
    font-size:14px;
}

.search-box:focus{
    border-color:#40345f;
    box-shadow:0 0 10px rgba(64,52,95,0.2);
}

.search-btn{
    padding:12px 18px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg, #40345f, #6c5ce7);
    color:white;
    font-weight:600;
    cursor:pointer;
    display:flex;
    align-items:center;
    gap:8px;
    transition:0.3s;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

.search-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(0,0,0,0.3);
}

/* 📋 TABLE */

table {

    width: 100%;

    border-collapse: collapse;

    background: white;

    border-radius:12px;

    overflow:hidden;
}

th, td {

    padding: 14px;

    text-align: center;

    border-bottom: 1px solid #ddd;
}

th {

    background: #40345f;

    color: white;

    font-size:15px;
}

tr:nth-child(even) {

    background: #f5f5f5;
}

tr:hover{
    background:#ececff;
    transition:0.3s;
}

/* ✨ ACTION BUTTONS */

.action-btn{
    padding:8px 14px;
    border-radius:10px;
    color:white;
    text-decoration:none;
    font-weight:600;
    display:inline-flex;
    align-items:center;
    gap:6px;
    transition:0.3s;
}

.edit{
    background:linear-gradient(135deg, #4e73df, #6c5ce7);
}

.delete{
    background:linear-gradient(135deg, #e74c3c, #ff7675);
}

.action-btn:hover{
    transform:scale(1.05);
}

/* 📱 RESPONSIVE */

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

            <a href="create.php" class="btn add">

                <i class="fa-solid fa-plus"></i>

                Add New

            </a>

            <a href="deleteall.php"
               class="btn delete-all"
               onclick="return confirm('Delete ALL records?')">

               <i class="fa-solid fa-trash"></i>

               Delete All

            </a>

        </div>

        <!-- 🔎 SEARCH -->
        <form method="GET" class="search-form">

            <input type="text"
                   name="search"
                   class="search-box"
                   placeholder="Search clothing..."
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
            <th>Brand</th>
            <th>Category</th>
            <th>Color</th>
            <th>Size</th>
            <th>Price</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result && mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                echo "
                <tr>

                    <td>{$row['id']}</td>

                    <td>{$row['brand_name']}</td>

                    <td>{$row['category']}</td>

                    <td>{$row['color']}</td>

                    <td>{$row['size']}</td>

                    <td>₱{$row['price']}</td>

                    <td>

                        <a href='edit.php?id={$row['id']}' class='action-btn edit'>

                            <i class='fa-solid fa-pen-to-square'></i>

                            Edit

                        </a>

                        <a href='delete.php?id={$row['id']}' class='action-btn delete'>

                            <i class='fa-solid fa-trash'></i>

                            Delete

                        </a>

                    </td>

                </tr>";
            }

        } else {

            echo "
            <tr>
                <td colspan='7'>No records found</td>
            </tr>";
        }
        ?>

    </table>

</div>

</body>
</html>