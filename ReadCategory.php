<?php
  session_start();
  if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit();
  }
  require '../db.php';
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Category Dashboard</title>
  <link href="../bootstrap.min.css" rel="stylesheet">
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

    .main {
      margin-left: 240px;
      padding: 30px;
    }

    .topbar {
      background-color: #c49a6c;
      padding: 15px 30px;
      color: #fff;
      margin-left: 220px;
    }

    .topbar h5 {
      margin: 0;
    }

    .action-links a {
      margin-right: 10px;
      font-weight: 500;
    }
    .table{
      width: 100%;
    }

    .table thead {
      background-color: #7c5e46;
      color: #fff;
    }

    .table td {
      vertical-align:middle;
    }

    .text-primary {
      color: #7c5e46 !important;
    }

    .text-danger {
      color: #a94442 !important;
    }

    .card {
      background-color: #fffaf5;
      border: none;
      box-shadow: 0 4px 12px rgba(124, 94, 70, 0.1);
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h4>GLAMORA Admin</h4>
    <hr style="border-color: #e0d7cf;">
    <p><strong><?= $_SESSION['email']; ?></strong></p>
    <div>
      <a href="Dashboard.php">Dashboard</a>
      <a href="CreateCategory.php">Add Category</a>
      <a href="CreateProduct.php">Add Product</a>
      <a href="ReadProduct.php">Read Product</a>
      <a href="ManageUser.php">Manage Users</a>
      <a href="ManageOrder.php">Manage Orders</a>
      <a href="ManageReview.php">Manage Reviews</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="topbar">
    <h5>Dashboard <small class="text-white-50">Welcome to Admin Dashboard</small></h5>
  </div>

  <div class="main">
    <div class="container-fluid">
      <h3 class="mb-4">Category List</h3>

      <div class="card">
        <div class="card-body">
          <?php
          $q = "select * from category";
          $result = mysqli_query($mysql, $q);
          $nor = mysqli_num_rows($result);

          if ($nor > 0) {
            echo "<table class='table table-bordered table-striped'>";
            echo "
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
            ";
            while ($r = mysqli_fetch_array($result)) {
              echo "
                <tr>
                  <td>$r[1]</td>
                  <td>$r[2]</td>
                  <td class='action-links'>
                    <a href='UpdateCategory.php?cid=$r[0]' class='text-primary'>Edit</a>
                    <a href='DeleteCategory.php?cid=$r[0]' class='text-danger'>Remove</a>
                  </td>
                </tr>
              ";
            }
            echo "</tbody></table>";
          } else {
            echo "<p>No categories found.</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>