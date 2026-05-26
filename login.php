<?php
session_start();
include("db.php");

$message = "";

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role     = $_POST['role'];

    // CHECK ACCOUNT

    $sql = "SELECT * FROM users
            WHERE username='$username'
            AND password='$password'
            AND role='$role'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // ADMIN LOGIN

        if($role == "admin"){

            header("Location: index.php");
            exit();
        }

        // CUSTOMER LOGIN

        if($role == "customer"){

            header("Location: order.php");
            exit();
        }

    } else {

        $message = "❌ Invalid username, password, or role!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Clothing Brand Login</title>

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
    url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1400&auto=format&fit=crop');

    background-size:cover;
    background-position:center;
}

.container{

    width:400px;

    background:rgba(255,255,255,0.12);

    backdrop-filter:blur(15px);

    padding:35px;

    border-radius:20px;

    border:1px solid rgba(255,255,255,0.2);

    box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

h2{

    text-align:center;

    color:white;

    margin-bottom:25px;

    font-size:30px;
}

.input-box{

    width:100%;

    padding:13px;

    margin-bottom:18px;

    border:none;

    border-radius:12px;

    outline:none;

    background:rgba(255,255,255,0.15);

    color:white;

    font-size:14px;
}

.input-box::placeholder{

    color:#ddd;
}

select{

    width:100%;

    padding:13px;

    margin-bottom:18px;

    border:none;

    border-radius:12px;

    outline:none;

    background:rgba(255,255,255,0.15);

    color:white;

    font-size:14px;
}

select option{

    color:black;
}

button{

    width:100%;

    padding:13px;

    border:none;

    border-radius:12px;

    background:linear-gradient(135deg,#00b894,#00cec9);

    color:white;

    font-size:15px;

    font-weight:bold;

    cursor:pointer;

    transition:0.3s;
}

button:hover{

    transform:translateY(-2px);

    box-shadow:0 8px 18px rgba(0,0,0,0.3);
}

.message{

    background:#e74c3c;

    color:white;

    padding:12px;

    border-radius:10px;

    margin-bottom:15px;

    text-align:center;
}

</style>

</head>

<body>

<div class="container">

    <h2>

        <i class="fa-solid fa-shirt"></i>

        Clothing Brand Login

    </h2>

    <?php
    if($message != ""){
        echo "<div class='message'>$message</div>";
    }
    ?>

    <form method="POST">

        <input type="text"
               name="username"
               class="input-box"
               placeholder="Enter Username"
               required>

        <input type="password"
               name="password"
               class="input-box"
               placeholder="Enter Password"
               required>

        <select name="role" required>

            <option value="">Select Role</option>

            <option value="admin">Admin</option>

            <option value="customer">Customer</option>

        </select>

        <button type="submit" name="login">

            <i class="fa-solid fa-right-to-bracket"></i>

            Login

        </button>

    </form>

</div>

</body>
</html>