<?php
require 'db.php';
session_start();

if(isset($_POST['reset'])){
    $email = mysqli_real_escape_string($mysql, $_POST['uemail']);
    $check = mysqli_query($mysql, "SELECT * FROM user WHERE uemail='$email'");
    if(mysqli_num_rows($check) > 0){
        $newpass = password_hash('123456', PASSWORD_DEFAULT); // for example, generate new password
        mysqli_query($mysql, "UPDATE user SET password='$newpass' WHERE uemail='$email'");
        echo "<script>alert('Password reset to 123456, please login and change it');window.location='LoginUser.php';</script>";
    } else {
        echo "<script>alert('Email not found');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Forgot Password</h2>
    <form method="post">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="uemail" class="form-control" required>
        </div>
        <button type="submit" name="reset" class="btn btn-primary">Reset Password</button>
    </form>
</div>
</body>
</html>