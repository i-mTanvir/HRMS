<?php
$con = mysqli_connect("localhost", "root", "", "ripo");

$product_name   = $_POST['product_name'];
$product_code   = $_POST['product_code'];
$category      = $_POST['category'];
$description   = $_POST['description'];
$offer_off     = $_POST['offer_off'];
$duration      = $_POST['duration'];
$price1         = $_POST['price1'];

$query = "INSERT INTO product (product_name, product_code, category, description, duration,offer_off, price) VALUES ('$product_name', '$product_code', '$category', '$description', '$duration', $offer_off, $price1)";

$run = mysqli_query($con, $query);

if(!$run){
    echo "Error: " . mysqli_error($con);

} else{
        echo "submission Success!" ;
}
?>