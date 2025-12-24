<?php
require '../db.php';
$passwordMessage = '';

if (isset($_POST['submit'])) {
  $email = $_POST['email'];

  $q = "SELECT password FROM admin WHERE email='$email'";
  $result = mysqli_query($mysql, $q);
  $nor = mysqli_num_rows($result);

  if ($nor > 0) {
    $row = mysqli_fetch_array($result);
    $passwordMessage = "Your password is: <strong>" . $row['password'] . "</strong>";
  } else {
    $passwordMessage = "<span style='color:red;'>Email not found in our records.</span>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Forgot Password | Glamora</title>
  <link href="../bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f3ece6;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #5a4c42;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .forgot-box {
      background-color: #fffaf5;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(124, 94, 70, 0.2);
      width: 100%;
      max-width: 500px;
    }

    .forgot-box h2 {
      color: #c49a6c;
      margin-bottom: 20px;
      text-align: center;
    }

    .form-label {
      color: #7c5e46;
      font-weight: 500;
    }

    .form-control {
      background-color: #fffaf5;
      border: 1px solid #d5c8bc;
      color: #5a4c42;
    }

    .btn-primary {
      background-color: #c49a6c;
      border: none;
      width: 100%;
    }

    .btn-primary:hover {
      background-color: #a87f5c;
    }

    .text-center a {
      color: #7c5e46;
      text-decoration: none;
    }

    .text-center a:hover {
      text-decoration: underline;
    }

    .message-box {
      margin-top: 15px;
      font-size: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="forgot-box">
    <h2>Forgot Password</h2>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Enter your registered email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Show Password</button>
    </form>
    <div class="message-box mt-3">
      <?= $passwordMessage ?>
    </div>
    <div class="text-center mt-3">
      <a href="index.php">Back to Login</a>
    </div>
  </div>
</body>
</html>
