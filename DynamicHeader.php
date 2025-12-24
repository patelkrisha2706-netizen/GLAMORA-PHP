<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$wishlistCount = 0;
$cartCount = 0;

if (isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];

    // Wishlist count
    $res = mysqli_query($mysql, "SELECT COUNT(*) as cnt FROM wishlist WHERE uid=$uid");
    $row = mysqli_fetch_assoc($res);
    $wishlistCount = $row['cnt'];

    // Cart count
    $res2 = mysqli_query($mysql, "SELECT SUM(qty) as cnt FROM addtocart WHERE uid=$uid");
    $row2 = mysqli_fetch_assoc($res2);
    $cartCount = $row2['cnt'] ? $row2['cnt'] : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GLAMORA</title>
  <link href="bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">
  <div class="container-fluid">
    <img src="GLAMORA-removebg-preview.png" alt="" style="height:100px; width:120px;">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link category-link" href="HomePage.php">Home</a></li>
        <li class="nav-item"><a class="nav-link category-link" href="Neckles.php">Necklace</a></li>
        <li class="nav-item"><a class="nav-link category-link" href="Ring.php">Ring</a></li>
        <li class="nav-item"><a class="nav-link category-link" href="Earing.php">Earring</a></li>
        <li class="nav-item"><a class="nav-link category-link" href="Braclete.php">Bracelet</a></li>
        <li class="nav-item"><a class="nav-link category-link" href="Mens.php">Mens</a></li>
        <li class="nav-item"><a class="nav-link category-link" href="AboutUs.php">About Us</a></li> 
        <li class="nav-item"><a class="nav-link category-link" href="ContactUs.php">Contact Us</a></li>
      </ul>

      <!-- Search -->
      <form class="d-flex ms-auto me-3 position-relative" role="search" method="POST" action="HomePage.php">
        <input class="form-control form-control-sm" type="search" placeholder="Search for Jewellery" name="query" id="searchBox" style="width:200px; border-radius:20px;">
        <button class="btn btn-sm btn-outline-dark ms-2" type="submit"><i class="bi bi-search fs-5"></i></button>
        <div id="searchResult" class="position-absolute bg-white shadow rounded mt-5 w-100" style="display:none; z-index:1000;"></div>
      </form>

      <!-- User icons -->
      <a href="UserProfile.php" class="me-3"><i class="bi bi-person fs-5 text-dark"></i></a>

      <?php if (isset($_SESSION['uid'])): ?>
        <a href="Wishlist.php" class="me-3 position-relative">
          <i class="bi bi-heart fs-5 text-dark"></i>
          <?php if ($wishlistCount > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"><?= $wishlistCount ?></span>
          <?php endif; ?>
        </a>
        <a href="Cart.php" class="me-3 position-relative">
          <i class="bi bi-bag fs-5 text-dark"></i>
          <?php if ($cartCount > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"><?= $cartCount ?></span>
          <?php endif; ?>
        </a>
        <a href="MyOrder.php" class="btn  position-relative ">
            <i class="bi bi-truck"></i>
        </a>
        <a class="nav-link text-dark" href="LogOutUser.php">Logout</a>
      <?php else: ?>
        <a class="nav-link text-dark" href="LoginUser.php">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<style>
  .nav-link.category-link { 
    font-weight:600; 
    color:black!important; 
    padding:8px 15px; 
    border-bottom:2px solid transparent; 
    transition:0.3s;
  }
  .nav-link.category-link:hover, 
  .nav-link.category-link.active { 
    border-bottom:2px solid black; 
    color:black!important;
  }
  #searchResult ul { 
    list-style:none; 
    margin:0; 
    padding:0; 
  }
  #searchResult li { 
    padding:8px 12px; 
    cursor:pointer; 
  }
  #searchResult li:hover { 
    background-color:#f2f2f2; 
  }
</style>

<script>
$(document).ready(function(){
    $("#searchBox").keyup(function(){
        var query = $(this).val();
        if(query != ""){
            $.ajax({
                url: "Search.php",
                method: "POST",
                data: {query:query},
                success: function(data){ $("#searchResult").html(data).show(); }
            });
        } else { $("#searchResult").hide(); }
    });
    $(document).on("click", "#searchResult li", function(){
        $("#searchBox").val($(this).text());
        $("#searchResult").hide();
    });
});
</script>
</body>
</html>