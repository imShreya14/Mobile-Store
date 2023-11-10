<!-- 128 if -->
<!-- session -->

<?php
include("../_dbConnect.php");

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    // header("location: login.php");
    // exit();
} else{

    // Retrieve user-specific information: name, email not required
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
}

// Query to fetch products from the database
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Mania</title>
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
            <h1>Welcome to Mobile Mania</h1>
        </div>
    </header>

    <!-- slideshow -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="..\Admin\productImages\banner\Banner1.png" class="d-block w-100" alt="First slide">
            </div>
            <div class="carousel-item">
                <img src="..\Admin\productImages\banner\Banner2.png" class="d-block w-100" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img src="..\Admin\productImages\banner\Banner3.jpeg" class="d-block w-100" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img src="..\Admin\productImages\banner\Banner4.jpg" class="d-block w-100" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img src="..\Admin\productImages\banner\Banner5.jpg" class="d-block w-100" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img src="..\Admin\productImages\banner\Banner6.jpg" class="d-block w-100" alt="Second slide">
            </div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <br>

    <h2 id="fp">Featured Products</h2>
    <section class="featured-products">

        <div class="row">
            <?php
            // Check if there are any products in the database
            if (mysqli_num_rows($result) > 0) {
                // Output each product's details using a loop
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="' . $row['proimage'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                    echo '<p class="card-text">Brand: ' . $row['brand'] . '</p>';

                    if ($row['quan'] > 0) {
                        // Product is in stock, display price and add to cart button
                        echo '<p class="card-text">Price: ₹' . $row['price'] . '</p>';
                        $pid = $row['proid'];

                        if(isset($_SESSION['user_id'])){
                            $query = "SELECT * FROM cart WHERE userid = '$user_id' AND proid = '$pid'";
                            $res = mysqli_query($conn, $query);

                            if (mysqli_num_rows($res) == 0) {
                                echo '<form action="cart.php" method="get">';
                                echo '<input type="hidden" name="product_id" value="' . $row['proid'] . '">';
                                echo '<button type="submit" class="btn btn-primary">Add to Cart</button>';
                                echo '</form>';
                            } else {
                                echo "<p style='color:red;'>Added</p>";
                            }
                        }

                    } else {
                        // Product is out of stock
                        echo '<p class="card-text">Out of Stock</p>';
                    }

                    echo '</div>'; // Close card-body
                    echo '</div>'; // Close card
                    echo '</div>'; // Close column
                }
            } else {
                echo '<div class="col-12">No products found.</div>';
            }
            ?>
        </div>
    </section>

    <section class="about-us mt-5">
        <div class="container">
            <a href="about.php">
                <h2>About Us</h2>
            </a>
            <p>We offer a wide range of mobile phones and accessories. Shop with us for the latest smartphones at great prices.</p>
        </div>
    </section>

    <footer class="bg-dark text-light py-3">
        <div class="container text-center">
            <p>&copy; <?php echo date("Y"); ?> Mobile Mania</p>
            <ul class="list-inline">
                    <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="#">Terms of Service</a></li>
            </ul>
        </div>
    </footer>

    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>