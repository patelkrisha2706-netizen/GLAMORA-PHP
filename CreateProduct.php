<?php
  session_start();
  if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit();
  }
  require '../db.php';

  // Handle form submit
  if (isset($_POST['submit'])) {
    $pname = mysqli_real_escape_string($mysql, $_POST['pname']);
    $pdescription = mysqli_real_escape_string($mysql, $_POST['pdescription']);
    $price = mysqli_real_escape_string($mysql, $_POST['price']);
    $cat = mysqli_real_escape_string($mysql, $_POST['cat']);

    $fname = $_FILES['image']['name'];
    $fpath = $_FILES['image']['tmp_name'];

    $q = "INSERT INTO product (pname, pdescription, price, image, cid) VALUES ('$pname', '$pdescription', '$price', '$fname', '$cat')";

    if (mysqli_query($mysql, $q)) {
        move_uploaded_file($fpath, "./uploads/" . $fname);
        header("location:ReadProduct.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($mysql);
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Product</title>
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

<div class="sidebar">
  <h4>Glamora Admin</h4>
  <hr style="border-color: #e0d7cf;">
  <p><strong><?= $_SESSION['email']; ?></strong></p>
  <div>
    <a href="Dashboard.php">Dashboard</a>
    <a href="CreateCategory.php">Add Category</a>
    <a href="ReadCategory.php">Read Category</a>
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
  <div class="form-container">
    <h2>Add New Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <table class="table table-borderless">
        <tr>
          <td><label>Product Name</label></td>
          <td><input type="text" name="pname" class="form-control" required></td>
        </tr>
        <tr>
          <td><label>Description</label></td>
          <td><textarea name="pdescription" class="form-control" rows="3" required></textarea></td>
        </tr>
        <tr>
          <td><label>Price (₹)</label></td>
          <td><input type="number" name="price" class="form-control" required></td>
        </tr>
        <tr>
          <td><label>Image</label></td>
          <td>
            <input type="file" name="image" class="form-control" accept="image/*" required >
            <img id="preview" src="#" alt="Preview">
          </td>
        </tr>
        <tr>
          <td><label>Category</label></td>
          <td>
            <select name="cat" class="form-select" required>
              <option value="">-- Select Category --</option>
              <?php
              $Result = mysqli_query($mysql, "select cid, cname from category");
              while ($r = mysqli_fetch_assoc($Result)) {
                echo "<option value='{$r['cid']}'>{$r['cname']}</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-center">
            <button type="submit" name="submit" class="btn btn-custom">Add Product</button>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
</body>
</html>
