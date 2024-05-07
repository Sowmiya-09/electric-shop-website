<?php require "config.php"; ?>
<html>
<head>
    <title>Create Printable PDF invoice using PHP MySQL</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
    <script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="nav.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
    body{
        background-image: url(Bacgr.jpg);
        background-size: cover;
        font-family: "Poppins", sans-serif;
        font-weight: 550;
        font-style: normal;
    }
   .container{
        background-color: whitesmoke;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        margin-top: 20px;
        height: 100%;
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
    



<div class='container pt-5'>
    <h1 class='text-center text-primary'>Billing</h1><hr>
    <?php
    if(isset($_POST["submit"])){
        $invoice_no=$_POST["invoice_no"];
        $invoice_date=date("Y-m-d",strtotime($_POST["invoice_date"]));
        $cname=mysqli_real_escape_string($con,$_POST["cname"]);
        $caddress=mysqli_real_escape_string($con,$_POST["caddress"]);
        $ccity=mysqli_real_escape_string($con,$_POST["ccity"]);
        $grand_total=mysqli_real_escape_string($con,$_POST["grand_total"]);

        $sql="insert into invoice (INVOICE_NO,INVOICE_DATE,CNAME,CADDRESS,CCITY,GRAND_TOTAL) values ('{$invoice_no}','{$invoice_date}','{$cname}','{$caddress}','{$ccity}','{$grand_total}') ";
        if($con->query($sql)){
            $sid=$con->insert_id;

            $sql2="insert into invoice_products (SID,PNAME,PRICE,QTY,TOTAL) values ";
            $rows=[];
            for($i=0;$i<count($_POST["pname"]);$i++)
            {
                $pname=mysqli_real_escape_string($con,$_POST["pname"][$i]);
                $price=mysqli_real_escape_string($con,$_POST["price"][$i]);
                $qty=mysqli_real_escape_string($con,$_POST["qty"][$i]);
                $total=mysqli_real_escape_string($con,$_POST["total"][$i]);
                $rows[]="('{$sid}','{$pname}','{$price}','{$qty}','{$total}')";

                // Update product stock quantity in the product_details table
                $update_query = "UPDATE product_details SET quantity = quantity - ? WHERE product_name = ?";
                $stmt = $con->prepare($update_query);
                $stmt->bind_param("is", $qty, $pname);
                $stmt->execute();
                $stmt->close();
            }
            $sql2.=implode(",",$rows);
            if($con->query($sql2)){
                echo "<div class='alert alert-success'>Invoice Added Successfully. <a href='print.php?id={$sid}' target='_BLANK'>Click </a> here to Print Invoice </div> ";
            }else{
                echo "<div class='alert alert-danger'>Invoice Added Failed.</div>";
            }
        }else{
            echo "<div class='alert alert-danger'>Invoice Added Failed.</div>";
        }
    }
    ?>
    <form method='post' action='index.php' autocomplete='off'>
        <div class='row'>
            <div class='col-md-4'>
                <h5 class='text-success'>Invoice Details</h5>
                <div class='form-group'>
                    <label>Invoice No</label>
                    <input type='text' name='invoice_no' required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Invoice Date</label>
                    <input type='text' name='invoice_date' id='date' required class='form-control'>
                </div>
            </div>
            <div class='col-md-8'>
                <h5 class='text-success'>Customer Details</h5>
                <div class='form-group'>
                    <label>Name</label>
                    <input type='text' name='cname' required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>Address</label>
                    <input type='text' name='caddress' required class='form-control'>
                </div>
                <div class='form-group'>
                    <label>City</label>
                    <input type='text' name='ccity' required class='form-control'>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-md-12'>
                <h5 class='text-success'>Product Details</h5>
                <table class='table table-bordered'>
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id='product_tbody'>
                    <tr>
                        <td>
                            <select name='pname[]' class='form-control pname'>
                                <option value=''>Select Product</option>
                                <?php
                                $product_query = "SELECT product_name, price FROM product_details";
                                $result = $con->query($product_query);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row["product_name"] . "' data-price='" . $row["price"] . "'>" . $row["product_name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type='text' readonly name='price[]' class='form-control price'></td>
                        <td><input type='text' required name='qty[]' class='form-control qty'></td>
                        <td><input type='text' required name='total[]' class='form-control total'></td>
                        <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td><input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'></td>
                        <td colspan='2' class='text-right'>Total</td>
                        <td><input type='text' name='grand_total' id='grand_total' class='form-control' required></td>
                    </tr>
                    </tfoot>
                </table>
                <br><br>
                <input type='submit' name='submit' value='Save Invoice' class='btn btn-success float-right'>
                
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        $("#date").datepicker({
            dateFormat:"dd-mm-yy"
        });

        $("#btn-add-row").click(function(){
            var row="<tr> <td><select name='pname[]' class='form-control pname'><option value=''>Select Product</option><?php
                $product_query = "SELECT product_name, price FROM product_details";
                $result = $con->query($product_query);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["product_name"] . "' data-price='" . $row["price"] . "'>" . $row["product_name"] . "</option>";
                    }
                }
                ?></select></td> <td><input type='text' readonly name='price[]' class='form-control price'></td> <td><input type='text' required name='qty[]' class='form-control qty'></td> <td><input type='text' required name='total[]' class='form-control total'></td> <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";
            $("#product_tbody").append(row);
        });

        $("body").on("click",".btn-row-remove",function(){
            if(confirm("Are You Sure?")){
                $(this).closest("tr").remove();
                grand_total();
            }
        });

        $("body").on("change",".pname",function(){
            var price = $(this).find(':selected').data('price');
            $(this).closest("tr").find(".price").val(price);
            grand_total();
        });

        $("body").on("keyup",".qty",function(){
            var qty=Number($(this).val());
            var price=Number($(this).closest("tr").find(".price").val());
            $(this).closest("tr").find(".total").val(price*qty);
            grand_total();
        });

        function grand_total(){
            var tot=0;
            $(".total").each(function(){
                tot+=Number($(this).val());
            });
            $("#grand_total").val(tot);
        }
    });
</script>
</body>
</html>
