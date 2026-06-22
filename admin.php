<?php
session_start();
include "db.php";


if(!isset($_SESSION['role']) || strtolower($_SESSION['role']) != "admin"){
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

<h1>Admin Dashboard</h1>
<p>Welcome, Administrator!</p>
<a href="logout.php">Logout</a>

<hr>


<h2>All Registered Users</h2>
<table class="table">
<tr>
    <th>User ID</th>
    <th>Email</th>
    <th>Role</th>
    <th>Action</th>
</tr>

<?php
$users = mysqli_query($conn,"SELECT * FROM users");
while($u = mysqli_fetch_assoc($users)){
?>
<tr>
    <td><?= $u['user_id']; ?></td>
    <td><?= $u['email']; ?></td>
    <td><?= $u['role']; ?></td>
    <td>
        <a href="admin_delete.php?type=user&id=<?= $u['user_id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

<hr>


<h2>Vendors</h2>
<table class="table">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$vendors = mysqli_query($conn,"SELECT * FROM vendor");
while($v = mysqli_fetch_assoc($vendors)){
?>
<tr>
    <td><?= $v['vendor_id']; ?></td>
    <td><?= $v['name']; ?></td>
    <td><?= $v['email']; ?></td>
    <td><?= $v['status']; ?></td>
    <td>
        <a href="admin_delete.php?type=vendor&id=<?= $v['vendor_id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

<hr>


<h2>Products</h2>
<table class="table">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Action</th>
</tr>

<?php
$products = mysqli_query($conn,"SELECT * FROM product");
while($p = mysqli_fetch_assoc($products)){
?>
<tr>
    <td><?= $p['product_id']; ?></td>
    <td><?= $p['name']; ?></td>
    <td><?= $p['category']; ?></td>
    <td><?= $p['price']; ?></td>
    <td><?= $p['availability']; ?></td>
    <td>
        <a href="admin_delete.php?type=product&id=<?= $p['product_id']; ?>">Delete</a>
    </td>
</tr>
<?php } ?>
</table>

<hr>


<h2>Reservations</h2>
<table class="table">
<tr>
    <th>ID</th>
    <th>Customer ID</th>
    <th>Product ID</th>
    <th>Quantity</th>
</tr>

<?php
$res = mysqli_query($conn,"SELECT * FROM reservation");
while($r = mysqli_fetch_assoc($res)){
?>
<tr>
    <td><?= $r['reservation_id']; ?></td>
    <td><?= $r['customer_id']; ?></td>
    <td><?= $r['product_id']; ?></td>
    <td><?= $r['quantity']; ?></td>
</tr>
<?php } ?>
</table>

<hr>


<h2>Add Event</h2>

<form method="POST">
    <input type="date" name="event_date" required>
    <input type="text" name="description" placeholder="Event description" required>
    <button type="submit" name="add_event">Add Event</button>
</form>

<?php
if(isset($_POST['add_event'])){
    $date = $_POST['event_date'];
    $desc = mysqli_real_escape_string($conn,$_POST['description']);

    mysqli_query($conn,
        "INSERT INTO event (event_date, description, user_id)
         VALUES ('$date', '$desc', '$admin_id')"
    );

    echo "<p class='success'>Event Added Successfully!</p>";
}
?>

</div>
</body>
</html>
