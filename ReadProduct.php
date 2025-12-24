<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit();
}

require '../db.php';

// Handle Load More AJAX request
if (isset($_POST['offset']) && isset($_POST['limit'])) {
    $offset = intval($_POST['offset']);
    $limit = intval($_POST['limit']);

    $q = "SELECT * FROM product ORDER BY pid DESC LIMIT $offset, $limit";
    $result = mysqli_query($mysql, $q);

    while ($r = mysqli_fetch_assoc($result)) {
        echo "
        <tr>
            <td>{$r['pid']}</td>
            <td>{$r['pname']}</td>
            <td>{$r['pdescription']}</td>
            <td>{$r['price']}</td>
            <td>
                <img src='../admin/uploads/{$r['image']}' width='80' height='80' style='border-radius:8px; object-fit:cover;'>
            </td>
            <td>{$r['cid']}</td>
            <td>
                <a href='UpdateProduct.php?pid={$r['pid']}' class='text-primary'>Edit</a> |
                <a href='DeleteProduct.php?pid={$r['pid']}' class='text-danger'>Remove</a>
            </td>
        </tr>";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Products</title>
<link href="../bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
.container { 
    margin-top: 40px; 
    margin-left:250px; 
    width: 75%; 
}
body { 
    background-color: #f3ece6; 
    color: #5a4c42; 
    font-family: Segoe UI, sans-serif; 
}
.sidebar { 
    height: 100vh; 
    background:#7c5e46; 
    color:white; 
    padding:20px; 
    position:fixed; 
    width:220px; 
}
.sidebar a { 
    color: #f3ece6; 
    text-decoration:none; 
    display:block; 
    margin:10px 0; 
}
.sidebar a:hover { 
    color:#c49a6c; 
}
.topbar { 
    background:#c49a6c; 
    padding:15px 30px; 
    color:white; 
    margin-left:220px; 
}
img { 
    border-radius:5px; 
}
.btn-custom { 
    background:#b5895a; 
    color:white; 
}
.btn-custom:hover { 
    background:#a2784f; 
}
.btn-load { 
    width: 20%; 
    margin-top: 15px; 
    align: center; 
    background:#7c5e46;
}
.table {
    width: 120%;
}
</style>
</head>

<body>
<!-- Sidebar -->
<div class="sidebar">
  <h4>Glamora Admin</h4>
  <hr>
  <p><strong><?= $_SESSION['email']; ?></strong></p>
  <a href="Dashboard.php">Dashboard</a>
  <a href="CreateCategory.php">Add Category</a>
  <a href="ReadCategory.php">Read Category</a>
  <a href="CreateProduct.php">Add Product</a>
  <a href="ManageUser.php">Manage Users</a>
  <a href="ManageOrder.php">Manage Orders</a>
  <a href="ManageReview.php">Manage Reviews</a>
  <a href="logout.php">Logout</a>
</div>

<div class="topbar">
  <h5>Dashboard <small class="text-white-50">Welcome to Admin Dashboard</small></h5>
</div>

<div class="container">
<h2>Product List</h2>
<a href="CreateProduct.php" class="btn btn-custom mb-3">Add New Product</a>

<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>ID</th>
  <th>Name</th>
  <th>Description</th>
  <th>Price</th>
  <th>Image</th>
  <th>Category</th>
  <th>Action</th>
</tr>
</thead>

<tbody id="product-container"></tbody>
</table>

<button id="loadMore" class="btn btn-dark btn-load">Load More</button>
</div>

<script>
let offset = 0;
const limit = 50; // load 10 per click

function loadProducts() {
    $.ajax({
        url: "",
        type: "POST",
        data: {offset: offset, limit: limit},
        success: function(data) {
            if (data.trim() !== "") {
                $("#product-container").append(data);
                offset += limit;
            } else {
                $("#loadMore").hide();
            }
        }
    });
}

$(document).ready(function(){
    loadProducts(); // initial load
    $("#loadMore").click(function(){
        loadProducts();
    });
});
</script>

</body>
</html>