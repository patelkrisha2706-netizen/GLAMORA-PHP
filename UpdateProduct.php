<?php
session_start();
require '../db.php';

if(isset($_GET['pid'])){
    $pid = $_GET['pid'];
}

// --- LOGIC ---
if (isset($_POST['update'])) {
    $pname = $_POST['pname'];
    $pdescription = $_POST['pdescription'];
    $price = $_POST['price'];
    $cat = $_POST['cat'];

    // Fetch current product first
    $productQuery = "SELECT * FROM product WHERE pid='$pid'";
    $productResult = mysqli_query($mysql, $productQuery);
    $productData = mysqli_fetch_array($productResult);

    $newImage = $productData['image'];  // fallback to old image

    if (!empty($_FILES['image']['name'])) {
        $fname = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            $newImage = time() . "." . $ext;
            $fpath = $_FILES['image']['tmp_name'];

            if (!empty($productData['image']) && file_exists("../admin/uploads/" . $productData['image'])) {
                unlink("../admin/uploads/" . $productData['image']);
            }

            move_uploaded_file($fpath, "../admin/uploads/" . $newImage);
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG, WEBP allowed');</script>";
            exit;
        }
    }

    $updateQuery = "UPDATE product SET pname='$pname', pdescription='$pdescription', price='$price', image='$newImage', cid='$cat' WHERE pid='$pid'";

    if (mysqli_query($mysql, $updateQuery)) {
        header("Location: ReadProduct.php?updated=1"); // redirect works
        exit();
    } else {
        echo "<script>alert('Update failed.');</script>";
    }
}

// --- FETCH PRODUCT FOR DISPLAY ---
$productQuery = "SELECT * FROM product WHERE pid='$pid'";
$productResult = mysqli_query($mysql, $productQuery);
$productData = mysqli_fetch_array($productResult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Product</title>
<link href="../bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(to right, #f5e6d3, #fff6f0);
        font-family: 'Segoe UI', sans-serif;
    }
    .sidebar {
        height: 100vh;
        background-color: #7c5e46;
        color: white;
        padding: 20px;
        position: fixed;
        width: 220px;
    }
    .sidebar h4 {
        color: #ffffff;
        margin-bottom: 20px;
        font-size: 22px;
    }
    .sidebar a {
        color: #f3ece6;
        display: block;
        margin: 10px 0;
        text-decoration: none;
        font-size: 15px;
    }
    .sidebar a:hover {
        color: #c49a6c;
    }
    .topbar {
        background-color: #c49a6c;
        padding: 15px 30px;
        color: white;
        margin-left: 220px;
    }
    .main {
        margin-left: 240px;
        padding: 30px;
    }
    .form-container {
        max-width: 600px;
        margin: 20px auto;
        padding: 25px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    h2 {
        color: #b5895a;
        text-align: center;
        margin-bottom: 20px;
    }
    table td {
        padding: 8px;
        vertical-align: middle;
    }
    table label {
        font-weight: 500;
        color: #b5895a;
    }
    .form-control {
        background-color: #fffaf5;
        border: 1px solid #d5c8bc;
        color: #5a4c42;
    }
    .btn-custom {
        background-color: #b5895a;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
    }
    .btn-custom:hover {
        background-color: #a2784f;
    }
    #preview {
        max-width: 120px;
        margin-top: 5px;
        display: none;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
</style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <h4>Glamora Admin</h4>
    <hr style="border-color: #e0d7cf;">
    <p><strong><?= $_SESSION['email']; ?></strong></p>
    <div>
        <a href="Dashboard.php">Dashboard</a>
        <a href="CreateCategory.php">Add Category</a>
        <a href="ReadCategory.php">Read Category</a>
        <a href="CreateProduct.php">Add Product</a>
        <a href="ReadProduct.php">Read Product</a>
        <a href="ManageUser.php">Manage Users</a>
        <a href="ManageOrder.php">Manage Orders</a>
        <a href="ManageReview.php">Manage Reviews</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- Topbar -->
<div class="topbar">
    <h5>Dashboard &nbsp; <small class="text-white-50">Welcome to Admin Dashboard</small></h5>
</div>

<div class="form-container">
    <h2>Update Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <table class="table table-borderless">
            <tr>
                <td><label>Product Name</label></td>
                <td><input type="text" name="pname" value="<?= $productData['pname'] ?>" class="form-control" required></td>
            </tr>
            <tr>
                <td><label>Description</label></td>
                <td><textarea name="pdescription" class="form-control" rows="3" required><?= $productData['pdescription'] ?></textarea></td>
            </tr>
            <tr>
                <td><label>Price (₹)</label></td>
                <td><input type="number" name="price" value="<?= $productData['price'] ?>" class="form-control" required></td>
            </tr>
            <tr>
                <td><label>Image</label></td>
                <td>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <img id="preview" src="<?= $productData['image'] ?>" alt="">
                </td>
            </tr>
            <tr>
                <td><label>Category</label></td>
                <td>
                    <select name="cat" required>
                        <option value="">-- Select Category --</option>
                        <?php
                            $categoryResult = mysqli_query($mysql, "SELECT cid, cname FROM category");
                            while ($catRow = mysqli_fetch_assoc($categoryResult)) {
                                $selected = ($catRow['cid'] == $productData['cid']) ? "selected" : "";
                                echo "<option value='{$catRow['cid']}' $selected>{$catRow['cname']}</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>