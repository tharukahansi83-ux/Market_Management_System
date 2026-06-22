<?php
$conn = mysqli_connect("localhost","root","","miniproject");

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
