<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if(!isset($_GET['pid'])) die("Invalid Request");

$pid = intval($_GET['pid']);
$res = mysqli_query($mysql, "SELECT * FROM product WHERE pid=$pid");
if(mysqli_num_rows($res)==0) die("Product not found");
$product = mysqli_fetch_assoc($res);

// Fetch related products (same category + similar price range)
$minPrice = $product['price'] - 1000; 
$maxPrice = $product['price'] + 1000;

$related_res = mysqli_query($mysql, "
    SELECT * FROM product 
    WHERE cid = {$product['cid']} 
    AND pid != $pid 
    AND price BETWEEN $minPrice AND $maxPrice
    ORDER BY RAND()
    LIMIT 4
");

if(mysqli_num_rows($related_res) == 0){
    $related_res = mysqli_query($mysql, "
        SELECT * FROM product 
        WHERE cid = {$product['cid']} 
        AND pid != $pid 
        ORDER BY RAND()
        LIMIT 4
    ");
}

// Insert review
if(isset($_POST['submit_review']) && isset($_SESSION['uid'])){
    $uid = $_SESSION['uid'];
    $rating = intval($_POST['rating']);
    $comment = mysqli_real_escape_string($mysql, $_POST['comment']);
    mysqli_query($mysql, "INSERT INTO review (uid,pid,rating,comment,time_date) 
                          VALUES ('$uid','$pid','$rating','$comment',NOW())");
    echo "<script>alert('Review submitted successfully!');window.location='ProductDetail.php?pid=$pid';</script>";
}

// Fetch reviews (join with user table)
$reviews = mysqli_query($mysql, "
    SELECT r.*, u.uname AS username 
    FROM review r 
    JOIN user u ON r.uid = u.uid 
    WHERE r.pid = $pid 
    ORDER BY r.time_date DESC
");

// Average rating
$avg_res = mysqli_query($mysql, "SELECT AVG(rating) as avg_rating, COUNT(*) as total FROM review WHERE pid=$pid");
$avg_row = mysqli_fetch_assoc($avg_res);
$avg_rating = round($avg_row['avg_rating'],1);
$total_reviews = $avg_row['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $product['pname']; ?> - GLAMORA</title>
<link href="bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
.star {
  color: gold;
  font-size: 16px;
}
.product-card:hover { 
            transform: scale(1.03); 
            box-shadow:0 4px 12px rgba(0,0,0,0.1); 
        }
</style>
</head>
<body>
<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
  <div class="row">
    <!-- Product Image -->
    <div class="col-md-6 d-flex justify-content-center">
      <img src="admin/uploads/<?php echo $product['image']; ?>" 
           class="img-fluid rounded shadow" 
           style="max-height:400px; object-fit:cover;">
    </div>

    <!-- Product Info -->
    <div class="col-md-6">
      <h2><?php echo $product['pname']; ?></h2>
      <h4 class="text-success mb-3">₹ <?php echo $product['price']; ?></h4>
      <p><?php echo $product['pdescription']; ?></p>

      <!-- Average Rating -->
      <p>
        <b>Rating:</b> 
        <?php 
          if($total_reviews>0){
            for($i=1;$i<=5;$i++){
              echo ($i <= round($avg_rating)) ? 
                   "<span class='star'>&#9733;</span>" : 
                   "<span class='star' style='color:#ccc'>&#9733;</span>";
            }
            echo " ($avg_rating/5 from $total_reviews reviews)";
          } else {
            echo "No reviews yet.";
          }
        ?>
      </p>

      <!-- Wishlist & Cart -->
      <div class="mt-4">
        <?php if(isset($_SESSION['uid'])): ?>
          <a href="Wishlist.php?pid=<?php echo $product['pid']; ?>" 
             class="btn btn-outline-dark btn-sm me-2">
            <i class="bi bi-heart"></i> Wishlist
          </a>
          <form method="post" action="Cart.php" style="display:inline-block;">
            <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">
            <button type="submit" class="btn btn-dark btn-sm">
              <i class="bi bi-bag"></i> Add to Bag
            </button>
          </form>
        <?php else: ?>
          <button class="btn btn-outline-dark btn-sm me-2" 
                  onclick="window.location='LoginUser.php'">
            <i class="bi bi-heart"></i> Wishlist
          </button>
          <button class="btn btn-dark btn-sm" 
                  onclick="window.location='LoginUser.php'">
            <i class="bi bi-bag"></i> Add to Bag
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Review Section -->
  <div class="row mt-5">
    <div class="col-md-12">
      <h3>Customer Reviews</h3>

      <!-- Review Form -->
      <?php if(isset($_SESSION['uid'])): ?>
        <form method="post" class="mb-4">
          <label><b>Your Rating:</b></label><br>
          <select name="rating" class="form-select w-25 mb-2" required>
            <option value="5">★★★★★</option>
            <option value="4">★★★★☆</option>
            <option value="3">★★★☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="1">★☆☆☆☆</option>
          </select>
          <textarea name="comment" class="form-control mb-2" 
                    placeholder="Write your review..." required></textarea>
          <button type="submit" name="submit_review" class="btn btn-dark btn-sm">
            Submit Review
          </button>
        </form>
      <?php else: ?>
        <p><a href="LoginUser.php">Login</a> to add a review.</p>
      <?php endif; ?>

      <!-- Display Reviews -->
      <?php if(mysqli_num_rows($reviews)>0): ?>
        <?php while($row=mysqli_fetch_assoc($reviews)): ?>
          <div class="border p-3 mb-3 rounded shadow-sm">
            <b><?php echo htmlspecialchars($row['username']); ?></b> 
            <span class="ms-2">
              <?php for($i=1;$i<=5;$i++): ?>
                <?php echo ($i <= $row['rating']) ? 
                           "<span class='star'>&#9733;</span>" : 
                           "<span class='star' style='color:#ccc'>&#9733;</span>"; ?>
              <?php endfor; ?>
            </span><br>
            <p><?php echo htmlspecialchars($row['comment']); ?></p>
            <small class="text-muted"><?php echo $row['time_date']; ?></small>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No reviews yet.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Related Products -->
  <div class="row mt-5">
    <h3>You may also like</h3>
    <?php while($rel=mysqli_fetch_assoc($related_res)): ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm text-center">
          <a href="ProductDetail.php?pid=<?php echo $rel['pid']; ?>" 
             style="text-decoration:none;color:inherit;">
            <img src="admin/uploads/<?php echo $rel['image']; ?>" 
                 class="card-img-top" 
                 style="height:220px;object-fit:cover;">
          </a>
          <div class="card-body">
            <h6><?php echo $rel['pname']; ?></h6>
            <p class="text-success fw-bold">₹ <?php echo $rel['price']; ?></p>

            <!-- Ratings -->
            <div>
              <?php
                $pid_rel = $rel['pid'];
                $avgR = mysqli_query($mysql, "SELECT AVG(rating) as avg FROM review WHERE pid=$pid_rel");
                $avgRrow = mysqli_fetch_assoc($avgR);
                $avg = round($avgRrow['avg'],1);
                if($avg>0){
                  for($i=1;$i<=5;$i++){
                    echo ($i <= round($avg)) ? 
                         "<span class='star'>&#9733;</span>" : 
                         "<span class='star' style='color:#ccc'>&#9733;</span>";
                  }
                  echo " ($avg)";
                } else {
                  echo "<small>No reviews</small>";
                }
              ?>
            </div>

            <!-- Wishlist & Cart -->
            <div class="mt-2">
              <?php if(isset($_SESSION['uid'])): ?>
                <a href="Wishlist.php?pid=<?php echo $rel['pid']; ?>" 
                   class="btn btn-outline-dark btn-sm me-2">
                   <i class="bi bi-heart"></i>
                </a>
                <form method="post" action="Cart.php" style="display:inline-block;">
                  <input type="hidden" name="pid" value="<?php echo $rel['pid']; ?>">
                  <button type="submit" class="btn btn-dark btn-sm">
                    <i class="bi bi-bag"></i>
                  </button>
                </form>
              <?php else: ?>
                <button class="btn btn-outline-dark btn-sm me-2" 
                        onclick="window.location='LoginUser.php'">
                        <i class="bi bi-heart"></i>
                </button>
                <button class="btn btn-dark btn-sm" 
                        onclick="window.location='LoginUser.php'">
                        <i class="bi bi-bag"></i>
                </button>
              <?php endif; ?>
            </div>

          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php require 'Footer.php'; ?>
</body>
</html>