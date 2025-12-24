<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Glamora Admin Login</title>
  <link href="../bootstrap.min.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f3ece6;
      color: #5a4c42;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-container {
      background-color: #fffaf5;
      width: 90%;
      max-width: 900px;
      display: flex;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 25px rgba(167, 139, 113, 0.25);
    }

    .left {
      width: 50%;
      background-color: #f3ece6;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 40px;
    }

    .left img {
      width: 200px;
      max-width: 100%;
      margin-bottom: 20px;
    }

    .right {
      width: 50%;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .right h2 {
      font-size: 24px;
      margin-bottom: 10px;
      color: #7c5e46;
    }

    .right p {
      font-size: 14px;
      color: #8b7e75;
      margin-bottom: 30px;
    }

    .right input {
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #d5c8bc;
      border-radius: 5px;
      font-size: 16px;
      width: 100%;
      background-color: #fffaf5;
      color: #5a4c42;
    }

    .right button {
      padding: 12px;
      background-color: #c49a6c;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      
    }

    .right button:hover {
      background-color: #a87f5c;
    }

    .right a {
      margin-top: 15px;
      color: #8b7e75;
      text-align: center;
      display: block;
      font-size: 13px;
      text-decoration: none;
    }
    .right a:hover {
      color: #c49a6c;
    }
    .login-container {
      flex-direction: column;
    }
   .left, .right {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="left">
      <!-- <img src="../logo.png" alt="Glamora Logo" /> -->
      <h1>GLAMORA</h1>
    </div>
    <div class="right">
      <h2>Welcome</h2>
      <p>Please login to Admin Dashboard.</p>
      <form method="post">
        <input type="text" name="email" placeholder="Email" required />
        <input type="password" name="pwd" placeholder="Password" required />
        <button type="submit" name="login">LOGIN</button>
        <a href="forgotpassword.php">Forgotten Your Password?</a>
        
        <a href="adminregister.php">Don`t have account ? Register</a>
      </form>
    </div>
  </div>
</body>
</html>
<?php
session_start();
if (isset($_REQUEST['login'])) {
    $email = $_REQUEST['email'];
    $pwd = $_REQUEST['pwd'];

    require '../db.php';

    $q = "select * from admin where email='$email' and password='$pwd'";
    $result = mysqli_query($mysql, $q) or die("Query Failed!!" . mysqli_error($mysql));
    $nor = mysqli_num_rows($result);

    if ($nor > 0) {
        $_SESSION['email'] = $email;
        header("location:Dashboard.php");
    } else {
        echo "<script>alert('Either Email Or Password Is Incorrect');</script>";
    }
}
?>
