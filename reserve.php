<?php
session_start();
include "db.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != "customer"){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    die("Product not selected.");
}
$product_id = $_GET['id'];

$msg = "";

$user_id = $_SESSION['user_id'];

$u_result = mysqli_query($conn,"SELECT email FROM users WHERE user_id=$user_id");
$u = mysqli_fetch_assoc($u_result);

if(!$u){
    die("User not found.");
}

$email = $u['email'];


$c_result = mysqli_query($conn,"SELECT * FROM customer WHERE email='$email'");
$c = mysqli_fetch_assoc($c_result);

if(!$c){
    die("Customer record not found. Please signup as customer.");
}

$customer_id = $c['customer_id'];

if(isset($_POST['reserve'])){
    $qty = $_POST['quantity'];

    mysqli_query($conn,"INSERT INTO reservation(customer_id,product_id,quantity)
                        VALUES($customer_id,$product_id,$qty)");

    $msg = "Reservation successful!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reserve Product</title>
    <link rel="stylesheet" href="style.css?v=1">
</head>
<body>

<div class="container">
<h2>Reserve Product</h2>

<?php
if($msg){
    echo "<div class='success'>$msg</div>";
}
?>

<form method="POST">
    <label>Quantity</label>
    <input type="number" name="quantity" min="1" required>

    <button type="submit" name="reserve">Reserve</button>
</form>

</div>
</body>
</html>
