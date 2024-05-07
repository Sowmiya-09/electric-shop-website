<?php
require "config.php";

// Initialize variables
$startDate = date('Y-m-01'); // Default start date: First day of the current month
$endDate = date('Y-m-t'); // Default end date: Last day of the current month
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get start and end dates from the form
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    // SQL query to fetch sales data within the selected time period
    $sql = "SELECT ip.PNAME, SUM(ip.QTY) AS total_sold
            FROM invoice i
            JOIN invoice_products ip ON i.SID = ip.SID
            WHERE i.INVOICE_DATE BETWEEN '$startDate' AND '$endDate'
            GROUP BY ip.PNAME
            ORDER BY total_sold DESC"; // Order by total_sold in descending order
    $result = $con->query($sql);

    if ($result->num_rows == 0) {
        $message = "No sales recorded for the selected time period.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Sales Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="nav.css">
</head>
<style>
    body{
        background-image: url(bg.jpg);        
        background-size: cover;
        
    }
    .container{
        background-color: whitesmoke;
        margin-top: 20px;
    }
    #heading{
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
        color: #187fed;
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
    <h2 id="heading">Monthly Sales Report</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group row">
            <label for="start_date" class="col-sm-2 col-form-label">Start Date:</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $startDate; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="end_date" class="col-sm-2 col-form-label">End Date:</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $endDate; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-4">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </div>
        </div>
    </form>
    <br>
    <div>
        <?php
        if ($message != "") {
            echo "<div class='alert alert-info'>" . $message . "</div>";
        }
        ?>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Total Sold</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (isset($result) && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["PNAME"] . "</td>";
                echo "<td>" . $row["total_sold"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
