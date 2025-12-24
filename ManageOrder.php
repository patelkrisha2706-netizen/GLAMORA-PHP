<?php
session_start();
require '../db.php';

if (!isset($_SESSION['email'])) {
    header("location:index.php");
    exit();
  }
require '../db.php';

if (isset($_POST['update_status'])) {
    $oid = intval($_POST['oid']);
    $status = $_POST['ostatus'];
    mysqli_query($mysql, "UPDATE order_t SET ostatus='$status' WHERE oid=$oid");
    header("Location: ManageOrder.php");
    exit;
}

if (isset($_GET['delete'])) {
    $oid = intval($_GET['delete']);
    mysqli_query($mysql, "DELETE FROM order_t WHERE oid=$oid");
    header("Location: ManageOrder.php");
    exit;
}

$orders_q = "SELECT o.*, p.pname, u.uname FROM order_t o JOIN product p ON o.pid=p.pid JOIN user u ON o.uid=u.uid ORDER BY o.time_date DESC";
$orders_res = mysqli_query($mysql, $orders_q);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
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
    .form-select {
        width:50%;
        display: inline-block;
    }
    .btn-primary {
        background-color: #7c5e46;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        color: white;
        
        margin-top: 5px;
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
    <a href="ManageReview.php">Manage Reviews</a>
    <a href="logout.php">Logout</a>
</div>

<div class="topbar">
    <h5>Dashboard <small class="text-white-50">Welcome to Admin Dashboard</small></h5>
</div>

<div class="container">
    <h2 class="text-center">Order Management</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>User</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($o = mysqli_fetch_assoc($orders_res)) { ?>
            <tr>
                <td><?= $o['oid']; ?></td>
                <td><?= htmlspecialchars($o['pname']); ?></td>
                <td><?= htmlspecialchars($o['uname']); ?></td>
                <td><?= intval($o['qty']); ?></td>
                <td>₹ <?= number_format($o['price'], 2); ?></td>
                <td><?= htmlspecialchars($o['address']); ?></td>
                <td><?= htmlspecialchars($o['phone']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="oid" value="<?= $o['oid']; ?>">

                        <select name="ostatus" class="form-select form-select-sm"
                            <?php if ($o['ostatus'] == 'delivered') echo 'disabled'; ?>>
                            
                            <option value="pending" <?= ($o['ostatus'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="delivered" <?= ($o['ostatus'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                        </select>

                        <button type="submit" name="update_status" class="btn-primary btn-sm"
                            <?php if ($o['ostatus'] == 'delivered') echo 'disabled'; ?>>
                            Update
                        </button>
                    </form>
                </td>
                <td><?= $o['time_date']; ?></td>
                <td>
                    <a href="ManageOrder.php?delete=<?= $o['oid']; ?>" class="badge-danger" onclick="return confirm('Are you sure to delete this order?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>