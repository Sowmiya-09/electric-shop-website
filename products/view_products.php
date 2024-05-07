<?php
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

// Execute a SELECT query to fetch product details
$sql = "SELECT * FROM product_details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="nav.css">
    <title>Product Details</title>
    <style>
        body {
            background-image: url(bg1.webp); /* Add background image to the entire webpage */
            background-size: cover; /* Cover the entire background */
           
            font-family: "Poppins", sans-serif;
            font-weight: 550;
            font-style: normal;
        }
        .container{
            padding: 40px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white; /* Add white background color to the table */
            padding: 20px; /* Add padding around the table */
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #007BFF; /* Blue color for table header */
            color: #ffffff; /* White text color for table header */
        }
        .btn-container {
            display: flex;
            gap: 10px; /* Add space between buttons */
        }
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            color: #ffffff;
            cursor: pointer;
            border: none; 
            outline: none; 
        }
        .btn-edit {
            background-color: #28a745; /* Green color for edit button */
        }
        .btn-delete {
            background-color: #dc3545; /* Red color for delete button */
        }
    </style>
</head>
<body>
<div id="name">
          <header>
            <div class="nav-wrapper">
                <div class="logo-container">
                    <img class="logo" src="shop1.png" alt="Logo">
                </div>
                <nav>
                    <input class="hidden" type="checkbox" id="menuToggle">
                    <label class="menu-btn" for="menuToggle">
                        <div class="menu"></div>
                        <div class="menu"></div>
                        <div class="menu"></div>
                    </label>
                    <div class="nav-container">
                        <ul class="nav-tabs">
                            <li class="nav-tab" id="active"><a href="../home/nav.html" style="text-decoration: none; color: black;">Home</a></li>
                            <li class="nav-tab"><a href="../products/add_products.html" style="text-decoration: none; color: black;">Add products</a></li>
                            <li class="nav-tab"><a href="../products/view_products.php" style="text-decoration: none; color: black;">View products</a></li>
                            <li class="nav-tab"><a href="../invoice/index.php" style="text-decoration: none; color: black;">Billing</a></li>
                            <li class="nav-tab"><a href="../notification/notification.php" style="text-decoration: none; color: black;">Notification</a></li>
                            <li class="nav-tab"><a href="../report/report.php" style="text-decoration: none; color: black;">Report</a></li>
                            <li class="nav-tab"><a href="../Login and sign up/logout.php" style="text-decoration: none; color: black;">Logout</a></li>

                        </ul>
                    </div>
                </nav>
            </div>
          </header>
        </div>

    <div class="container">

    <h2 style="text-align:center;color:#185fed;">Product Details</h2>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Threshold Quantity</th>
            <th>Price</th>
            <th>Actions</th> <!-- New column for actions -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["product_id"] . "</td>";
                echo "<td>" . $row["product_name"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . $row["threshold_quantity"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td class='btn-container'>";
                // Edit form
                echo "<form action='update_products.php' method='POST'>";
                echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                echo "<button class='btn btn-edit btn-sm'>Edit</button>";
                echo "</form>";
                // Delete form
                echo "<form action='delete_products.php' method='POST'>";
                echo "<input type='hidden' name='product_id' value='" . $row["product_id"] . "'>";
                echo "<button class='btn btn-delete btn-sm'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No products found</td></tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
