<?php
require "config.php";

// Fetch products with quantity less than their respective threshold values
$sql = "SELECT * FROM product_details WHERE quantity < threshold_quantity";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Quantity Notification</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="nav.css">
</head>
<style>
    body{
        background-image: url(3.jpg);
    }
    .container{
        padding:20px;
    }
    .table{
        background-color: whitesmoke;
    }
</style>    
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
    <h2 style="text-align:center;color:#185fed;">Product Quantity Notification</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Current Quantity</th>
            <th>Threshold Quantity</th>
            <th>Notification</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productName = $row["product_name"];
                $currentQuantity = $row["quantity"];
                $thresholdQuantity = $row["threshold_quantity"];

                // Check if current quantity is below the threshold
                if ($currentQuantity < $thresholdQuantity) {
                    $notification = "<span class='badge badge-warning'>Low Quantity</span>";
                } else {
                    $notification = ""; // No notification
                }

                // Display product details and notification
                echo "<tr>";
                echo "<td>$productName</td>";
                echo "<td>$currentQuantity</td>";
                echo "<td>$thresholdQuantity</td>";
                echo "<td>$notification</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No products with low quantity.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
