<?php
session_start();
require 'db.php';

// ✅ Restrict guest users
if(!isset($_SESSION['uid'])){
    echo "<script>alert('Please login first!');window.location='LoginUser.php';</script>";
    exit;
}

$uid = $_SESSION['uid'];

// ✅ Add to wishlist
if(isset($_GET['pid'])){
    $pid = intval($_GET['pid']);
    mysqli_query($mysql, 
        "INSERT INTO wishlist(uid,pid,time_date) 
         VALUES($uid,$pid,NOW()) 
         ON DUPLICATE KEY UPDATE time_date=NOW()");
    header("Location: Wishlist.php");
    exit;
}

// ✅ Remove from wishlist
if(isset($_GET['remove'])){
    $rid = intval($_GET['remove']);
    mysqli_query($mysql, "DELETE FROM wishlist WHERE uid=$uid AND pid=$rid");
    header("Location: Wishlist.php");
    exit;
}

// ✅ Move wishlist → cart (FIXED with price & total_price)
if(isset($_GET['moveToCart'])){
    $pid = intval($_GET['moveToCart']);

    // Fetch product price
    $priceRow = mysqli_fetch_assoc(
        mysqli_query($mysql, "SELECT price FROM product WHERE pid=$pid")
    );
    $price = $priceRow['price'];

    // Insert into cart with full data
    mysqli_query($mysql, "
        INSERT INTO addtocart(uid, pid, qty, price, total_price, time_date)
        VALUES ($uid, $pid, 1, $price, $price, NOW())
        ON DUPLICATE KEY UPDATE 
            qty = qty + 1
    ");

    // Fix total_price based on updated qty
    mysqli_query($mysql, "
        UPDATE addtocart 
        SET total_price = price * qty
        WHERE uid=$uid AND pid=$pid
    ");

    // Remove from wishlist
    mysqli_query($mysql, "DELETE FROM wishlist WHERE uid=$uid AND pid=$pid");

    header("Location: Cart.php");
    exit;
}

// ✅ Fetch wishlist items
$products = [];
$q = mysqli_query($mysql, 
    "SELECT p.* 
     FROM wishlist w 
     JOIN product p ON w.pid=p.pid 
     WHERE w.uid=$uid");

while($row = mysqli_fetch_assoc($q)){
    $products[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Wishlist - GLAMORA</title>
  <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
  <h2>My Wishlist</h2>
  
  <?php if(empty($products)): ?>
      <p class="text-muted">Your wishlist is empty.</p>
  <?php else: ?>
      <div class="row">
        <?php foreach($products as $p): ?>
          <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="admin/uploads/<?php echo htmlspecialchars($p['image']); ?>" 
                   class="card-img-top" 
                   style="height:220px; object-fit:cover;">
              <div class="card-body text-center">
                <h6><?php echo htmlspecialchars($p['pname']); ?></h6>
                <p class="text-success fw-bold">₹ <?php echo number_format($p['price'],2); ?></p>
                
                <a href="Wishlist.php?moveToCart=<?php echo $p['pid']; ?>" 
                   class="btn btn-success btn-sm mb-2">
                   Add to Cart
                </a>

                <a href="Wishlist.php?remove=<?php echo $p['pid']; ?>" 
                   class="btn btn-danger btn-sm mb-2"
                   onclick="return confirm('Remove from wishlist?');">
                   Remove
                </a>
                
                <br>
                <a href="ProductDetail.php?pid=<?php echo $p['pid']; ?>" 
                   class="btn btn-link btn-sm">
                   View Product
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
  <?php endif; ?>
</div>

<?php require 'Footer.php'; ?>
</body>
</html>