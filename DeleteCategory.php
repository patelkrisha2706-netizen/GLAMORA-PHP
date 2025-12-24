<?php
    session_start();
    if(!isset($_SESSION['email'])){
      header("location:index.php");
    }
    require '../db.php';
    if(isset($_GET['cid'])){
        $cid=$_GET['cid'];
        $q="delete from category where cid=$cid";

        if(mysqli_query($mysql,$q)){
            header("location:ReadCategory.php?delete=1");
        }
    }else{
        header("location:ReadCategory.php");
    }
?>