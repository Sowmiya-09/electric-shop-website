<?php
session_start();

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$quantity = $_POST['quantity'];
$threshold_quantity = $_POST['threshold_quantity'];
$price = $_POST['price'];

if (!empty($product_id) && !empty($product_name) && !empty($quantity) && !empty($threshold_quantity) && !empty($price)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "electric-web";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    } else {
        // Check if product_id already exists in the database
        $check_query = "SELECT * FROM product_details WHERE product_id = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("i", $product_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            // Product ID already exists, display SweetAlert alert
            $_SESSION['status'] = "Product ID already exists in the database";
            $_SESSION['status_code'] = "error";
            header("Location: add_products.html");
            exit();
        }

        // Insert the new record if product_id does not exist
        $INSERT = "INSERT INTO product_details (product_id, product_name, quantity, threshold_quantity, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($INSERT);

        if (!$stmt) {
            die('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param("isiii", $product_id, $product_name, $quantity, $threshold_quantity, $price);

        if ($stmt->execute()) {
            $_SESSION['status'] = "Data added successfully";
            $_SESSION['status_code'] = "success";
            header("Location: add_products.html");
            exit();
        } else {
            $_SESSION['status'] = "Error inserting record: " . $stmt->error;
            $_SESSION['status_code'] = "error";
            header("Location: add_products.html");
            exit();
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $_SESSION['status'] = "All fields are required";
    $_SESSION['status_code'] = "error";
    header("Location: add_products.html");
    exit();
}
?>
