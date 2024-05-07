<?php

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "electric-web";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
session_start();
if(!empty($_SESSION['email'])){
    $phone_number=$_SESSION["email"];
    $result=mysqli_query($conn, "SELECT * FROM register WHERE email=$phone_number");
    $row=mysqli_fetch_assoc($result);
}
else{
    header("Location: ../Login and sign up/home.php");
}
?> 