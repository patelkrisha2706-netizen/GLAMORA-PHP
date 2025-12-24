<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - GLAMORA</title>
  <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
  <h2 class="mb-4 text-center fw-bold">About Us</h2>
  <p class="lead text-center">
    <strong>GLAMORA</strong> – Crafting timeless elegance for the modern world.
  </p>

  <p>
    GLAMORA was founded with a simple vision: to make luxury jewelry accessible without compromising
    on quality or craftsmanship. Each piece is thoughtfully designed and carefully crafted,
    combining traditional artistry with contemporary designs. Our brand represents elegance,
    trust, and sophistication that resonates with every customer.
  </p>

  <div class="row mt-5">
    <div class="col-md-6 d-flex align-items-center">
      <div>
        <h4 class="fw-bold">✨ Our Mission</h4>
        <p>
          To empower individuals with jewelry that tells their story. Whether it’s a minimal daily
          wear piece, an engagement ring, or a statement necklace, our mission is to celebrate your
          moments with sparkle and style.
        </p>

        <h4 class="fw-bold mt-4">🌿 Our Values</h4>
        <ul>
          <li><strong>Authenticity:</strong> Only genuine, ethically sourced materials.</li>
          <li><strong>Craftsmanship:</strong> Designed with precision and care.</li>
          <li><strong>Affordability:</strong> Luxury should be for everyone.</li>
          <li><strong>Sustainability:</strong> Responsible practices that respect nature.</li>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <img src="aboutus1.jpg" class="img-fluid rounded shadow" alt="Jewelry Crafting">
    </div>
  </div>

  <div class="mt-5 text-center">
    <h4 class="fw-bold">💎 Why Choose GLAMORA?</h4>
    <p>
      With hundreds of happy customers across India, GLAMORA is trusted for delivering the finest
      jewelry at unbeatable prices. We are committed to bringing sparkle to your everyday life,
      ensuring every piece you buy is a treasure worth keeping forever.
    </p>
  </div>
</div>

<?php require 'Footer.php'; ?>
</body>
</html> 