<?php
include 'connection.php';

$serviceId  = isset($_POST['service_id']) ? (int) $_POST['service_id'] : 0;
$customerId = isset($_POST['customer_id']) ? (int) $_POST['customer_id'] : 0;
$star       = isset($_POST['star']) ? intval($_POST['star']) : 0;
$comment    = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if ($serviceId <= 0 || $customerId <= 0) {
    die("Invalid request");
}

// Clamp rating 1-5
if ($star < 1 || $star > 5) {
    die("Rating must be between 1 and 5");
}

// Mark as paid and save rating/comment
$updateSql = "UPDATE services SET paid = 1, star = ?, comment = ? WHERE id = ?";
$stmt = mysqli_prepare($con, $updateSql);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, "isi", $star, $comment, $serviceId);
if (!mysqli_stmt_execute($stmt)) {
    die("Update failed: " . mysqli_error($con));
}
mysqli_stmt_close($stmt);

header("Location: profile.php?id=" . $customerId);
exit;
?>
