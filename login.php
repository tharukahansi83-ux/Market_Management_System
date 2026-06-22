<?php
session_start();
include "db.php";

$redirect = "";

if(isset($_POST['login_btn'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $run = mysqli_query($conn, $sql);

    if(mysqli_num_rows($run) == 1){
        $row = mysqli_fetch_assoc($run);

        if($password == $row['password']){

            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = strtolower(trim($row['role']));
            $_SESSION['email'] = $row['email'];

            // Decide redirect page
            if($_SESSION['role'] == "admin"){
                $redirect = "admin.php";
            }
            elseif($_SESSION['role'] == "vendor"){
                $redirect = "vendor_dashboard.php";
            }
            else{
                $redirect = "customer_browse.php";
            }

        } else {
            $error = "Incorrect Password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css?v=1">
    <title>Login</title>
</head>
<body>
<h1 style = "text-align:center; font-size:58px; color:black; font-family: 'Georgia', serif; font-style:italic; margin-top:30px;">
    Welcome to Aurora Market
</h1>

<div class="container">
    <h2>Login</h2>

    <?php if(isset($error)) echo "<p style='color:red;font-weight:bold;'>$error</p>"; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login_btn">Login</button>
    </form>

    <p>No account? <a href="signup.php">Register Here</a></p>
</div>

<?php
// JavaScript redirect (SAFE)
if($redirect != ""){
    echo "<script>
            alert('Login Successful!');
            window.location.href = '$redirect';
          </script>";
}
?>

</body>
</html>
