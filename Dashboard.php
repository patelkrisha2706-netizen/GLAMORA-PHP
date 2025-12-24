<?php 
session_start();
if(!isset($_SESSION['email'])){
  header("location:index.php");
  exit();
}
require '../db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard | Glamora Admin</title>
  <link href="../bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #f3ece6;
      color: #5a4c42;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
      height: 100vh;
      background-color: #7c5e46;
      color: white;
      padding: 20px;
      position: fixed;
      width: 200px;
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

    .main {
      margin-left: 240px;
      padding: 30px;
    }

    .topbar {
      background-color: #c49a6c;
      padding: 15px 30px;
      color: white;
      margin-left: 200px;
    }

    .card {
      background-color: #fffaf5;
      border: none;
      box-shadow: 0 4px 12px rgba(124, 94, 70, 0.1);
      border-radius: 15px;
      transition: transform 0.2s;
    }

    .card:hover {
      transform: scale(1.03);
    }

    .stat-icon {
      font-size: 35px;
      color: #c49a6c;
    }

    .table {
      background-color: #fffaf5;
      border-radius: 10px;
      overflow: hidden;
    }

    .table thead {
      background-color: #c49a6c;
      color: white;
    }

    .table td, .table th {
      vertical-align: middle;
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

  <!-- Main -->
  <div class="main">
    <div class="container">
      <h3 class="mb-4">📊 Overview</h3>

      <?php
        // Dashboard counts
        $users = mysqli_fetch_array(mysqli_query($mysql, "SELECT COUNT(*) AS total FROM user"))['total'];
        $products = mysqli_fetch_array(mysqli_query($mysql, "SELECT COUNT(*) AS total FROM product"))['total'];
        $reviews = mysqli_fetch_array(mysqli_query($mysql, "SELECT COUNT(*) AS total FROM review"))['total'];
        $orders = mysqli_fetch_array(mysqli_query($mysql, "SELECT COUNT(*) AS total FROM order_t"))['total'];
        $categories = mysqli_fetch_array(mysqli_query($mysql, "SELECT COUNT(*) AS total FROM category"))['total'];
      ?>

      <div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card text-center p-3">
            <i class="fa fa-users stat-icon mb-2"></i>
            <h5>Total Users</h5>
            <h4><?= $users ?></h4>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center p-3">
            <i class="fa fa-gem stat-icon mb-2"></i>
            <h5>Total Products</h5>
            <h4><?= $products ?></h4>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center p-3">
            <i class="fa fa-list stat-icon mb-2"></i>
            <h5>Total Categories</h5>
            <h4><?= $categories ?></h4>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center p-3">
            <i class="fa fa-star stat-icon mb-2"></i>
            <h5>Total Reviews</h5>
            <h4><?= $reviews ?></h4>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center p-3">
            <i class="fa fa-box stat-icon mb-2"></i>
            <h5>Total Orders</h5>
            <h4><?= $orders ?></h4>
        </div>
    </div>
</div>

      </div>

    </div>
  </div>

</body>
</html>