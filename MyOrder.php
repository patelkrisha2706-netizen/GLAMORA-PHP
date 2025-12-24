<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first!'); window.location='LoginUser.php';</script>";
    exit;
}

$uid = intval($_SESSION['uid']);  // Sanitize session input

// Query to fetch orders
$query = "SELECT o.*, p.pname, p.image 
          FROM order_t o 
          JOIN product p ON o.pid = p.pid 
          WHERE o.uid = $uid 
          ORDER BY o.time_date DESC";

$q = mysqli_query($mysql, $query);

// Check if query executed successfully
if (!$q) {
    die("Database Query Failed: " . mysqli_error($mysql));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Orders - GLAMORA</title>
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
    <h2>My Orders</h2>

    <?php if (mysqli_num_rows($q) == 0): ?>
        <p>You have no orders. <a href="HomePage.php">Shop now</a></p>
    <?php else: ?>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($o = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><img src="admin/uploads/<?= htmlspecialchars($o['image']); ?>" width="60"></td>
                    <td><?= htmlspecialchars($o['pname']); ?></td>
                    <td><?= intval($o['qty']); ?></td>
                    <td>₹ <?= htmlspecialchars($o['price']); ?></td>
                    <td>
                        <?php if (strtolower($o['ostatus']) === "delivered"): ?>
                            <span class="badge bg-success">Delivered</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($o['time_date']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require 'Footer.php'; ?>
</body>
</html>
