<?php
session_start();
include "db.php";

/* Role check */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "vendor") {
    header("Location: login.php");
    exit();
}

/* Email session check */
if (!isset($_SESSION['email'])) {
    die("Session error. Please login again.");
}

$vendor_email = $_SESSION['email'];

/* Get vendor details */
$v = mysqli_query($conn, "SELECT * FROM vendor WHERE email='$vendor_email'");

if (mysqli_num_rows($v) == 0) {
    die("<p style='color:red'>Vendor record not found. Please contact admin.</p>");
}

$vendor = mysqli_fetch_assoc($v);
$vendor_id = $vendor['vendor_id'];

$msg = "";

/* Add product */
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = (float)$_POST['price'];
    $availability = (int)$_POST['availability'];

    mysqli_query($conn, "
        INSERT INTO product (vendor_id, name, category, price, availability)
        VALUES ($vendor_id, '$name', '$category', $price, $availability)
    ");

    $msg = "✔ Product added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Dashboard</title>
    <link rel="stylesheet" href="style.css?v=1">
</head>
<body>

<div class="container">
    <h2>Vendor Dashboard</h2>
    <a href="logout.php" style="float:right;color:red;">Logout</a>

    <p><b>Welcome, <?php echo htmlspecialchars($vendor['name']); ?>!</b></p>

    <?php if ($msg) { echo "<div class='success'>$msg</div>"; } ?>

    <h3>Add Product</h3>
    <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="text" name="category" placeholder="Category" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="number" name="availability" placeholder="Stock" required>
        <button name="add_product">Add Product</button>
    </form>

    <hr>

    <h3>Your Products</h3>
    <table class="table">
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>

        <?php
        $products = mysqli_query($conn, "SELECT * FROM product WHERE vendor_id=$vendor_id");

        if (mysqli_num_rows($products) == 0) {
            echo "<tr><td colspan='4'>No products added yet.</td></tr>";
        }

        while ($p = mysqli_fetch_assoc($products)) {
            echo "<tr>
                <td>{$p['name']}</td>
                <td>{$p['category']}</td>
                <td>{$p['price']}</td>
                <td>{$p['availability']}</td>
            </tr>";
        }
        ?>
    </table>

    <hr>

    <h3>Customer Reservations</h3>
    <table class="table">
        <tr>
            <th>Customer</th>
            <th>Product</th>
            <th>Quantity</th>
        </tr>

        <?php
        $res = mysqli_query($conn, "
            SELECT c.name AS customer, p.name AS product, r.quantity
            FROM reservation r
            JOIN customer c ON r.customer_id = c.customer_id
            JOIN product p ON r.product_id = p.product_id
            WHERE p.vendor_id = $vendor_id
        ");

        if (mysqli_num_rows($res) == 0) {
            echo "<tr><td colspan='3'>No reservations yet.</td></tr>";
        }

        while ($r = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>{$r['customer']}</td>
                <td>{$r['product']}</td>
                <td>{$r['quantity']}</td>
            </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
