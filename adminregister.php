<?php
require '../db.php';

if (isset($_POST['register'])) {

    // Escape to avoid SQL injection
    $email = mysqli_real_escape_string($mysql, $_POST['email']);
    $password = mysqli_real_escape_string($mysql, $_POST['password']);

    // 1. Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
        header("Location: adminregister.php");
        exit();
    }

    // 2. Password length validation
    if (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters');</script>";
        header("Location: adminregister.php");
        exit();
    }

    // 3. Check if email already exists
    $check = mysqli_query($mysql, "SELECT * FROM admin WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already exists!');</script>";
        header("Location: adminregister.php");
        exit();
    }

    // 4. Insert into database
    $q = "INSERT INTO admin (email, password) VALUES ('$email', '$password')";
    
    if (mysqli_query($mysql, $q)) {
        header("Location: index.php?registered=1");
        exit();
    } else {
        echo "<script>alert('Registration failed.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Registration | Glamora</title>
  <link href="../bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f3ece6;
      color: #5a4c42;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .register-box {
      background-color: #fffaf5;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(124, 94, 70, 0.15);
      width: 100%;
      max-width: 500px;
    }

    .register-box h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #c49a6c;
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
      margin-top: 15px;
    }

    .btn-primary:hover {
      background-color: #a87f5c;
    }

    .text-center a {
      color: #7c5e46;
      text-decoration: none;
      font-size: 14px;
    }

    .text-center a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-box">
    <h2>Admin Registration</h2>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required />
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required />
      </div>
      <button type="submit" name="register" class="btn btn-primary">Register</button>
      <div class="text-center mt-3">
        <a href="index.php">Already have an account? Login</a>
      </div>
    </form>
  </div>
</body>
</html>