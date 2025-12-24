<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>GLAMORA - Top Styles</title>
    <style>
        body {
            background-color: white;
            color: black;
        }
        .card {
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        .btn-sm {
            font-size: 0.8rem;
            padding: 4px 8px;
        }
    </style>
</head>
<body>
<section class="py-5">
  <div class="container">
    <h3 class="text-center mb-4">GLAMORA TOP STYLES</h3>

    <div class="row g-4 text-center">
      <?php
      $q = "SELECT * FROM product ORDER BY pid DESC LIMIT 8"; // show latest 8 products
      $result = mysqli_query($mysql, $q);

      if (mysqli_num_rows($result) > 0) {
          while ($r = mysqli_fetch_assoc($result)) {
              echo "
              <div class='col-6 col-md-3'>
                <div class='card h-100 shadow-sm border-0'>
                  <a href='ProductDetail.php?pid={$r['pid']}'>
                    <img src='admin/uploads/{$r['image']}' class='card-img-top' alt='{$r['pname']}' style='height:250px; object-fit:cover;'>
                  </a>
                  <div class='card-body'>
                    <p class='mb-1 fw-semibold'>{$r['pname']}</p>
                    <p class='text-success fw-bold'>₹{$r['price']}</p>
                    
                    <div class='d-flex justify-content-center gap-2 mt-2'>";
                    
                    if (isset($_SESSION['uid'])) {
                        echo "
                        <form method='post' action='Cart.php' style='display:inline-block;'>
                          <input type='hidden' name='pid' value='{$r['pid']}'>
                          <button type='submit' class='btn btn-dark btn-sm'><i class='bi bi-bag'></i></button>
                        </form>
                        <a href='Wishlist.php?pid={$r['pid']}' class='btn btn-outline-dark btn-sm'><i class='bi bi-heart'></i></a>
                        ";
                    } else {
                        echo "
                        <button class='btn btn-dark btn-sm' onclick=\"alert('Please login first!'); window.location='LoginUser.php';\"><i class='bi bi-bag'></i></button>
                        <button class='btn btn-outline-dark btn-sm' onclick=\"alert('Please login first!'); window.location='LoginUser.php';\"><i class='bi bi-heart'></i></button>
                        ";
                    }

              echo "
                    </div>
                  </div>
                </div>
              </div>
              ";
          }
      } else {
          echo "<p>No products available</p>";
      }
      ?>
    </div>
  </div>
</section>
</body>
</html>