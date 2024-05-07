<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if product_id is set
    if(isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        
        // Fetch product details from the database
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "electric-web";
        
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Fetch product details from the database
        $sql = "SELECT * FROM product_details WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_name = $row['product_name'];
            $quantity = $row['quantity'];
            $threshold_quantity = $row['threshold_quantity'];
            $price = $row['price'];
        } else {
            echo "No product found with this ID.";
            exit();
        }
        
        $conn->close();
    } else {
        echo "Product ID not provided.";
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins";
            font-weight: 600;
            background: url(bg.jpg) no-repeat fixed 100% 100%;
            background-size: cover;
            height: 100vh;
            align-items: center;
        }
        #container {
            background-color: #ffffff; /* Background color for the form container */
            width: 400px; /* Reduced width */
            margin:0 auto; /* Center-align the container horizontally */
            padding: 10px; /* Reduced padding */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow to the container */
            height: auto; /* Adjusted to auto for smaller height */
        }

        h1 {
            color: #333; /* Heading color */
            font-size: 16px; /* Reduced font size */
            margin: 0 auto; /* Center-align the heading */
            text-align: center; /* Center-align the text within the heading */
            margin-bottom: 8px; /* Increased margin */
        }

        form {
            text-align: left; /* Align form content to the left */
        }

        label {
            display: block; /* Display labels in a block format */
            margin-bottom: 4px; /* Reduced margin */
            font-size: 12px; /* Reduced font size */
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 4px; /* Reduced padding */
            margin-bottom: 6px; /* Reduced margin */
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 12px; /* Reduced font size */
        }

        .btn {
            width: 48%; /* Set width to make both buttons 48% of container width */
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            text-align: center;
        }

        .btn-primary {
            background-color: #4CAF50; /* Green color for Add Medicine */
            color: #fff;
        }

        .btn-danger {
            background-color: #FF5733; /* Red color for Clear */
            color: #fff;
        }

        .form-group.pull-right {
            text-align: center;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <div id="container">
        <h1>Update Product Details</h1>
        <div class="container">
        <form action="update_products_handler.php" method="POST" autocomplete="off">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product_name; ?>" required><br>
            </div>
            <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required><br>
            </div>
            <div class="form-group">
            <label for="threshold_quantity">Threshold Quantity:</label>
            <input type="number" class="form-control" id="threshold_quantity" name="threshold_quantity" value="<?php echo $threshold_quantity; ?>" required><br>
            </div>
            <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $price; ?>" required><br>
            </div>
            <div class="form-group pull-right">
                <input type="submit" class="btn btn-primary" value="Update Product">
                <a href="view_products.php" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>
