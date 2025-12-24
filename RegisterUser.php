<?php
require 'db.php';

if (isset($_POST['register'])) {
    $uname = trim($_POST['uname']);
    $uemail = trim($_POST['uemail']);
    $password = $_POST['password']; // <-- plain text password
    $gender = $_POST['gender'];
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    $errors = [];

    // ---------------------------------
    // VALIDATIONS
    // ---------------------------------

    // Username: only letters
    if (!preg_match("/^[a-zA-Z ]+$/", $uname)) {
        $errors[] = "Username can contain only alphabets and spaces.";
    }

    // Email: valid format
    if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    } else {
        // Check if email already exists
        $checkEmail = mysqli_query($mysql, "SELECT * FROM user WHERE uemail='$uemail'");
        if (mysqli_num_rows($checkEmail) > 0) {
            $errors[] = "Email already registered. Try another.";
        }
    }

    // Password: minimum 6 characters
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Phone: 10 digits
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be 10 digits.";
    }

    if (empty($errors)) {

        // -------------------------------
        // STORE PLAIN PASSWORD
        // -------------------------------
        $plainPassword = $password; // no hashing

        $q = "INSERT INTO user (uname, uemail, password, gender, address, phone) 
              VALUES ('$uname', '$uemail', '$plainPassword', '$gender', '$address', '$phone')";

        if (mysqli_query($mysql, $q)) {
            header("Location: LoginUser.php?registered=1");
            exit;
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Register</title>
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
        }
        .register-box table td, 
        .register-box label, 
        .register-box input, 
        .register-box select {
            font-size: 16px;
            color: #000;
        }
        .register-box {
            width:40%;  
            margin: 80px auto;
            padding: 40px;      
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
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
        a { color: #000; text-decoration: none; }
        a:hover { color: #555; text-decoration: underline; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>User Registration</h2>

        <?php if(!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach($errors as $err): ?>
                        <li><?php echo $err; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post">
            <table class="table table-borderless">
                <tr>
                    <td><label class="form-label">Full Name</label></td>
                    <td><input type="text" name="uname" class="form-control" required value="<?php echo isset($uname) ? htmlspecialchars($uname) : ''; ?>"></td>
                </tr>
                <tr>
                    <td><label class="form-label">Email</label></td>
                    <td><input type="email" name="uemail" class="form-control" required value="<?php echo isset($uemail) ? htmlspecialchars($uemail) : ''; ?>"></td>
                </tr>
                <tr>
                    <td><label class="form-label">Password</label></td>
                    <td><input type="password" name="password" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label class="form-label">Gender</label></td>
                    <td>
                        <select name="gender" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo (isset($gender) && $gender=='Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (isset($gender) && $gender=='Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label class="form-label">Address</label></td>
                    <td><input type="text" name="address" class="form-control" required value="<?php echo isset($address) ? htmlspecialchars($address) : ''; ?>"></td>
                </tr>
                <tr>
                    <td><label class="form-label">Phone</label></td>
                    <td><input type="text" name="phone" maxlength="10" class="form-control" required value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <button type="submit" name="register" class="btn btn-custom w-100">Register</button>
                    </td>
                </tr>
            </table>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="LoginUser.php">Login</a></p>
    </div>
</body>
</html>