<?php
$_SESSION=[];
session_unset();
session_destroy();
header("Location: ../Login and sign up/home.php");
?>