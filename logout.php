<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Logged Out | Glamora</title>
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

    .logout-box {
      background-color: #fffaf5;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(124, 94, 70, 0.2);
      text-align: center;
      width: 100%;
      max-width: 500px;
    }

    .logout-box h2 {
      color: #c49a6c;
      margin-bottom: 20px;
    }

    .logout-box p {
      margin-bottom: 30px;
      font-size: 16px;
    }

    .logout-box a {
      text-decoration: none;
      background-color: #c49a6c;
      color: white;
      padding: 10px 25px;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .logout-box a:hover {
      background-color: #a87f5c;
    }
  </style>
</head>
<body>
  <div class="logout-box">
    <h2>You've been logged out</h2>
    <p>Thank you for visiting Glamora Admin Dashboard.</p>
    <a href="index.php">Login Again</a>
  </div>
</body>
</html>
