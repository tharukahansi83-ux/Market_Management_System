<?php
session_start();
include "db.php";

if($_SESSION['role'] != "admin"){
    header("Location: login.php");
    exit();
}

$type = $_GET['type'];
$id   = $_GET['id'];

if($type == "user"){
    mysqli_query($conn,"DELETE FROM users WHERE user_id=$id");
}
elseif($type == "vendor"){
    mysqli_query($conn,"DELETE FROM vendor WHERE vendor_id=$id");
}
elseif($type == "product"){
    mysqli_query($conn,"DELETE FROM product WHERE product_id=$id");
}

header("Location: admin.php");
?>
