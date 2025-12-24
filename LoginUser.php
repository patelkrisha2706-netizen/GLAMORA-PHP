<?php
session_start();

if (isset($_POST['login'])) {
    $uemail = trim($_POST['uemail']);
    $password = trim($_POST['password']);

    require 'db.php';

    //  Get user by email
    $q = "SELECT * FROM user WHERE uemail='$uemail' AND status='Active' LIMIT 1";
    $result = mysqli_query($mysql, $q) or die("Query Failed!! " . mysqli_error($mysql));

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        //  Plain text password check (change later to password_verify for security)
        if ($password === $user['password']) {
            $_SESSION['uid'] = $user['uid'];
            $_SESSION['uname'] = $user['uname'];
            $_SESSION['uemail'] = $user['uemail'];

            header("Location: HomePage.php");
            exit;
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('Invalid email or inactive account');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            width: 100%;
            max-width: 450px;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }
        h2 { 
            text-align: center; 
            margin-bottom: 20px; 
            color: #000; 
        }
        .btn-custom {
            background-color: #fff; 
            color: #000; 
            border: 1px solid #000;
            transition: all 0.3s ease;
        }
        .btn-custom:hover { 
            background-color: #000; 
            color: #fff; 
        }
        table td { vertical-align: middle; }
        a { color: #000; text-decoration: none; }
        a:hover { color: #555; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>User Login</h2>
        <form method="post">
            <table class="table table-borderless">
                <tr>
                    <td><label class="form-label">Email</label></td>
                    <td><input type="email" name="uemail" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label class="form-label">Password</label></td>
                    <td><input type="password" name="password" class="form-control" required></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <button type="submit" name="login" class="btn btn-custom w-100">Login</button>
                    </td>
                </tr>
            </table>
        </form>
        <p class="text-center mt-3">Don’t have an account? <a href="RegisterUser.php">Register</a></p>
        <p class="text-center mt-3"><a href="HomePage.php">Want To Stay Log Out?</a></p>
    </div>
</body>
</html>