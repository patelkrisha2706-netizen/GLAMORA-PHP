<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GLAMORA</title>
  <link rel="stylesheet" href="bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script>
    $(document).ready(function(){
      $("#search").keyup(function(){
        var query= $("#search").val();
        $.ajax({
          url:'Search.php',
          method:'POST',
          data:{ query:query },
          success:function(data){
            $("#result").html(data);
          }
        })
      })
    })
  </script>
  <style>
    body {
      background-color: #fff;
      color: #000;
    }
    .custom-header {
      background-color: #fff;
      font-family: 'Segoe UI', sans-serif;
      position: sticky;
      top: 0;
      z-index: 999;
    }
    .custom-header .nav-link {
      color: #000;
      padding: 0.5rem 1rem;
      transition: all 0.2s;
      font-weight: 500;
    }
    .custom-header .nav-link:hover {
      color: #fff;
      background-color: #000;
      border-radius: 6px;
    }
    .logo {
      color: #000;
    }
    .search-wrapper {
      width: 100px;   /* smaller width */
    }
    .search-wrapper .form-control {
      font-size: 0.9rem;
      padding: 6px 10px;
    }
    .search-wrapper .form-control:focus {
      box-shadow: none;
      border: 1px solid #000;
    }
  </style>
</head>
<body>
  <header class="custom-header shadow-sm">
    <div class="container-fluid py-2 px-4 d-flex align-items-center justify-content-between">
      <div class="logo fs-3">GLAMORA</div>
      <div class="search-wrapper flex-grow-1 mx-4">
        <div class="input-group rounded-pill shadow-sm">
          <input type="text" id="search" class="form-control border-0 bg-transparent px-4" placeholder="Search for jewelry..." />
          <span class="input-group-text bg-transparent border-0">
            <i class="bi bi-search text-dark"></i>
          </span>
        </div>
      </div>
      <div class="icons d-flex gap-3 align-items-center">
        <a href="/GLAMORA/User/UserProfile.php"><i class="bi bi-person fs-5 text-dark"></i></a>
        <a href="../Wishlist.php"><i class="bi bi-heart fs-5 position-relative">
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">3</span>
        </i></a>
        <a href="../AddToCart.php"><i class="bi bi-bag fs-5 position-relative">
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">1</span>
        </i></a>
      </div>
    </div>
    <nav class="text-center py-2 border-top">
      <ul class="nav justify-content-center flex-wrap">
        <li class="nav-item"><a class="nav-link" href="#">New Arrivals</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Best Seller</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Silver Luxe</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Lab Grown Diamond</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Demi fine Jewellery</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
      </ul>
    </nav>
  </header>
  <center><p id="result"></p></center>
</body>
</html>