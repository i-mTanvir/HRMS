<?php
include 'connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

$id             = $_POST['id'];
$product_name   = $_POST['product_name'];
$product_code   = $_POST['product_code'];
$category      = $_POST['category'];
$description   = $_POST['description'];
$offer_off     = $_POST['offer_off'];
$duration      = $_POST['duration'];
$price1        = $_POST['price1'];



mysqli_query($con, "UPDATE product SET product_name='$product_name', 
    product_code='$product_code',
    category='$category',
    description='$description',
    price ='$price1',
    duration='$duration',
    offer_off ='$offer_off' WHERE id='$id'");
    header("location: product_display.php");
    exit;
}else{
    echo "Invalid Request";
}


$id  = $_GET['id'];
$row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM product WHERE id='$id'"));
?>

<form method="post">
    <input type="text" name="product_name" value="<?= $row['product_name'] ?>"><br><br>
    <textarea name="product_code"><?= $row['product_code'] ?></textarea><br><br>
    <input type="hidden" name="id" value="<?= $row['id'] ?>">


    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" placeholder="Enter product name">
    
    <label for="product_code">Product Code</label>
                    <input type="text" id="product_code" name="product_code" placeholder="Enter product code">
<label for="category">Category</label>
                    <input type="text" id="category" name="category" placeholder="Enter category">

<label for="description">Description</label>
                    <textarea id="description" name="description" rows="3"
                        placeholder="Add a short description"></textarea>

<label for="duration">Duration</label>
                    <input type="text" id="duration" name="duration" placeholder="e.g., 2 hours">

     <label for="price1">Price</label>
                    <input type="text" id="price1" name="price1" placeholder="Enter price">
                    
           <label for="offer_off">Offer Off (%)</label>
                    <input type="number" id="offer_off" name="offer_off" placeholder="e.g., 10">
                    
                    

    <input type="submit" value="Update">
</form>