<?php
require("../_dbConnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
       <!-- navigation -->
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
            <a class="navbar-brand material-symbols-outlined" href="profile.php">manage_accounts</a>
            <a class="navbar-brand material-symbols-outlined" href="cartitems.php">shopping_cart</a>
            <a class="navbar-brand" href="logout.php">Logout</a>
        </nav>
        
        <div class="container text-center mt-3">
            <img src="../User/logo/s1.jpg" alt="Logo" style="width: 100px; height: 100px;" >
            <h1>Mobile Mania</h1>
        </div>
    </header>

    <section class="container mt-5 text-center flex-grow-1">
        <h1>Contact Us</h1>
        <p>If you have any questions, feedback, or need assistance, please feel free to contact us. We're here to help!</p>
        <p>You can reach us through the following methods:</p>
        
        <div class="row">
            <div class="col-md-4">
                <h2>Email</h2>
                <p>Email: <a href="mobilemania@google.com">mobilemania@google.com</a></p>
            </div>

            <div class="col-md-4">
                <h2>Phone</h2>
                <p>Customer Support: 033 29774570</p>
            </div>

            <div class="col-md-4">
                <h2>Address</h2>
                <p>Anandapur<br>Kolkata, 700107<br>India</p>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-light py-3">
        <div class="container text-center">
            <div class="footer-content">
                <p>&copy; <?php echo date("Y") ?>  Mobile Mania</p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>
</html>
