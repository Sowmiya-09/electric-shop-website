<?php
session_start();

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "electric-web";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if(isset($_POST["submit"])){
    $email=$_POST["email"];
    $password=$_POST["password"];
    $result=mysqli_query($conn,"SELECT * FROM register WHERE email = '$email' ");
    $row=mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){
        if($password == $row["password"]){
            $_SESSION["login"] = true;
            $_SESSION["email"] = $row["email"];
            /*$_SESSION['status']="Login successfully";
              $_SESSION['status_code']="success";*/
            header("Location:../home/nav.html");
        }
       /*else{
           echo 
      "<script> alert('Wrong password'); </script>";
        }
    }
    else{
        echo 
      "<script> alert('User not registered'); </script>";
    }*/
   else{
        $_SESSION['status']="Wrong password";
        $_SESSION['status_code']="error";  
        header("Location:Home.php");
    }
}
else{
    $_SESSION['status']="User not registered";
    $_SESSION['status_code']="error";  
    header("Location:Home.php");
 }

}
?>
