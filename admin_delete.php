<?php
session_start();
include "db.php";

if($_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit();
}

$type = $_GET['type'];
$id   = (int)$_GET['id'];

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

if($type == "user"){

    mysqli_query($conn, "DELETE FROM customer WHERE user_id=$id");
    mysqli_query($conn, "DELETE FROM vendor WHERE user_id=$id");
    mysqli_query($conn, "DELETE FROM event WHERE user_id=$id");
    
    mysqli_query($conn, "DELETE FROM users WHERE user_id=$id");
}
elseif($type == "vendor"){
    mysqli_query($conn, "DELETE FROM vendor WHERE vendor_id=$id");
}
elseif($type == "product"){
    mysqli_query($conn, "DELETE FROM product WHERE product_id=$id");
}

mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

header("Location: admin.php");
exit();
?>