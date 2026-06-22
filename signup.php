<?php
session_start();
include "db.php";
$msg = "";

if(isset($_POST['save'])){

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass  = $_POST['pass'];
    $role  = $_POST['role'];

    
    $user_sql = "INSERT INTO users(email,password,role)
                 VALUES('$email','$pass','$role')";

    if(mysqli_query($conn, $user_sql)){

        
        $user_id = mysqli_insert_id($conn);

        
        if($role == "vendor"){
            $farm = $_POST['farm_details'];

            mysqli_query($conn, "INSERT INTO vendor
                (name,email,phone,farm_details,status,user_id)
                VALUES('$name','$email','$phone','$farm','Approved',$user_id)
            ");

        } else {
            mysqli_query($conn, "INSERT INTO customer
                (name,email,phone,user_id)
                VALUES('$name','$email','$phone',$user_id)
            ");
        }

        $msg = "✅ Signup Successful! You can now login.";

    } else {
        $msg = "❌ Error creating user!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css?v=1">
</head>
<body>

<div class="container">
<h2>Sign Up</h2>

<?php if($msg){ echo "<div class='success'>$msg</div>"; } ?>

<form method="POST">

    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Phone</label>
    <input type="text" name="phone" required>

    <label>Password</label>
    <input type="password" name="pass" required>

    <label>Role</label>
    <select name="role" required>
        <option value="customer">Customer</option>
        <option value="vendor">Vendor</option>
    </select>

    <div id="vendorExtra"></div>

    <button name="save">Create Account</button>
</form>
</div>

<script>
document.querySelector("select[name=role]").onchange = function(){
    if(this.value == "vendor"){
        document.getElementById("vendorExtra").innerHTML = `
            <label>Farm Details</label>
            <input type="text" name="farm_details" required>
        `;
    } else {
        document.getElementById("vendorExtra").innerHTML = "";
    }
}
</script>

</body>
</html>
