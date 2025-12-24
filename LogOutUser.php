<?php
session_start();

// Clear only login/session info
if(isset($_SESSION['uid'])){
    unset($_SESSION['uid']);
    unset($_SESSION['uemail']);
    unset($_SESSION['uname']);
}

// Cart/Wishlist remain in DB, so next login it will be loaded

echo "<script>alert('Logged out successfully!');window.location='LoginUser.php';</script>";
exit;
?>
