<?php
include 'connection.php';

$providerId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($providerId <= 0) {
    die("Invalid provider id");
}

// Provider
$pstmt = mysqli_prepare($con, "SELECT full_name, email FROM providers WHERE id = ?");
mysqli_stmt_bind_param($pstmt, "i", $providerId);
mysqli_stmt_execute($pstmt);
$presult = mysqli_stmt_get_result($pstmt);
$provider = mysqli_fetch_assoc($presult);
mysqli_stmt_close($pstmt);

if (!$provider) {
    die("Provider not found");
}
$providerEmail = $provider['email'];
$providerName  = $provider['full_name'];

// Products for provider
$productStmt = mysqli_prepare($con, "SELECT * FROM product WHERE provider_email = ?");
mysqli_stmt_bind_param($productStmt, "s", $providerEmail);
$productStmt->execute();
$productsResult = mysqli_stmt_get_result($productStmt);
$hasProducts = $productsResult && mysqli_num_rows($productsResult) > 0;

// Requests for provider
$requestsStmt = mysqli_prepare(
    $con,
    "SELECT id, product_name, customer_name, customer_phone, customer_location, booking_date, booking_time, price, status, paid
     FROM services
     WHERE provider_email = ?
     ORDER BY created_at DESC"
);
mysqli_stmt_bind_param($requestsStmt, "s", $providerEmail);
mysqli_stmt_execute($requestsStmt);
$requestsResult = mysqli_stmt_get_result($requestsStmt);
$hasRequests = $requestsResult && mysqli_num_rows($requestsResult) > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provider Dashboard</title>
    <link rel="stylesheet" href="provider.css">
</head>
<body>

<div id="page">
        <div id="emergency-banner">24/7 emergency services +1 (877) 555-6666</div>

    <div class="page">
        <section class="services-section">
            <div class="section-header">
                <h2>Your Services (<?= htmlspecialchars($providerName) ?>)</h2>
                <div class="header-actions">
                    <a class="add-btn" href="add_new.php?id=<?= $providerId ?>">Add New</a>
                    <a class="logout-btn" href="login.html">Logout</a>
                </div>
            </div>
            <table class="data-table services-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($hasProducts): ?>
                        <?php while ($product = mysqli_fetch_assoc($productsResult)): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['product_name']) ?></td>
                                <td><?= htmlspecialchars($product['description']) ?></td>
                                <td><?= htmlspecialchars($product['price']) ?></td>
                                <td>
                                    <a class="update-link" href="update.php?id=<?= $product['id'] ?>">Update</a> |
                                    <a class="delete-link" href="product_delete.php?id=<?= $product['id'] ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No products added yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section class="stats-banner">
            <div class="rating">★★★★★</div>
            <div class="stat-item">
                <div class="stat-number">210+</div>
                <div class="stat-label">Project Done</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">210+</div>
                <div class="stat-label">Happy Clients</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">10+</div>
                <div class="stat-label">Years of Skill</div>
            </div>
        </section>

        <section class="requests-section">
            <h3>All Status</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>C Name</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($hasRequests): ?>
                        <?php while ($req = mysqli_fetch_assoc($requestsResult)): ?>
                            <tr>
                                <td><?= htmlspecialchars($req['product_name']); ?></td>
                                <td><?= htmlspecialchars($req['booking_date']); ?></td>
                                <td><?= htmlspecialchars($req['booking_time']); ?></td>
                                <td><?= htmlspecialchars($req['customer_name']); ?></td>
                                <td><?= htmlspecialchars($req['customer_phone']); ?></td>
                                <td><?= htmlspecialchars($req['customer_location']); ?></td>
                                <td><?= htmlspecialchars($req['price']); ?></td>
                                <td><?= htmlspecialchars($req['status']); ?></td>
                                <td>
                                    <?php $isPaid = isset($req['paid']) && ($req['paid'] === 'paid' || intval($req['paid']) === 1); ?>
                                    <?php if ($isPaid): ?>
                                        Paid
                                    <?php else: ?>
                                        <a href="booking_confirm.php?id=<?= urlencode($req['id']); ?>">Confirm</a> |
                                        <a href="booking_cancel.php?id=<?= urlencode($req['id']); ?>">Cancel</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No requests yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
