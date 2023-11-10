<?php
include("../_dbConnect.php");

if (!isset($_SESSION['admin_id'])) {
    header("location: admin.php");
    exit();
}

// Initialize variables
$message = "";
$pid = "";
$randomNumber = (string)mt_rand(100, 999);

// Add product
if (isset($_POST['addProduct'])) {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];
    $productBrand = $_POST['productBrand'];

    // Handle image upload
    $targetDirectory = "../Admin/uploadImage/"; // Directory to store uploaded images
    $targetFile = $targetDirectory . basename($_FILES["productImage"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the image file is a valid type (you can add more image formats if needed)
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        $message = "<span style='color: red;'>Sorry, only JPG, JPEG, PNG, and GIF files are allowed</span>";
    } else {
        // Generate a unique product ID
        $proID = substr($productName, 0, 4) . $randomNumber;

        // Insert product into the database
        $insertQuery = "INSERT INTO product (proid, name, price, quan, brand, proimage) 
                        VALUES ('$proID', '$productName', '$productPrice', '$productQuantity', '$productBrand', '$targetFile')";

        if (mysqli_query($conn, $insertQuery)) {
            // Move the uploaded image to the target directory
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
                $message = "<span style='color: green;'>Product added successfully</span>";
                $pid = "<span style='color: green;'>Product Id is $proID</span>";
            } else {
                $message = "<span style='color: red;'>Error moving uploaded file</span>";
            }
        } else {
            $message = "<span style='color: red;'>Error adding product</span>" . mysqli_error($conn);
        }
    }
}

// Update product
if (isset($_POST['updateProduct'])) {
    $updateProductID = $_POST['updateProductID'];
    $newPrice = $_POST['newPrice'];
    $newQuantity = $_POST['newQuantity'];

    $rowCount = "SELECT * from product where proid = '$updateProductID' ";
    $query = mysqli_query($conn, $rowCount);
    $row = mysqli_num_rows($query);

    if($row == 0){
        echo "<span style='color: red;'>Product with this Product Id does not exist</span>";
    } else {
        // Perform the update query
        $updateQuery = "UPDATE product SET price = '$newPrice', quan = '$newQuantity' WHERE proid = '$updateProductID'";

        if (mysqli_query($conn, $updateQuery)) {
            $message = "<span style='color: green;'>Product updated successfully</span>";
        }
    }
}

// Delete product
if (isset($_POST['deleteProduct'])) {
    $deleteProductID = $_POST['deleteProductID'];

    $rowCount = "SELECT * from product where proid = '$deleteProductID' ";
    $query = mysqli_query($conn, $rowCount);
    $row = mysqli_num_rows($query);

    if($row == 0){
        echo "<span style='color: red;'>Product with this Product Id does not exist</span>";
    } else {
        $deleteQuery = "DELETE FROM product WHERE proid = '$deleteProductID'";

        if (mysqli_query($conn, $deleteQuery)) {
            $message = "<span style='color: green;'>Product deleted successfully</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../User/logo/s1.jpg" alt="Logo" width="50" height="50" class="d-inline-block align-top">
            </a>
            <h1 class="navbar-text">Admin Panel</h1>
            <button><a href="logout.php" class="btn btn-primary">Log Out</a></button>
        </div>
    </nav>

    <div class="container mt-4">
        <?php echo $message . "<br>" . $pid; ?>
    </div>

    <div class="container mt-4">
        <div class="row">
            <!-- Add -->
            <div class="col-md-4 border rounded my-margin">
                <form method="post" enctype="multipart/form-data">
                    <h2>Add Product</h2>

                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name:</label>
                        <input type="text" name="productName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Product Price:</label>
                        <input type="number" name="productPrice" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="productQuantity" class="form-label">Product Quantity:</label>
                        <input type="number" name="productQuantity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="productBrand" class="form-label">Product Brand:</label>
                        <input type="text" name="productBrand" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image:</label>
                        <input type="file" name="productImage" class="form-control" accept="image/*" required>
                    </div>

                    <button type="submit" name="addProduct" class="btn btn-primary">Add</button>
                </form>
            </div>
            
            <!-- Update -->
            <div class="col-md-4 border rounded my-margin">
                <form method="post">
                    <h2>Update Product</h2>

                    <div class="mb-3">
                        <label for="updateProductID" class="form-label">Product ID:</label>
                        <input type="text" name="updateProductID" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPrice" class="form-label">New Price:</label>
                        <input type="number" name="newPrice" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="newQuantity" class="form-label">New Quantity:</label>
                        <input type="number" name="newQuantity" class="form-control" required>
                    </div>
                    <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                </form>
            </div>

            <!-- Delete -->
            <div class="col-md-4 border rounded my-margin">
                <form method="post">
                    <h2>Delete Product</h2>
                    <div class="mb-3">
                        <label for="deleteProductID" class="form-label">Product ID:</label>
                        <input type="text" name="deleteProductID" class="form-control" required>
                    </div>
                    <button type="submit" name="deleteProduct" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-****" crossorigin="anonymous"></script>
</body>
</html>
