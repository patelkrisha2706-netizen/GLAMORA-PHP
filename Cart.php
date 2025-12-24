<?php
session_start();
require 'db.php';

if(!isset($_SESSION['uid'])){
    echo "<script>alert('Please login first!');window.location='LoginUser.php';</script>";
    exit;
}

$uid = $_SESSION['uid'];

// --------------------------------------------
// ADD TO CART
// --------------------------------------------
if(isset($_POST['pid'])){
    $pid = intval($_POST['pid']);

    // Check if product is already in cart
    $check = mysqli_query($mysql,"SELECT * FROM addtocart WHERE uid=$uid AND pid=$pid");

    // Get product price
    $priceRow = mysqli_fetch_assoc(mysqli_query($mysql,"SELECT price FROM product WHERE pid=$pid"));
    $price = $priceRow['price'];

    if(mysqli_num_rows($check) > 0){

        // Increase qty first
        mysqli_query($mysql,"
            UPDATE addtocart 
            SET qty = qty + 1 
            WHERE uid=$uid AND pid=$pid
        ");

        // Recalculate total
        mysqli_query($mysql,"
            UPDATE addtocart 
            SET total_price = price * qty
            WHERE uid=$uid AND pid=$pid
        ");

    } else {

        mysqli_query($mysql,"
            INSERT INTO addtocart(uid,pid,qty,price,total_price,time_date)
            VALUES($uid,$pid,1,$price,$price,NOW())
        ");
    }

    header("Location: Cart.php");
    exit;
}

// --------------------------------------------
// REMOVE ITEM
// --------------------------------------------
if(isset($_GET['remove'])){
    $pid = intval($_GET['remove']);
    mysqli_query($mysql,"DELETE FROM addtocart WHERE uid=$uid AND pid=$pid");
    header("Location: Cart.php");
    exit;
}

// --------------------------------------------
// INCREASE QTY
// --------------------------------------------
if(isset($_GET['inc'])){
    $pid = intval($_GET['inc']);

    mysqli_query($mysql,"
        UPDATE addtocart 
        SET qty = qty + 1
        WHERE uid=$uid AND pid=$pid
    ");

    mysqli_query($mysql,"
        UPDATE addtocart 
        SET total_price = price * qty
        WHERE uid=$uid AND pid=$pid
    ");

    header("Location: Cart.php");
    exit;
}

// --------------------------------------------
// DECREASE QTY
// --------------------------------------------
if(isset($_GET['dec'])){
    $pid = intval($_GET['dec']);

    $row = mysqli_fetch_assoc(mysqli_query($mysql,"SELECT qty FROM addtocart WHERE uid=$uid AND pid=$pid"));

    if($row['qty'] > 1){

        // Reduce qty
        mysqli_query($mysql,"
            UPDATE addtocart 
            SET qty = qty - 1
            WHERE uid=$uid AND pid=$pid
        ");

        // Update total price
        mysqli_query($mysql,"
            UPDATE addtocart 
            SET total_price = price * qty
            WHERE uid=$uid AND pid=$pid
        ");

    } else {
        // Remove product when qty hits 1
        mysqli_query($mysql,"DELETE FROM addtocart WHERE uid=$uid AND pid=$pid");
    }

    header("Location: Cart.php");
    exit;
}

// --------------------------------------------
// FETCH CART ITEMS
// --------------------------------------------
$products=[];
$q=mysqli_query($mysql,"
    SELECT p.*, a.qty, a.price AS cart_price, a.total_price 
    FROM addtocart a 
    JOIN product p ON a.pid=p.pid 
    WHERE a.uid=$uid
");

while($row=mysqli_fetch_assoc($q)){
    $products[]=$row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
    <link href="bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require 'DynamicHeader.php'; ?>

<div class="container my-5">
<h2>My Cart</h2>

<?php if(empty($products)): ?>
    <p>Your cart is empty.</p>

<?php else: ?>
    <table class="table table-bordered">
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Action</th>
        </tr>

        <?php 
        $grandTotal = 0;
        foreach($products as $p): 
            $grandTotal += $p['total_price'];
        ?>
        <tr>
            <td><img src="admin/uploads/<?php echo $p['image']; ?>" width="70"></td>
            <td><?php echo $p['pname']; ?></td>

            <td>₹ <?php echo $p['cart_price']; ?></td>

            <td>
                <a href="Cart.php?dec=<?php echo $p['pid']; ?>" class="btn btn-sm btn-primary">-</a>
                <?php echo $p['qty']; ?>
                <a href="Cart.php?inc=<?php echo $p['pid']; ?>" class="btn btn-sm btn-primary">+</a>
            </td>

            <td>₹ <?php echo $p['total_price']; ?></td>

            <td><a href="Cart.php?remove=<?php echo $p['pid']; ?>" class="btn btn-danger btn-sm">Remove</a></td>
        </tr>
        <?php endforeach; ?>

        <tr>
            <th colspan="4" class="text-end">Grand Total</th>
            <th colspan="2">₹ <?php echo $grandTotal; ?></th>
        </tr>
    </table>

    <a href="CheckOut.php" class="btn btn-success">Proceed to Checkout</a>
<?php endif; ?>

</div>

<?php require 'Footer.php'; ?>
</body>
</html>