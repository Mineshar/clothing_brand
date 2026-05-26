<?php
session_start();

// CHECK IF USER IS LOGGED IN

if (!isset($_SESSION['role'])) {

    header("Location: login.php");
    exit();
}

// ONLY ADMIN AND CUSTOMER CAN LOGOUT

if (
    $_SESSION['role'] != "admin" &&
    $_SESSION['role'] != "customer"
) {

    echo "Access Denied!";
    exit();
}

// DESTROY SESSION

session_unset();
session_destroy();

// REDIRECT TO LOGIN

header("Location: login.php");
exit();
?>