<?php
session_start();
require 'db.php';

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login first!');window.location='LoginUser.php';</script>";
    exit;
}

$uid = $_SESSION['uid'];

// fetch user's current address & phone
$userRes = mysqli_query($mysql, "SELECT address, phone FROM user WHERE uid=$uid");
$userRow = mysqli_fetch_assoc($userRes);

$address = $userRow['address'];
$phone   = $userRow['phone'];

// ✅ Place order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $address = mysqli_real_escape_string($mysql, $_POST['address']);
    $phone   = mysqli_real_escape_string($mysql, $_POST['phone']);

    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $pid = $item['pid'];
            $qty = $item['qty'];
            $price = $item['price'] * $qty;

            // fetch category id
            $prodRes = mysqli_query($mysql, "SELECT cid FROM product WHERE pid=$pid");
            $prodRow = mysqli_fetch_assoc($prodRes);
            $cid = $prodRow ? $prodRow['cid'] : 0;

            // insert order
            mysqli_query($mysql, "INSERT INTO order_t(pid,cid,uid,time_date,price,address,phone,qty,ostatus) 
                VALUES($pid,$cid,$uid,NOW(),$price,'$address','$phone',$qty,'Pending')");
        }

        // optionally update user's address & phone in user table
        mysqli_query($mysql, "UPDATE user SET address='$address', phone='$phone' WHERE uid=$uid");

        // clear cart
        $_SESSION['cart'] = [];
        mysqli_query($mysql, "DELETE FROM addtocart WHERE uid=$uid");

        echo "<script>alert('Order placed successfully!');window.location='MyOrders.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Confirm Order - GLAMORA</title>
  <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
  <h2>Confirm Your Order</h2>

  <p>Please confirm or edit your contact details before placing the order:</p>

  <form method="post">
    <div class="mb-3 w-50">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" required><?php echo htmlspecialchars($address); ?></textarea>
    </div>
    <div class="mb-3 w-50">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" required>
    </div>

    <button type="submit" name="checkout" class="btn btn-success">Confirm & Place Order</button>
    <a href="Cart.php" class="btn btn-secondary">Back to Cart</a>
  </form>
</div>

<?php require 'Footer.php'; ?>
</body>
</html>