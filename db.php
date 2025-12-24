<?php
$mysql = mysqli_connect("localhost", "root", "");  // adjust credentials if needed
if (!$mysql) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_select_db($mysql, "glomora");  // Make sure your database name is correct
?>