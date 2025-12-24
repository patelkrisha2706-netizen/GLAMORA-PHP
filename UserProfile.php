<?php
session_start();
require 'db.php';

// ✅ Check if logged in
if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first!');window.location='LoginUser.php';</script>";
    exit;
}

$uid = $_SESSION['uid'];

// ✅ Fetch user details
$q = "SELECT * FROM user WHERE uid='$uid' LIMIT 1";
$result = mysqli_query($mysql, $q);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User not found. Please login again.');window.location='LoginUser.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile - GLEMORA</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #6a1b9a;
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 12px;
        }

        .label {
            font-weight: bold;
            color: #444;
        }

        .list-group-item {
            font-size: 16px;
        }
    </style>
</head>
<body>

<?php require 'DynamicHeader.php'; ?>

<div class="profile-container">
    <h2>Welcome, <?php echo $_SESSION['uname']; ?> 👋</h2>

    <div class="row"><span class="label">Full Name: <?php echo $user['uname']; ?></div>
    <div class="row"><span class="label">Email: <?php echo $user['uemail']; ?></div>
    <div class="row"><span class="label">Phone: <?php echo $user['phone']; ?></div>
    <div class="row"><span class="label">Gender: <?php echo $user['gender']; ?></div>
    <div class="row"><span class="label">Address: <?php echo $user['address']; ?></div>
    <div class="row"><span class="label">Status: <?php echo $user['status']; ?></div>

    <!-- ✅ My Activity inside same container -->
    <hr>
    <h4 class="mt-4 mb-3 text-center text-primary">My Activity</h4>
    <div class="list-group">

        <a href="WishList.php" class="list-group-item list-group-item-action d-flex align-items-center">
            <span style="color: red; font-size: 1.2em;" class="me-2">❤️</span>
            Wishlisted Products
        </a>

        <a href="Cart.php" class="list-group-item list-group-item-action d-flex align-items-center">
            <span style="color: #28a745; font-size: 1.2em;" class="me-2">🛒</span>
            Add To Cart 
        </a>

        <a href="MyOrder.php" class="list-group-item list-group-item-action d-flex align-items-center">
            <span style="color: #17a2b8; font-size: 1.2em;" class="me-2">📦</span>
            My Order
        </a>

        <a href="LogOutUser.php" class="list-group-item list-group-item-action d-flex align-items-center">
            <span style="color: #dc3545; font-size: 1.2em;" class="me-2">🚪</span>
            Logout
        </a>
    </div>
</div>

<?php require 'Footer.php'; ?>
</body>
</html>