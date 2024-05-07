<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if product_id and other fields are set
    if(isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['quantity']) && isset($_POST['threshold_quantity']) && isset($_POST['price'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $quantity = $_POST['quantity'];
        $threshold_quantity = $_POST['threshold_quantity'];
        $price = $_POST['price'];
        
        // Establish a database connection
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "electric-web";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and execute update query
        $sql = "UPDATE product_details SET product_name=?, quantity=?, threshold_quantity=?, price=? WHERE product_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiii", $product_name, $quantity, $threshold_quantity, $price, $product_id);

        if ($stmt->execute()) {
            // Update successful
            $_SESSION['status'] = "Product details updated successfully";
            $_SESSION['status_code'] = "success";
            header("Location: view_products.php");
            exit();
        } else {
            // Update failed
            $_SESSION['status'] = "Error updating product details: " . $stmt->error;
            $_SESSION['status_code'] = "error";
            header("Location: view_products.php");
            exit();
        }

        $stmt->close();
        $conn->close();
    } else {
        // Product details not provided
        $_SESSION['status'] = "All fields are required";
        $_SESSION['status_code'] = "error";
        header("Location: view_products.php");
        exit();
    }
} else {
    // Invalid request method
    $_SESSION['status'] = "Invalid request method";
    $_SESSION['status_code'] = "error";
    header("Location: view_products.php");
    exit();
}
?>
