<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="style.css?v=1">
</head>
<body>

<div class="container">

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Customer Dashboard</h2>
        <a href="logout.php" style="background:red; color:white; padding:6px 12px; text-decoration:none; border-radius:5px;">
            Logout
        </a>
    </div>

    <p>
        Welcome! You are logged in as: 
        <strong><?php echo $_SESSION['role']; ?></strong>
    </p>

    <hr>

    <h3>Upcoming Events</h3>

    <table class="table">
        <tr>
            <th>Date</th>
            <th>Description</th>
        </tr>

        <?php
        $events = mysqli_query($conn, "SELECT * FROM event ORDER BY event_date DESC");

        if(mysqli_num_rows($events) > 0){
            while($e = mysqli_fetch_assoc($events)){
                echo "<tr>
                        <td>{$e['event_date']}</td>
                        <td>{$e['description']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No events available</td></tr>";
        }
        ?>
    </table>

    <hr>

    <h3>Available Products</h3>

    <table class="table">
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Price (Rs.)</th>
            <th>Stock</th>
            <th>Reserve</th>
        </tr>

        <?php
        $products = mysqli_query($conn, "SELECT * FROM product");

        while($p = mysqli_fetch_assoc($products)){
            echo "<tr>
                <td>{$p['name']}</td>
                <td>{$p['category']}</td>
                <td>{$p['price']}</td>
                <td>{$p['availability']}</td>
                <td>
                    <a href='reserve.php?id={$p['product_id']}'>Reserve</a>
                </td>
            </tr>";
        }
        ?>
    </table>

</div>

</body>
</html>
