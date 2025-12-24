<?php
session_start();
require '../db.php';

if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit();
  }
require '../db.php';

if (isset($_GET['delete'])) {
    $rid = intval($_GET['delete']);
    mysqli_query($mysql, "DELETE FROM review WHERE rid=$rid LIMIT 1");
    header("Location: ManageReview.php");
    exit;
}

$result = mysqli_query($mysql, "SELECT r.*, u.uname, p.pname FROM review r JOIN user u ON r.uid=u.uid JOIN product p ON r.pid=p.pid ORDER BY r.time_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Reviews</title>
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
        color: #fff;
        margin-left: 220px;
    }
    .badge-danger {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        background-color: #a94442;
        color: #fff;
        text-decoration: none;
    }
    .container {
        margin-left: 15%;
        width: 80%;
    }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>GLAMORA Admin</h4>
    <hr style="border-color: #e0d7cf;">
    <p><strong><?= isset($_SESSION['email']) ? $_SESSION['email'] : 'Admin'; ?></strong></p>
    <a href="Dashboard.php">Dashboard</a>
    <a href="CreateCategory.php">Add Category</a>
    <a href="ReadCategory.php">Read Category</a>
    <a href="CreateProduct.php">Add Product</a>
    <a href="ReadProduct.php">Read Product</a>
    <a href="ManageUser.php">Manage Users</a>
    <a href="ManageOrder.php">Manage Orders</a>
    <a href="logout.php">Logout</a>
</div>

<div class="topbar">
    <h5>Dashboard <small class="text-white-50">Welcome to Admin Dashboard</small></h5>
</div>

<div class="container">
    <h2 class="text-center">Review Management</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Product Name</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['uname']); ?></td>
                <td><?= htmlspecialchars($row['pname']); ?></td>
                <td><?= intval($row['rating']); ?>★</td>
                <td><?= htmlspecialchars($row['comment']); ?></td>
                <td><?= $row['time_date']; ?></td>
                <td>
                    <a href="ManageReview.php?delete=<?= $row['rid']; ?>" class="badge-danger" onclick="return confirm('Are you sure to delete this review?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>