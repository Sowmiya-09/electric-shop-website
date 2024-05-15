<?php

session_start();

if(!empty($_SESSION["id"])){
  header("Location: ../home/nav.html");
}


$email = $_POST['email'];
$password = $_POST['password'];


if (!empty($email) || !empty($password) ) 
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "electric-web";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT email From register Where email = ? Limit 1";
  $INSERT = "INSERT Into register (email , password)values(?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking username
      if ($rnum>0) {
        /*echo 
      "<script> alert('Someone already register using this email'); </script>";*/
      $_SESSION['status']="Someone already register using this email id";
        $_SESSION['status_code']="error";
        header("Location:Home.php");
      } else {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ss", $email,$password);
      $stmt->execute();
      /*echo 
      "<script> alert('New record inserted sucessfully'); </script>";*/
      $_SESSION['status']="Registered successfully";
        $_SESSION['status_code']="success";
      header("Location:Home.php");
      
      
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo 
 "<script> alert('All field are required'); </script>";
 header("Location:Home.php");

 die();
}
?>