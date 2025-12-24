<?php
session_start();
require 'db.php';

if(!isset($_SESSION['uid'])){
    echo "<script>alert('Please login first!');window.location='LoginUser.php';</script>";
    exit;
}

$uid = $_SESSION['uid'];

// ✅ Fetch user details
$user = mysqli_fetch_assoc(mysqli_query($mysql,"SELECT * FROM user WHERE uid=$uid"));

// ✅ Fetch cart items
$cart_q = mysqli_query($mysql,"SELECT p.*,a.qty 
                               FROM addtocart a 
                               JOIN product p ON a.pid=p.pid 
                               WHERE a.uid=$uid");

$cart_items = [];
$total = 0;
while($row=mysqli_fetch_assoc($cart_q)){
    $cart_items[]=$row;
    $total += $row['price'] * $row['qty'];
}

// ✅ Place order
if(isset($_POST['place_order'])){
    $address = mysqli_real_escape_string($mysql,$_POST['address']);
    $phone   = mysqli_real_escape_string($mysql,$_POST['phone']);

    foreach($cart_items as $item){
        $pid = $item['pid'];
        $qty = $item['qty'];
        $price = $item['price'] * $qty;
        $cid = $item['cid']; // category id

        mysqli_query($mysql,"INSERT INTO order_t(uid,pid,cid,qty,price,address,phone,ostatus,time_date)
                             VALUES($uid,$pid,$cid,$qty,$price,'$address','$phone','Pending',NOW())");
    }

    // ✅ Clear cart
    mysqli_query($mysql,"DELETE FROM addtocart WHERE uid=$uid");

    echo "<script>alert('Order placed successfully!');window.location='MyOrder.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Checkout - GLAMORA</title>
  <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
  <h2>Checkout</h2>
  <?php if(empty($cart_items)): ?>
      <p>Your cart is empty. <a href="HomePage.php">Shop now</a></p>
  <?php else: ?>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" required><?= $user['address']; ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control" value="<?= $user['phone']; ?>" required>
    </div>

    <h4>Order Summary</h4>
    <table class="table">
      <tr><th>Product</th><th>Qty</th><th>Price</th></tr>
      <?php foreach($cart_items as $c): ?>
        <tr>
          <td><?= $c['pname']; ?></td>
          <td><?= $c['qty']; ?></td>
          <td>₹ <?= $c['price'] * $c['qty']; ?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <td colspan="2"><strong>Total</strong></td>
        <td><strong>₹ <?= $total; ?></strong></td>
      </tr>
    </table>

    <button type="submit" name="place_order" class="btn btn-success">Confirm Order</button>
  </form>
  <?php endif; ?>
</div>

<?php require 'Footer.php'; ?>
</body>
</html>