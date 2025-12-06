<?php
include 'connection.php';

$fullName = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$mobileNumber = $_POST['phone'] ?? '';
$location = $_POST['location'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if ($password !== $confirmPassword) {
    echo "Passwords do not match.";
    exit;
}


    $query = "INSERT INTO providers (email, full_name, mobile_number, location, password) VALUES ('$email', '$fullName','$mobileNumber','$location','$password')";

    $run = mysqli_query($con, $query);

if (!$run) {
    echo "Submission failed";
} else {
    header("Location: provider.html");
    exit;
}
?>