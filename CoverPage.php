<!DOCTYPE html>
<html>
<head>
    <title>Cover Page</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .carousel-item img {
            height: 80vh;
            object-fit: cover;
            width: 80%;
        }
        .carousel-caption {
            bottom: 20%;
        }
        .carousel-caption h1 {
            font-size: 60px;
            font-weight: bold;
        }
        .carousel-caption p {
            font-size: 20px;
        }
        .carousel-caption .btn {
            background: #7c5e46;
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 30px;
        }
        .carousel-caption .btn:hover {
            background: #c49a6c;
        }
    </style>
</head>
<body>
    <div id="coverCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="coverpage1.jpg" class="d-block w-100">
                <div class="carousel-caption text-start">
                    
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="coverpage2.jpg" class="d-block w-100">
                <div class="carousel-caption">
                   
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="coverpage3.jpg" class="d-block w-100">
                <div class="carousel-caption">
                    
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="carousel-item">
                <img src="coverpage4.jpg" class="d-block w-100">
                <div class="carousel-caption">
                   
                </div>
            </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#coverCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#coverCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

