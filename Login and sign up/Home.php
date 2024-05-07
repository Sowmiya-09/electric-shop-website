<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Login and Signup Form</title>
    <link rel="stylesheet" href="Home.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'> 
    <script src="sweetalert.js"></script>
    <script type="text/javascript">
        function preventBack(){window.history.forward()};
        setTimeout("preventBack()",0);
        window.onunload=function(){null;}
        </script>
</head>
<body>
    <!-- Login Form -->
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Login</header>
                <form action="login.php" method="POST" name="login_form" autocomplete="off">
                    <!--<div class="error-message" id="error-message"></div>-->
                    <div class="field input-field">
                        <input type="email" name="email" placeholder="Enter Email id" class="input" required="">
                    </div>
                    <div class="field input-field">
                        <input type="password" name="password" placeholder="Enter Password" class="password" required="">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="form-link">
                        <a href="#" class="forgot-pass">Forgot password?</a>
                    </div>
                    <div class="field button-field">
                        <button type="submit" name="submit" id="login" value="Login" onclick="load()">Login</button>
                    </div>
                </form>
                <div class="form-link">
                    <span>Don't have an account? <a href="#" class="link signup-link">Signup</a></span>
                </div>
            </div>
        </div>

        <!-- Signup Form -->
        <div class="form signup">
            <div class="form-content">
                <header>Signup</header>
                <form action="register.php" name="register_form" method="POST" autocomplete="off">
                    <div class="field input-field">
                        <input type="email" name="email" placeholder="Email id" class="input" required="">
                    </div>
                    <div class="field input-field">
                        <input type="password" name="password" placeholder="Create password" class="password" required="">
                    </div>
                    
                    <div class="field button-field">
                        <button type="submit" name="register_submit" value="Register">Register</button>
                    </div>
                </form>
                <div class="form-link">
                    <span>Already have an account? <a href="#" class="link login-link">Login</a></span>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="Home.js"></script>        

    <?php
    session_start();
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
        // Output JavaScript code to display the alert
        echo "<script>
            swal({
                title: '" . $_SESSION['status'] . "',
                icon: '" . $_SESSION['status_code'] . "',
                button: 'Okay!'
            });
        </script>";
        // Unset the session variable
        unset($_SESSION['status']);
    }
    ?>

</body>
</html>
