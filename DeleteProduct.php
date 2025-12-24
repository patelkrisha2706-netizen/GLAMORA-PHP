<?php
require '../db.php';

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];

    // Get image name first
    $res = mysqli_query($mysql, "SELECT image FROM product WHERE pid='$pid'");
    if ($row = mysqli_fetch_assoc($res)) {
        $image = $row['image'];
        $path = "uploads/$image";   // set path to uploads folder

        // Delete product record
        $q = "DELETE FROM product WHERE pid='$pid'";
        if (mysqli_query($mysql, $q)) {
            if (file_exists($path)) {
                unlink($path);
            }
            header("Location: ReadProduct.php");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($mysql);
        }
    } else {
        echo "Product not found!";
    }
} else {
    echo "Invalid request!";
}
?>