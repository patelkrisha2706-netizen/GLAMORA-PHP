<?php
$link = mysqli_connect("localhost","root","","glomora") or die("Error");

if(isset($_POST['query'])){
    $q = "SELECT pid, pname FROM product WHERE pname LIKE '%".trim($_POST["query"])."%' LIMIT 10";
    $result = mysqli_query($link,$q);

    if(mysqli_num_rows($result)>0){
        while($r = mysqli_fetch_assoc($result)){
            echo "<li class='list-group-item'>
                    <a href='ProductDetail.php?pid=".$r['pid']."' class='text-decoration-none text-dark'>
                        ".$r['pname']."
                    </a>
                  </li>";
        }
    } else {
        echo "<li class='list-group-item text-danger'>No Data Found</li>";
    }
    exit;
}
?>