<?php
include("../_dbConnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["payment_method"])) {
    $payment_method = $_POST["payment_method"];

    // Initialize user_id from session
    $user_id = $_SESSION['user_id'];

    if ($payment_method === "credit_card") {

        // Fetch all items from the cart for the user
        $cart_query = "SELECT proid, quan FROM cart WHERE userid = ?";
        $cart_stmt = mysqli_prepare($conn, $cart_query);
        $cart_stmt->bind_param('s', $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        // Loop through each item in the cart to update the product quantities
        while ($cart_row = $cart_result->fetch_assoc()) {
            $proid = $cart_row['proid'];
            $quantity = $cart_row['quan'];

            // Update the product table with the new quantity
            $update_product_query = "UPDATE product SET quan = quan - ? WHERE proid = ?";
            $update_product_stmt = mysqli_prepare($conn, $update_product_query);
            $update_product_stmt->bind_param('ii', $quantity, $proid);
            $update_product_stmt->execute();
        }

        // Check if payment is successful
        $credit_card_payment_successful = true;

        if ($credit_card_payment_successful) {
            echo "<h1>Credit Card payment successful!</h1>";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "<h1>Cart items have been cleared.</h1>";
            } else {
                echo "<span style = 'color: red;'Error clearing cart items.</span>";
            }
        } else {
            echo "<span style = 'color: red;'Credit Card payment failed.</span>";
        }
    } elseif ($payment_method === "paypal") {

        // Fetch all items from the cart for the user
        $cart_query = "SELECT proid, quan FROM cart WHERE userid = ?";
        $cart_stmt = mysqli_prepare($conn, $cart_query);
        $cart_stmt->bind_param('s', $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        // Loop through each item in the cart to update the product quantities
        while ($cart_row = $cart_result->fetch_assoc()) {
            $proid = $cart_row['proid'];
            $quantity = $cart_row['quan'];

            // Update the product table with the new quantity
            $update_product_query = "UPDATE product SET quan = quan - ? WHERE proid = ?";
            $update_product_stmt = mysqli_prepare($conn, $update_product_query);
            $update_product_stmt->bind_param('ii', $quantity, $proid);
            $update_product_stmt->execute();
        }

        // Check if payment is successful
        $paypal_payment_successful = true; // Replace with your actual payment check

        if ($paypal_payment_successful) {
            echo "<h1>PayPal payment successful!</h1>";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "<h1>Cart items have been cleared.</h1>";
            } else {
                echo "<span style = 'color: red;'Error clearing cart items.</span>";
            }
        } else {
            echo "<span style = 'color: red;'PayPal payment failed.</span>";
        }
    } elseif ($payment_method === "bank_transfer") {

        // Fetch all items from the cart for the user
        $cart_query = "SELECT proid, quan FROM cart WHERE userid = ?";
        $cart_stmt = mysqli_prepare($conn, $cart_query);
        $cart_stmt->bind_param('s', $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        // Loop through each item in the cart to update the product quantities
        while ($cart_row = $cart_result->fetch_assoc()) {
            $proid = $cart_row['proid'];
            $quantity = $cart_row['quan'];

            // Update the product table with the new quantity
            $update_product_query = "UPDATE product SET quan = quan - ? WHERE proid = ?";
            $update_product_stmt = mysqli_prepare($conn, $update_product_query);
            $update_product_stmt->bind_param('ii', $quantity, $proid);
            $update_product_stmt->execute();
        }

        // Check if payment is successful
        $bank_transfer_payment_successful = true;

        if ($bank_transfer_payment_successful) {
            echo "<h1>Bank Transfer payment successful!</h1>";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "<h1>Cart items have been cleared.</h1>";
            } else {
                echo "<span style = 'color: red;'Error clearing cart items.</span>";
            }
        } else {
            echo "<span style = 'color: red;'Bank Transfer payment failed.</span>";
        }
    } elseif ($payment_method === "cash_on_delivery") {

        // Fetch all items from the cart for the user
        $cart_query = "SELECT proid, quan FROM cart WHERE userid = ?";
        $cart_stmt = mysqli_prepare($conn, $cart_query);
        $cart_stmt->bind_param('s', $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        // Loop through each item in the cart to update the product quantities
        while ($cart_row = $cart_result->fetch_assoc()) {
            $proid = $cart_row['proid'];
            $quantity = $cart_row['quan'];

            // Update the product table with the new quantity
            $update_product_query = "UPDATE product SET quan = quan - ? WHERE proid = ?";
            $update_product_stmt = mysqli_prepare($conn, $update_product_query);
            $update_product_stmt->bind_param('ii', $quantity, $proid);
            $update_product_stmt->execute();
        }

        // Check if payment is successful
        $cash_on_delivery_payment_successful = true;

        if ($cash_on_delivery_payment_successful) {
           
            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "<h1>Cart items have been cleared.</h1>";
            } else {
                echo "<span style = 'color: red;'Error clearing cart items.</span>";
            }
        } else {
            echo "<span style = 'color: red;'cash on delivery payment failed.</span>";
        }
    }elseif ($payment_method === "google_pay") {

        // Fetch all items from the cart for the user
        $cart_query = "SELECT proid, quan FROM cart WHERE userid = ?";
        $cart_stmt = mysqli_prepare($conn, $cart_query);
        $cart_stmt->bind_param('s', $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        // Loop through each item in the cart to update the product quantities
        while ($cart_row = $cart_result->fetch_assoc()) {
            $proid = $cart_row['proid'];
            $quantity = $cart_row['quan'];

            // Update the product table with the new quantity
            $update_product_query = "UPDATE product SET quan = quan - ? WHERE proid = ?";
            $update_product_stmt = mysqli_prepare($conn, $update_product_query);
            $update_product_stmt->bind_param('ii', $quantity, $proid);
            $update_product_stmt->execute();
        }

        // Check if payment is successful
        $google_pay_payment_successful = true;

        if ($google_pay_payment_successful) {
            echo "<h1>Google pay payment successful!";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "<h1>Cart items have been cleared.";
            } else {
                echo "<span style = 'color: red;'Error clearing cart items.</span>";
            }
        } else {
            echo "<span style = 'color: red;'Google pay payment failed.</span>";
        }
    }elseif ($payment_method === "apple_pay") {

        // Fetch all items from the cart for the user
        $cart_query = "SELECT proid, quan FROM cart WHERE userid = ?";
        $cart_stmt = mysqli_prepare($conn, $cart_query);
        $cart_stmt->bind_param('s', $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();

        // Loop through each item in the cart to update the product quantities
        while ($cart_row = $cart_result->fetch_assoc()) {
            $proid = $cart_row['proid'];
            $quantity = $cart_row['quan'];

            // Update the product table with the new quantity
            $update_product_query = "UPDATE product SET quan = quan - ? WHERE proid = ?";
            $update_product_stmt = mysqli_prepare($conn, $update_product_query);
            $update_product_stmt->bind_param('ii', $quantity, $proid);
            $update_product_stmt->execute();
        }
        
        // Check if payment is successful
        $apple_pay_payment_successful = true;

        if ($apple_pay_payment_successful) {
            echo "<h1>Apple pay payment successful!";

            // Clear the cart items for the user
            $clear_cart_query = "DELETE FROM cart WHERE userid = ?";
            $clear_cart_stmt = mysqli_prepare($conn, $clear_cart_query);
            $clear_cart_stmt->bind_param('s', $user_id);

            if ($clear_cart_stmt->execute()) {
                echo "<h1>Cart items have been cleared.";
            } else {
                echo "<span style = 'color: red;'Error clearing cart items.";
            }
        } else {
            echo "<span style = 'color: red;'Apple pay payment failed.</span>";
        }
    }else {
        echo "<span style = 'color: red;'Invalid payment method selected.</span>";
    }
    
    // Redirect to the home page after 4 seconds
    header("refresh:4;url=home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
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
        <div class="payment-options">
            <h3>Select Payment Method:</h3>
            <form action="" method="post">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="credit_card" name="payment_method" value="credit_card">
                    <label class="form-check-label" for="credit_card">Credit Card</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" id="paypal" name="payment_method" value="paypal">
                    <label class="form-check-label" for="paypal">PayPal</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" id="bank_transfer" name="payment_method" value="bank_transfer">
                    <label class="form-check-label" for="bank_transfer">Bank Transfer</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" id="cash_on_delivery" name="payment_method" value="cash_on_delivery">
                    <label class="form-check-label" for="cash_on_delivery">Cash on Delivery</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" id="google_pay" name="payment_method" value="google_pay">
                    <label class="form-check-label" for="google_pay">Google Pay</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" id="apple_pay" name="payment_method" value="apple_pay">
                    <label class="form-check-label" for="apple_pay">Apple Pay</label>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Proceed to Payment</button>
            </form>
        </div>
    </section>

    <footer class="bg-dark text-light py-3">
        <div class="container text-center">
            <p>&copy; <?php echo date("Y"); ?> Mobile Store</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="#">Terms of Service</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
