<?php
include("../_dbConnect.php");

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if they are not logged in
    header("location: login.php");
    exit();
}

// Retrieve user-specific information
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

$sql = "SELECT p.proimage, ci.proid, p.name, p.brand, p.price, ci.quan FROM cart ci
        JOIN product p ON ci.proid = p.proid
        WHERE ci.userid = ?";
$stmt = mysqli_prepare($conn, $sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle quantity updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $proid = $_POST['proid'];
    $quantity = $_POST['quantity'];

    if ($_POST['update_quantity'] === '+') {    // Increment quantity
        $quantity++;
    } elseif ($_POST['update_quantity'] === '-') {  // Decrement quantity (if not already 1)
        if ($quantity > 1) {
            $quantity--;
        }
    }
    
    // Update the quantity in the database
    $update_query = "UPDATE cart SET quan = ? WHERE userid = ? AND proid = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    $update_stmt->bind_param('iss', $quantity, $user_id, $proid);

    if ($update_stmt->execute()) {
        // Quantity updated successfully
        header("location: cartitems.php");
        exit();
    }
}

// Handle item deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_item'])) {
    $proid = $_POST['proid'];

    // Delete the item from the cart
    $delete_query = "DELETE FROM cart WHERE userid = ? AND proid = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    $delete_stmt->bind_param('ss', $user_id, $proid);

    if ($delete_stmt->execute()) {
        // Item deleted successfully
        header("location: cartitems.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
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
            <img src="logo/s1.jpg" alt="Logo" style="width: 100px; height: 100px;" >
            <h1>Mobile Mania</h1>
        </div>
    </header>

    <section class="container mt-5 text-center flex-grow-1">
        <h2>Cart Items</h2>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                $total = 0;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-lg-6">
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="<?php echo $row['proimage']; ?>" alt="<?php echo $row['name']; ?>" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['brand']; ?></h5>
                                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['name']; ?></h6>
                                        <p class="card-text">Price: ₹<?php echo $row['price']; ?></p>
                                        <form method="post">
                                            <p>Quantity: <span id="quantity_<?php echo $row['proid']; ?>"><?php echo $row['quan']; ?></span>
                                                <button type="submit" name="update_quantity" value="+" class="btn btn-primary">+</button>
                                                <button type="submit" name="update_quantity" value="-" class="btn btn-primary">-</button>
                                                <button type="submit" name="delete_item" class="btn btn-danger">Remove</button>
                                            </p>
                                            <input type="hidden" name="proid" value="<?php echo $row['proid']; ?>">
                                            <input type="hidden" name="quantity" value="<?php echo $row['quan']; ?>">
                                        </form>
                                        <p>Total: ₹<?php echo ($row['price'] * $row['quan']); ?></p>
                                        <?php $total += ($row['price'] * $row['quan']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                echo "<h4 class='col-12'>Total Cart Price: ₹" . $total . "</h4>";

                if ($result->num_rows > 0) {
                    echo '<div class="col-12">';
                    echo '<form action="payment.php" method="get">';
                    echo '<input type="hidden" name="total_price" value="' . $total . '">';
                    echo '<button type="submit" name="buy_now" class="btn btn-success">Buy Now</button>';
                    echo '</form>';
                    echo '</div>';
                } else {
                    echo '<p class="empty-cart-message col-12 text-center">Your cart is empty. You cannot proceed to payment.</p>';
                }
            } else {
                echo '<h3 class="text-center">Your cart is empty</h3>';
            }
            ?>
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
