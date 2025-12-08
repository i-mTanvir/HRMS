<?php
include("connection.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("Invalid customer id");
}

// Customer info
$query = "SELECT * FROM customers WHERE id='$id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
if (!$row) {
    die("Customer not found");
}

// Services booked by this customer (match by customer email)
$customerEmail = mysqli_real_escape_string($con, $row['email']);
$servicesSql = "
    SELECT id, product_name, provider_name, booking_date, booking_time,
           customer_name, customer_phone, customer_location, price, status, paid
    FROM services
    WHERE customer_email = '$customerEmail'
    ORDER BY created_at DESC
";
$servicesResult = mysqli_query($con, $servicesSql);
$hasServices = $servicesResult && mysqli_num_rows($servicesResult) > 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RIPO - User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<!-- TOP NAVBAR -->
<header class="main-header">
    <div class="nav-left">
        <img src="media/logo.png" alt="RIPO Logo">
        <span>RIPO</span>
    </div>
    <div class="nav-title">My Profile</div>
</header>

<main class="page-content">

    <!-- PROFILE CARD -->
    <section class="profile-card">
        <div class="profile-top">
            <div class="profile-avatar">
                <img src="media/service-1.png" alt="User photo">
            </div>

            <div class="profile-info">
                <h2 class="profile-name"><?php echo $row['full_name']; ?></h2>

                <p class="profile-role">Regular Customer</p>

                <ul class="profile-details">
                    <li><strong>Email:</strong><?php echo $row['email']; ?></li>
                    <li><strong>Phone:</strong><?php echo $row['mobile_number'];?></li>
                    <li><strong>Location:</strong><?php echo $row['location'] ?></li>
                    <li><strong>Joined:</strong><?php echo $row['joined'] ?></li>
                </ul>
            </div>
        </div>

        <a class="logout-btn" href="login.html">Logout</a>
    </section>

    <!-- SERVICES / BOOKINGS LIST -->
    <section class="services-section">
        <div class="section-header">
            <h3>Your Requests</h3>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Provider</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Phone</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($hasServices): ?>
                    <?php while ($svc = mysqli_fetch_assoc($servicesResult)): ?>
                        <?php
                            $isAccepted = ($svc['status'] === 'accepted');
                            $isCanceled = ($svc['status'] === 'canceled');
                            $isPaid     = ($svc['paid'] === 'paid' || $svc['paid'] == 1);
                            $canPay     = $isAccepted && !$isPaid;
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($svc['product_name']); ?></td>
                            <td><?= htmlspecialchars($svc['provider_name']); ?></td>
                            <td><?= htmlspecialchars($svc['booking_date']); ?></td>
                            <td><?= htmlspecialchars($svc['booking_time']); ?></td>
                            <td><?= htmlspecialchars($svc['customer_location']); ?></td>
                            <td><?= htmlspecialchars($svc['customer_phone']); ?></td>
                            <td><?= htmlspecialchars($svc['price']); ?></td>
                            <td><?= htmlspecialchars($svc['status']); ?></td>
                            <td>
                                <?php if ($isPaid): ?>
                                    <span class="paid-pill">Paid</span>
                                <?php else: ?>
                                    <form action="payment.php" method="post" style="margin:0; display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                                        <input type="hidden" name="service_id" value="<?= $svc['id']; ?>">
                                        <input type="hidden" name="customer_id" value="<?= $id; ?>">
                                        <input type="number" name="star" min="1" max="5" step="1" placeholder="Rate 1-5" style="width:80px; padding:6px 8px; border:1px solid #ccd2e6; border-radius:6px;" required>
                                        <input type="text" name="comment" placeholder="Write a feedback" style="padding:6px 8px; border:1px solid #ccd2e6; border-radius:6px; min-width:140px;" required>
                                        <button
                                            type="submit"
                                            name="pay"
                                            <?= $canPay ? '' : 'disabled'; ?>
                                            style="background: <?= $canPay ? '#192156' : '#999'; ?>; color: #fff; padding: 6px 12px; border: none; border-radius: 4px; cursor: <?= $canPay ? 'pointer' : 'not-allowed'; ?>;"
                                        >
                                            Payment
                                        </button>
                                    </form>
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

</main>

</body>
</html>
