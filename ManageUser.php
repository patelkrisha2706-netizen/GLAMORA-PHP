<?php
session_start();
require '../db.php';

//  Handle Status Toggle
if (isset($_GET['toggle'])) {
    $uid = intval($_GET['toggle']);
    $q = "SELECT status FROM user WHERE uid=$uid";
    $res = mysqli_query($mysql, $q);
    if ($row = mysqli_fetch_assoc($res)) {
        $newStatus = ($row['status'] == 'Active') ? 'Blocked' : 'Active';
        mysqli_query($mysql, "UPDATE user SET status='$newStatus' WHERE uid=$uid");
    }
    header("Location: ManageUser.php");
    exit;
}

//  Handle Delete
if (isset($_GET['delete'])) {
    $uid = intval($_GET['delete']);
    mysqli_query($mysql, "DELETE FROM user WHERE uid=$uid");
    header("Location: ManageUser.php");
    exit;
}

// Fetch all users
$q = "SELECT * FROM user ORDER BY created_at DESC";
$result = mysqli_query($mysql, $q);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link href="../bootstrap.min.css" rel="stylesheet">
    <style>
    body {
      background-color: #f3ece6;
      color: #5a4c42;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      height: 100vh; background-color: #7c5e46;
      color: white; padding: 20px; position: fixed; width: 220px;
    }
    .sidebar h4 { color: #ffffff; margin-bottom: 20px; font-size: 22px; }
    .sidebar a {
      color: #f3ece6; display: block; margin: 10px 0;
      text-decoration: none; font-size: 15px;
    }
    .sidebar a:hover { color: #c49a6c; }
    .topbar {
      background-color: #c49a6c; padding: 15px 30px; color: #fff; margin-left: 220px;
    }
    .table thead { background-color: #7c5e46; color: #fff; }
    .table td { vertical-align: middle; }
    .badge-active, .badge-blocked, .badge-delete {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }
    .badge-active { background-color: #28a745; color: #fff; }
    .badge-blocked { background-color: #a94442; color: #fff; }
    .badge-delete { background-color: #dc3545; color: #fff; }
    .container { margin-left: 15%; width: 80%; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4>GLAMORA Admin</h4>
        <hr style="border-color: #e0d7cf;">
        <p><strong><?= isset($_SESSION['uemail']) ? $_SESSION['uemail'] : 'Admin'; ?></strong></p>
        <div>
          <a href="Dashboard.php">Admin Dashboard</a>
          <a href="CreateCategory.php">Add Category</a>
          <a href="ReadCategory.php">Read Category</a>
          <a href="CreateProduct.php">Add Product</a>
          <a href="ReadProduct.php">Read Product</a>
          <a href="ManageOrder.php">Manage Orders</a>
          <a href="ManageReview.php">Manage Reviews</a>
          <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="topbar">
        <h5>Dashboard <small class="text-white-50">Welcome to Admin Dashboard</small></h5>
    </div>

    <div class="container">
        <h2 class="text-center">User Management</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>UID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['uid'] ?></td>
                    <td><?= htmlspecialchars($row['uname']) ?></td>
                    <td><?= htmlspecialchars($row['uemail']) ?></td>
                    <td><?= htmlspecialchars($row['gender']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td>
                        <a href="ManageUser.php?toggle=<?= $row['uid'] ?>" 
                           class="<?= ($row['status'] == 'Active') ? 'badge-active' : 'badge-blocked' ?>">
                           <?= $row['status'] ?: 'Blocked' ?>
                        </a>
                    </td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="ManageUser.php?delete=<?= $row['uid'] ?>" 
                           onclick="return confirm('Are you sure you want to delete this user?');"
                           class="badge-delete">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>