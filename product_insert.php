<?php
$con = mysqli_connect("localhost", "root", "", "ripo");

if (!$con) {
    die("DB connection failed: " . mysqli_connect_error());
}

// 1) Get provider id from POST (hidden input)
if (!isset($_POST['id'])) {
    die("No provider ID in POST");
}

$id = intval($_POST["id"]);
if ($id <= 0) {
    die("Invalid provider ID: " . htmlspecialchars($_POST['id']));
}

// 2) Get provider full_name
$provider_info = "SELECT full_name FROM providers WHERE id = $id";
$result = mysqli_query($con, $provider_info);

if (!$result) {
    die("Provider query failed: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($result);
if (!$row) {
    die("No provider found with id = $id");
}

$provider_name = mysqli_real_escape_string($con, $row['full_name']);

// 3) Get product data from form
$product_name   = mysqli_real_escape_string($con, $_POST['product_name']);
$product_code   = mysqli_real_escape_string($con, $_POST['product_code']);
$category       = mysqli_real_escape_string($con, $_POST['category']);
$description    = mysqli_real_escape_string($con, $_POST['description']);
$offer_off      = intval($_POST['offer_off']);
$duration       = mysqli_real_escape_string($con, $_POST['duration']);
$price1         = floatval($_POST['price1']);

// 4) Insert product with provider_name
$query = "
INSERT INTO product 
    (product_name, product_code, category, description, duration, offer_off, price, provider_name)
VALUES 
    ('$product_name', '$product_code', '$category', '$description', '$duration', $offer_off, $price1, '$provider_name')
";

$run = mysqli_query($con, $query);

if (!$run) {
    die("Error inserting product: " . mysqli_error($con));
} else {
    header("Location: product_display.php?id=" . $row['id']);
    exit();
}
?>
