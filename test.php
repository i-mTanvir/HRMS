<?php

include("connection.php");

// 1. Make sure all expected GET values exist
if (!isset($_GET['loginRole'], $_GET['email'], $_GET['password'])) {
    die("Form data missing.");
}

$role     = $_GET['loginRole'];
$email    = $_GET['email'];
$password = $_GET['password'];

// OPTIONAL BUT HELPFUL: escape values to avoid basic SQL issues
$email    = mysqli_real_escape_string($con, $email);
$password = mysqli_real_escape_string($con, $password);

if ($role == 'customer') {

    // 2. Query the correct table for customers
    $query  = "SELECT id FROM customers WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($con, $query);

    if (!$result) {
        // Show SQL error if something is wrong with the query/table
        die("Query failed: " . mysqli_error($con));
    }

    if (mysqli_num_rows($result) == 0) {
        echo "Invalid customer email or password";
    } else {
        $row = mysqli_fetch_assoc($result);

        // 3. Make sure header is clean and correct
        header("Location: customer_dashboard.php?id=" . $row['id']);
        exit();
    }

} else if ($role == 'provider'){

    // 4. Same logic for providers
    $query  = "SELECT id FROM providers WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    if (mysqli_num_rows($result) == 0) {
        echo "Invalid provider email or password";
    } else {
        $row = mysqli_fetch_assoc($result);

        header("Location: product_display.php?id=" . $row['id']);
        exit();
    }
}

?>
