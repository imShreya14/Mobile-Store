<?php

include("../_dbConnect.php");
include("reCAPTCHA.php");

// Regenerate session ID to start a new session
session_regenerate_id(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrId = $_POST['email_or_id'];
    $password = $_POST['password'];

    $secretKey = "6Lc6COgoAAAAADW72D8YVxGucv6aTSVxA4Dqk1yh";
    $resposnseKey = $_POST['g-recaptcha-response'];
    $UserIP = $_SERVER['REMOTE_ADDR'];
    $url="https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$resposnseKey&remoteip=$UserIP";

    $response = file_get_contents($url);
    $response = json_decode($response);

    if($response->success) {

    // Check if the email or ID exists in the database
    $query = "SELECT * FROM users WHERE email = '$emailOrId' OR userid = '$emailOrId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($password === $row['password']) {
            // Store user information in session
            $_SESSION['user_id'] = $row['userid'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];

            // Creating a unique cart for the user (if it doesn't exist)
            if (!isset($_SESSION['cart_id'])) {
                // Generating a unique cart ID for the user (e.g., user's ID + current timestamp)
                $cart_id = $row['userid'] . '_' . time();

                // Store the cart ID in the session
                $_SESSION['cart_id'] = $cart_id;
            }

            header("location: home.php");
            exit(); // Make sure to exit after redirecting
        } else {
            echo "<span style = 'color: red;'>Incorrect password</span>";
        }
    } else {
        $errorMessage = "<span style = 'color: red;'>Account does not exist</span>";
    }
}else{
    echo "<span style = 'color: red;'>CAPTCHA Failed!</span>";
}
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand material-symbols-outlined" onclick="goBack()">arrow_back_ios</a>
            
            <script>
                function goBack() {
                window.history.back();
                }
            </script>
        <a class="navbar-brand material-symbols-outlined" href="home.php">home</a>
        <a class="navbar-brand" href="about.php">About</a>
        <a class="navbar-brand" href="contact.php">Contact</a>
        
    </nav>
    <div class="container text-center mt-3">
        <img src="logo/s1.jpg" alt="Logo" style="width: 100px; height: 100px;" >
        <h1>User Login</h1>
    </div>
</header>

<div class="container" style="width: 25%">

    <form action="login.php" method="post">
        <div class="form-group">
            <label for="email_or_id">Enter Email or ID:</label>
            <input type="text" class="form-control" placeholder="Email or ID" name="email_or_id" required>
        </div>

        <div class="form-group">
            <label for="password">Enter Password:</label>
            <input type="password" class="form-control" placeholder="Password" name="password" required>
        </div>

        <div class="g-recaptcha mb-3" data-sitekey="6Lc6COgoAAAAAFugi6aNxhHTss4I2w-gbeUkAx7x"></div>

        <button type="submit" class="btn btn-primary">Login</button>
        
        <div class="error-message">
            <?php
            if (isset($errorMessage)) {
                echo $errorMessage;
            }
            ?>
        </div>
        
        <div class="mt-3">
            Don't have an account?
            <a href="reg.php">Register</a>
        </div>
    </form>
</div>

<!-- <footer class="text-center mt-5">
    &copy; <?php echo date("Y"); ?> Mobile Mania. All rights reserved.
</footer> -->

<footer class="bg-dark text-light py-3">
    <div class="container text-center">
        <p>&copy; <?php echo date("Y"); ?> Mobile Mania</p>
        <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="#">Terms of Service</a></li>
        </ul>
    </div>
</footer>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>