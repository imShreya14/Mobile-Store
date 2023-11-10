<?php
include("../_dbConnect.php");

// Initialize error message
$errorMsg = "";

// Generate a random 3-digit number
$randomNumber = (string) mt_rand(100, 999);

// Define variables
if (isset($_POST['Submit'])) {
	$name = validSanitizeInput($_POST["Name"]);
	$email = validSanitizeInput($_POST["email"]);
	$phoneNo = validSanitizeInput($_POST["phoneNo"]);
	$address = validSanitizeInput($_POST["address"]);
	$dob = validSanitizeInput($_POST["DOB"]);
	$password = validSanitizeInput($_POST["password"]);
	$confirmPassword = validSanitizeInput($_POST["confirmPassword"]); // Added field for confirm password

    // remove all HTML tags, and all characters with ASCII value > 127
    $name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);  //Sanitize

    // Validate
    if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {    // name
        $errorMsg = "Only letters and white space allowed in Name";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //email
        $errorMsg = "Invalid email format.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phoneNo) || strlen($phoneNo) !== 10 || !is_numeric($phoneNo)) { // phone
        $errorMsg = "Invalid phone number format.";
    } elseif (strlen($password) < 8) {  //password
        $errorMsg = "Password should be at least 8 characters long.";
    } elseif ($password !== $confirmPassword) {
        $errorMsg = "Passwords do not match.";
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $phoneNo = mysqli_real_escape_string($conn, $phoneNo);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $phoneNo = filter_var($phoneNo, FILTER_SANITIZE_NUMBER_INT);
        // Rest of the variables have been previously sanitized with the sanitizeInput function

		$checkQuery = "SELECT * FROM users WHERE email = '$email' OR phno = '$phoneNo'";
		$result = mysqli_query($conn, $checkQuery);

		if (mysqli_num_rows($result) > 0) {
			$errorMsg = "Email or phone number already exists.";
		} else {
			// Generate user ID
			$userID = substr($name, 0, 4) . $randomNumber;

			// Use prepared statement to insert data
			$stmt = $conn->prepare("INSERT INTO users (userid, name, email, phno, address, dob, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssss", $userID, $name, $email, $phoneNo, $address, $dob, $password);

			if ($stmt->execute()) {
				// Redirect after successful registration
				header("location: login.php");
			} else {
				$errorMsg = "Error: " . $stmt->error;
			}

			$stmt->close();
		}
	}
}

function validSanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand material-symbols-outlined" href="home.php">home</a>
            <a class="navbar-brand" href="contact.php">Contact</a>
            <a class="navbar-brand" href="about.php">About</a>
        </nav>
        <div class="container text-center mt-3">
            <img src="logo/s1.jpg" alt="Logo" style="width: 100px; height: 100px;" >
            <h1>User Registration</h1>
        </div>
    </header>

    <div class="container border rounded" style="width: 25%">

        <!-- Display error message if there is one -->
        <?php if (!empty($errorMsg)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMsg; ?>
            </div>
        <?php endif; ?>

		<!-- form -->
        <form method="post" autocomplete="on">

            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" name="Name" class="form-control" placeholder="Name" autofocus="on" required>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="phoneNo">Phone No.:</label>
                <input type="text" name="phoneNo" class="form-control" maxlength="10" placeholder="Phone No." required>
            </div>

            <!-- Email ID -->
            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="email" name="email" class="form-control" placeholder="Email Id" required>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" class="form-control" placeholder="Address" required>
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label for="DOB">Date of Birth:</label>
                <input type="date" name="DOB" class="form-control" placeholder="Date of Birth" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="Submit" class="submit btn btn-primary">Sign Up</button>

            <!-- Login Button Redirecting to login.php -->
            <div class="mt-3">
                Already have an account?
                <a href="login.php">Login</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <footer class="text-center mt-5">
        &copy; <?php echo date("Y"); ?> Your Website. All rights reserved.
    </footer>
</body>
</html>
