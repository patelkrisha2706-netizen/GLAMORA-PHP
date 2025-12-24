<?php
session_start();
require 'db.php';

if(!isset($_SESSION['uid'])){
    echo "<script>alert('Please login first!');window.location='LoginUser.php';</script>";
    exit;
}

$uid = $_SESSION['uid'];

// ✅ Fetch orders by status (always lowercase for consistency)
$pending = mysqli_query($mysql,"SELECT o.*, p.pname 
                                FROM order_t o 
                                JOIN product p ON o.pid=p.pid 
                                WHERE o.uid=$uid AND LOWER(o.ostatus)='pending'");
$delivered = mysqli_query($mysql,"SELECT o.*, p.pname 
                                  FROM order_t o 
                                  JOIN product p ON o.pid=p.pid 
                                  WHERE o.uid=$uid AND LOWER(o.ostatus)='delivered'");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Order Status - GLAMORA</title>
  <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
  <h2>Order Status</h2>

  <!-- Pending Orders -->
  <h4>⏳ Pending Orders</h4>
  <?php if(mysqli_num_rows($pending)==0): ?>
    <p>No pending orders.</p>
  <?php else: ?>
    <ul class="list-group mb-4">
      <?php while($p=mysqli_fetch_assoc($pending)): ?>
        <li class="list-group-item">
          <?= htmlspecialchars($p['pname']); ?> - Qty: <?= $p['qty']; ?> 
          <small class="text-muted">(Ordered on <?= $p['time_date']; ?>)</small>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php endif; ?>

  <!-- Delivered Orders -->
  <h4>✅ Delivered Orders</h4>
  <?php if(mysqli_num_rows($delivered)==0): ?>
    <p>No delivered orders yet.</p>
  <?php else: ?>
    <ul class="list-group">
      <?php while($d=mysqli_fetch_assoc($delivered)): ?>
        <li class="list-group-item">
          <?= htmlspecialchars($d['pname']); ?> - Qty: <?= $d['qty']; ?> 
          <small class="text-muted">(Delivered on <?= $d['time_date']; ?>)</small>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php endif; ?>
</div>

<?php require 'Footer.php'; ?>
</body>
</html>