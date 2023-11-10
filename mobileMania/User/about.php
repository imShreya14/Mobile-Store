<?php
require("../_dbConnect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
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
            <img src="logo/s1.jpg" alt="Logo" style="width: 100px; height: 100px;" >
            <h1>Mobile Mania</h1>
        </div>
    </header>

    <section class="container my-5">
        <h1>About Us</h1>
        <p>Welcome to Mobile Mania, your one-stop destination for the latest and greatest mobile devices. We are dedicated to providing you with the best mobile shopping experience.</p>
        <p>Our mission is to offer a wide selection of high-quality mobile phones and accessories at competitive prices. We understand the importance of staying connected in today's fast-paced world, and we strive to make the latest technology accessible to everyone.</p>
        <p>At Mobile Mania, we believe in customer satisfaction above all else. Our team of experts is here to assist you in finding the perfect mobile device that suits your needs. Whether you're looking for a flagship smartphone, a budget-friendly option, or accessories to enhance your mobile experience, we've got you covered.</p>
        <p>Thank you for choosing Mobile Mania for all your mobile shopping needs. We look forward to serving you and helping you stay connected with the world.</p>
    </section>

    <footer class="bg-dark text-light py-3">
        <div class="container text-center">
            <div class="footer-content">
                <p>&copy; <?php echo date("Y"); ?> Mobile Mania</p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>
</html>
