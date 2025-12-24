<!DOCTYPE html>
<html>
<head>
    <title>Category Grid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3ece6;
            color: #5a4c42;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .category-card {
            width: 120%;
            border: none;
            background: #fffaf5;
            box-shadow: 0 4px 12px rgba(124, 94, 70, 0.1);
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none; /* remove underline */
            color: inherit; /* keep text color */
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(124, 94, 70, 0.2);
        }
        .category-card img {
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .category-card .card-body {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h2 class="text-center mb-4">Shop by Categories</h2>
    <div class="row g-4">
        
        <!-- Necklaces -->
        <div class="col-md-2 col-sm-6" style="margin-left:3%">
            <a href="Neckles.php" class="card category-card">
                <img src="necklaces.jpg" class="card-img-top" alt="Necklaces">
                <div class="card-body">
                    <h5 class="card-title">Necklaces</h5>
                </div>
            </a>
        </div>

        <!-- Rings -->
        <div class="col-md-2 col-sm-6" style="margin-left:2%">
            <a href="Ring.php" class="card category-card">
                <img src="ring.jpg" class="card-img-top" alt="Rings">
                <div class="card-body">
                    <h5 class="card-title">Rings</h5>
                </div>
            </a>
        </div>

        <!-- Earrings -->
        <div class="col-md-2 col-sm-6" style="margin-left:2%">
            <a href="Earing.php" class="card category-card">
                <img src="earring.jpg" class="card-img-top" alt="Earrings">
                <div class="card-body">
                    <h5 class="card-title">Earrings</h5>
                </div>
            </a>
        </div>

        <!-- Bracelets -->
        <div class="col-md-2 col-sm-6" style="margin-left:2%">
            <a href="Braclete.php" class="card category-card">
                <img src="bracelets.jpg" class="card-img-top" alt="Bracelets">
                <div class="card-body">
                    <h5 class="card-title">Bracelets</h5>
                </div>
            </a>
        </div>

        <!-- Mens -->
        <div class="col-md-2 col-sm-6" style="margin-left:2%">
            <a href="Mens.php" class="card category-card">
                <img src="mens.jpg" class="card-img-top" alt="Mens">
                <div class="card-body">
                    <h5 class="card-title">Mens</h5>
                </div>
            </a>
        </div>

    </div>
</div>
</body>
</html>