<?php
// Check if product_id is set and not empty
if(isset($_POST['product_id']) && !empty($_POST['product_id'])) {
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

    // Prepare a DELETE statement
    $sql = "DELETE FROM product_details WHERE product_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    // Set parameters and execute
    $product_id = $_POST['product_id'];
    if ($stmt->execute()) {
        // Redirect to the product details page after successful deletion
        header("Location: view_products.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to the product details page if product_id is not provided
    header("Location: view_products.php");
    exit;
}
?>
