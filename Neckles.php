<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offset = intval($_POST['offset']);
    $limit = intval($_POST['limit']);
    $q = "SELECT p.* 
          FROM product p 
          JOIN category c ON p.cid = c.cid 
          WHERE c.cname = 'Necklace' 
          LIMIT $limit OFFSET $offset";

    $result = mysqli_query($mysql, $q);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <div class='col-md-3 mb-4'>
                <div class='product-card border rounded shadow-sm p-2 h-100'>
                    <a href='ProductDetail.php?pid={$row['pid']}' style='text-decoration:none; color:inherit;'>
                        <img src='admin/uploads/{$row['image']}' alt='{$row['pname']}' class='img-fluid mb-2' style='height:200px; object-fit:cover;'>
                        <h6 class='fw-bold'>{$row['pname']}</h6>
                        <p class='text-truncate'>{$row['pdescription']}</p>
                        <strong class='text-success'>₹ {$row['price']}</strong>
                    </a>
                </div>
            </div>";
        }
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Necklaces Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { 
            background:#fff; 
            color:#000; 
        }
        .product-card { 
            text-align:center; 
            transition:0.3s; 
        }
        .product-card:hover { 
            transform: scale(1.03); 
            box-shadow:0 4px 12px rgba(0,0,0,0.1); 
        }
    </style>
</head>
<body>
    <?php require 'DynamicHeader.php'; ?>
    
    <div id="coverCarousel" class="carousel slide" data-bs-ride="carousel" >
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="necklescoverpage.png" class="d-block w-100">
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Necklaces Collection</h2>
        <div class="row" id="product-container"></div>
        <button id="loadMore" class="btn btn-dark btn-load">Load More</button>
    </div>

    <script>
    let offset = 0;
    const limit = 20;
    const maxProducts = 100;

    function loadProducts() {
        $.ajax({
            url: "Neckles.php",
            type: "POST",
            data: {offset: offset, limit: limit},
            success: function(data) {
                if (data.trim() !== "") {
                    $("#product-container").append(data);
                    offset += limit;
                    if (offset >= maxProducts) {
                        $("#loadMore").hide();
                    }
                } else {
                    $("#loadMore").hide();
                }
            }
        });
    }

    $(document).ready(function() {
        loadProducts();
        $("#loadMore").click(function() {
            loadProducts();
        });
    });
    </script>

    <?php require 'Footer.php'; ?>
</body>
</html>