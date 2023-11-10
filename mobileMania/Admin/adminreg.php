<?php
include("../_dbConnect.php");
$randomNumber = (string)mt_rand(100, 999);
$errorMsg = "";

if (isset($_POST['Submit'])) {
    $adminName = validSanitizeInput($_POST["AdminName"]);
    $adminID = substr($_POST["AdminName"], 0, 4) . $randomNumber;
    $adminEmail = validSanitizeInput($_POST["AdminEmail"]);
    $adminPhoneNo = validSanitizeInput($_POST["AdminPhoneNo"]);
    $adminPassword = validSanitizeInput($_POST["AdminPassword"]);
    $adminConfirmPassword = validSanitizeInput($_POST["AdminConfirmPassword"]);

     // remove all HTML tags, and all characters with ASCII value > 127
    $adminName = filter_var($adminName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);  //Sanitize

    // Input Validation and Sanitization
    $adminName = mysqli_real_escape_string($conn, $adminName);
    $adminEmail = filter_var($adminEmail, FILTER_SANITIZE_EMAIL);
    $adminPhoneNo = filter_var($adminPhoneNo, FILTER_SANITIZE_NUMBER_INT);
    // $adminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
    // $adminConfirmPassword = password_hash($adminConfirmPassword, PASSWORD_DEFAULT);

    if (!preg_match("/^[a-zA-Z-' ]*$/",$adminName)) {    // name
        $errorMsg = "Only letters and white space allowed in Name";
    } elseif (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) { //email
        $errorMsg = "Invalid email format.";
    } elseif (!preg_match("/^[0-9]{10}$/", $adminPhoneNo) || strlen($adminPhoneNo) !== 10 || !is_numeric($adminPhoneNo)) { // phone
        $errorMsg = "Invalid phone number format.";
    } elseif (strlen($adminPassword) < 8) {  //password
        $errorMsg = "Password should be at least 8 characters long.";
    } elseif ($adminPassword !== $adminConfirmPassword) {
        $errorMsg = "<span style='color: red;'>Passwords do not match</span>";
    } 
    else {
        // Check if admin email or phone number already exists
        $checkQuery = "SELECT * FROM adminreg WHERE ademail = '$adminEmail' OR adphno = '$adminPhoneNo'";
        
        $result = mysqli_query($conn, $checkQuery);
        //returns number of rows selected

        if (mysqli_num_rows($result) > 0) {
            $errorMsg = "<span style='color: red;'>Admin with this email or phone number already exists</span>";
        } 
        else {
            // Insert Admin Data wuth prepared statement
            $stmt = $conn->prepare("INSERT INTO adminreg (adid, adname, ademail, adphno, adpassword) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $adminID, $adminName, $adminEmail, $adminPhoneNo, $adminPassword);

            if ($stmt->execute()) {
                // Redirect after successful registration
                header("location: admin.php");
            } else {
                $errorMsg = "<span style='color: red;'>Registration Error</span>" . $stmt->error;
                // header("location: admin.php");
            }

            $stmt->close();
        }
    }
}

// validate sanitize
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
        <title>Admin Registration</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body>
        <header>
            <div class="container text-center mt-3">
                <img src="../User/logo/s1.jpg" alt="Logo" style="width: 100px; height: 100px;" >
                <h1>Admin Registration</h1>
            </div>
        </header>

        <div class="container border rounded"  style="width: 25%">

            <!-- Display error message-->
            <?php if (!empty($errorMsg)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMsg; ?>
            </div>
            <?php endif; ?>

            <form method="post" autocomplete="on">
                
                <!--Admin Name-->
                <div class="form-group">
                    <label for="AdminName">Name:</label> 
                    <input type="text" name="AdminName" class="form-control" placeholder="Admin Name" required>
                </div>

                <!--Admin Phone No.-->
                <div class="form-group">
                    <label for="AdminPhoneNo" >Phone No.:</label>
                        <input type="text" name="AdminPhoneNo" class="form-control" placeholder="Admin Phone No." required>
                </div>

                <!--Admin Email ID-->
                <div class="form-group">
                    <label for="AdminEmail" >Email: </label>
                    <input type="email" name="AdminEmail" class="form-control" placeholder="Admin Email Id" required>
                </div>

                <!-- Admin Password -->
                <div class="form-group">
                    <label for="AdminPassword">Password: </label>
                    <input type="Password" name="AdminPassword" class="form-control" placeholder="Admin Password" required>
                </div>

                <!-- Admin Confirm Password -->
                <div class="form-group">
                    <label for="AdminConfirmPassword">Password: </label>
                        <input type="Password" name="AdminConfirmPassword" class="form-control" placeholder="Confirm Password"  required>
                </div>

            <!--Submit-->
            <button type="submit" name="Submit" class="submit btn btn-primary">Sign Up</button>

            <!-- Login admin.php -->
            <div class="mt-3">
                Already have an account?
                <a href="admin.php">Login</a>
            </div>
        </form>
    </div>
</body>
</html>
