<!-- Admin login -->
<!-- Site key: 6Lc6COgoAAAAAFugi6aNxhHTss4I2w-gbeUkAx7x -->
<!-- Secret key: 6Lc6COgoAAAAADW72D8YVxGucv6aTSVxA4Dqk1yh -->

<?php
include("../_dbConnect.php");

// CAPTCHA
include("reCAPTCHA.php");

$message = ""; // store login messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrId = $_POST['email_or_id'];
    $password = $_POST['password'];
    
    // CAPTCHA
    $secretKey = "6Lc6COgoAAAAADW72D8YVxGucv6aTSVxA4Dqk1yh";
    $responseKey = $_POST['g-recaptcha-response']; // Fix the variable name here
    $userIP = $_SERVER['REMOTE_ADDR'];
    $reCaptchaResult = verifyRecaptcha($responseKey, $userIP, $secretKey);

    if ($reCaptchaResult->success) {
        // Check if the email or ID exists in the adminreg table
        $query = "SELECT * FROM adminreg WHERE ademail = '$emailOrId' OR adid = '$emailOrId'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // If password matches with the database
            if ($password === $row['adpassword']) {
                session_start(); // Start the session if not already started

                // Store admin information in session
                $_SESSION['admin_id'] = $row['adid'];
                $_SESSION['admin_email'] = $row['ademail'];

                // Admin Home Page after successful login
                header("location: product.php");
                exit(); // to prevent further code execution
            } else {
                $message = "<span style='color: red;'>Incorrect password.</span>";
            }
        } else {
            $message = "<span style='color: red;'>Admin account does not exist.</span>";
        }
    } else {
        echo "<span style='color: red;'>CAPTCHA Failed!</span>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <header>
        <div class="container text-center mt-3">
            <img src="../User/logo/s1.jpg" alt="Logo" style="width: 100px; height: 100px;" >
            <h1>Admin Login</h1>
        </div>
    </header>

    <div class="container"  style="width: 25%">

        <form method="post" autocomplete="on">
            <div class="form-group">
                <label for="email_or_id">Email or ID:</label>
                <input type="text" class="form-control" placeholder="Email or ID" name="email_or_id" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>

            <!-- <div class="form-group d-flex justify-content-center"> -->
                <div class="g-recaptcha mb-3" data-sitekey="6Lc6COgoAAAAAFugi6aNxhHTss4I2w-gbeUkAx7x"></div>
            <!-- </div> -->

            <button type="submit" name="Submit" class="submit btn btn-primary">Login</button>
            
            <!-- Register adminreg.php -->
            <div class="mt-3">
                Don't have an account?
                <a href="adminreg.php">Register</a>
            </div>

            <div class="error-message">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>
        </form>
    </div>

    <footer class="text-center mt-5">
        &copy; <?php echo date("Y"); ?> Mobile Mania. All rights reserved.
    </footer>
</body>
</html>