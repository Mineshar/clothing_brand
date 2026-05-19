<?php
include("db.php");

// DELETE ALL RECORDS
$sql = "DELETE FROM laruga_villarobe";

if (mysqli_query($conn, $sql)) {

    header("Location: index.php");
    exit();

} else {

    echo "Error deleting records: " . mysqli_error($conn);
}
?>