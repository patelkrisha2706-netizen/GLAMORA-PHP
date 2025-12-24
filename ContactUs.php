<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['co_name'];
    $email = $_POST['co_email'];
    $message = $_POST['co_message'];

    $q = "INSERT INTO contact_t(co_name, co_email, co_message, co_created_at) 
          VALUES('$name', '$email', '$message', NOW())";
    mysqli_query($mysql, $q);

    echo "<script>alert('Thank you for reaching out! Our team will respond shortly.');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - GLAMORA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
  <h2 class="mb-4 text-center fw-bold">Contact Us</h2>
  <p class="text-center lead">
    Have questions about our products, your order, or partnership opportunities?  
    We’d love to hear from you! Our team is always here to help.
  </p>

  <div class="row mt-4">
    <!-- Contact Form -->
    <div class="col-md-6">
      <form method="post" class="p-4 border rounded shadow-sm bg-light">
        <div class="mb-3">
          <label class="form-label fw-bold">Full Name</label>
          <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-bold">Message</label>
          <textarea name="message" class="form-control" rows="5" placeholder="Type your message here..." required></textarea>
        </div>
        <button type="submit" class="btn btn-dark w-100">Send Message</button>
      </form>
    </div>

    <!-- Company Info -->
    <div class="col-md-6">
      <div class="p-4">
        <h4 class="fw-bold">📍 Our Office</h4>
        <p>
          GLAMORA Jewelry Pvt. Ltd.<br>
          Ring Road, Surat, Gujarat, India – 395003
        </p>

        <h4 class="fw-bold">📞 Contact Info</h4>
        <p><strong>Email:</strong> support@glamora.com</p>
        <p><strong>Phone:</strong> +91 98765 43210</p>
        <p><strong>Working Hours:</strong> Mon – Sat, 10:00 AM – 7:00 PM</p>

        <h4 class="fw-bold">🌐 Follow Us</h4>
        <p>
          <a href="#">Instagram</a> | 
          <a href="#">Facebook</a> | 
          <a href="#">Twitter</a>
        </p>
      </div>
    </div>
  </div>
</div>

<?php require 'Footer.php'; ?>
</body>
</html>