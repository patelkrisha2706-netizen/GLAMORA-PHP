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
  <title>Add Category</title>
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
    }

    .btn-primary {
      background-color: #c49a6c;
      border: none;
    }

    .btn-primary:hover {
      background-color: #a87f5c;
    }

    .form-label {
      color: #7c5e46;
      font-weight: 500;
    }

    .form-control {
      background-color: #fffaf5;
      border: 1px solid #d5c8bc;
      color: #5a4c42;
    }
  </style>
</head>
<body>

  <div class="sidebar">
    <h4>Glamora Admin</h4>
    <hr style="border-color: #e0d7cf;">
    <p><strong><?= $_SESSION['email']; ?></strong></p>
    <div>
      <a href="Dashboard.php">Dashboard</a>
      <a href="ReadCategory.php">Read Category</a>
      <a href="CreateProduct.php">Add Product</a>
      <a href="ReadProduct.php">Read Product</a>
      <a href="ManageUser.php">Manage Users</a>
      <a href="ManageOrder.php">Manage Orders</a>
      <a href="ManageReview.php">Manage Reviews</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="topbar">
    <h5>Dashboard &nbsp; <small class="text-white-50">Welcome to Admin Dashboard</small></h5>
  </div>

  <div class="main">
    <div class="container">
      <h3 class="mb-4">Add New Category</h3>

      <div class="card p-4">
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="cname" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Category Description</label>
            <input type="text" name="description" class="form-control" required>
          </div>

          <button type="submit" name="create" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>

</body>
</html>

<?php
if(isset($_POST['create'])){
  $cname = $_POST['cname'];
  $description = $_POST['description'];

  $q = "insert into category values (null, '$cname', '$description')";
  if(mysqli_query($mysql, $q)){
    header("location:ReadCategory.php?added=1");
  } else {
    echo "<script>alert('Failed to add category.');</script>";
  }
}
?>
