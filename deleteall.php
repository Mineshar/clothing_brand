<?php
include("db.php");

// DELETE ALL WHEN CONFIRMED

if (isset($_POST['confirm_delete_all'])) {

    $sql = "DELETE FROM laruga_villarobe";

    if (mysqli_query($conn, $sql)) {

        header("Location: index.php");
        exit();

    } else {

        echo "Error deleting records: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Delete All Products</title>

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

    width:430px;

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

    width:95px;
    height:95px;

    margin:auto;

    border-radius:50%;

    background:#ffe5e5;

    display:flex;
    justify-content:center;
    align-items:center;

    margin-bottom:20px;
}

.delete-icon i{

    font-size:42px;

    color:#e74c3c;
}

/* 🏷️ TITLE */

.title{

    font-size:32px;

    font-weight:900;

    color:#40345f;

    margin-bottom:12px;
}

/* 📄 MESSAGE */

.text{

    color:#666;

    line-height:1.7;

    margin-bottom:25px;
}

/* 🔥 BUTTON GROUP */

.button-group{

    display:flex;

    justify-content:center;

    gap:12px;
}

/* 🔘 BUTTON */

.btn{

    padding:13px 24px;

    border:none;

    border-radius:12px;

    color:white;

    font-weight:bold;

    text-decoration:none;

    cursor:pointer;

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

        <i class="fa-solid fa-trash-can"></i>

    </div>

    <!-- 🏷️ TITLE -->

    <div class="title">

        Delete All Products

    </div>

    <!-- 📄 MESSAGE -->

    <div class="text">

        ⚠️ Are you sure you want to delete ALL products?<br><br>



    </div>

    <!-- 🔥 BUTTONS -->

    <div class="button-group">

        <form method="POST">

            <button type="submit"
                    name="confirm_delete_all"
                    class="btn delete-btn">

                <i class="fa-solid fa-trash"></i>

                Yes, Delete All

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