<?php
include 'connection.php';

$product = null;
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $stmt = mysqli_prepare(
        $con,
        "SELECT id, product_name, description, category, duration, price, rating FROM product WHERE id = ?"
    );

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RIPO - Service Info</title>
    <link rel="stylesheet" href="productinfo.css">
</head>
<body>

<div class="main-header">
    <div class="nav-left">
        <img src="media/logo.png" alt="RIPO Logo">
        <span>RIPO</span>
    </div>
    <div class="nav-title">Service Details</div>
</div>

<main class="page-content">
    <?php if (!$product) { ?>
        <p style="padding:16px;">Service not found. <a href="services.php">Back to services</a></p>
    <?php } else { ?>
    <div class="service-section">
        <div class="service-image">
            <img src="media/service-1.png" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
        </div>

        <div class="service-info">
            <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <p class="service-desc">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </p>

            <ul class="service-meta">
                <li><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></li>
                <li><strong>Duration:</strong> <?php echo htmlspecialchars($product['duration']); ?></li>
                <li><strong>Price:</strong> Tk <?php echo htmlspecialchars($product['price']); ?></li>
                <li><strong>Rating:</strong> <?php echo htmlspecialchars($product['rating'] ?? 'N/A'); ?> &#9733;</li>
            </ul>
        </div>
    </div>
  <div id="provider-info">
    <div class="img-info">
        <img src="media/profile.jpeg" alt="Service Provider">
    </div>

    <div class="provider-details">
        <h3>Service Provider Information</h3>
        <ul>
            <li><strong>Name:</strong> Md.rakibur Rahman</li>
            <li><strong>Email:</strong> rahmanrakib159@gmail.com</li>
            <li><strong>Phone:</strong> +8801678901234</li>
        </ul>
    </div>
</div>
<section class="bottom-two-cards">

    <div class="card booking-card">
        <h3>Book Service Date & Time</h3>

        <form>
            <div class="field-group">
                <label for="booking-date">Choose a date</label>
                <input type="date" id="booking-date" name="booking-date">
            </div>

            <div class="field-group">
                <label for="booking-time">Choose a time</label>
                <input type="time" id="booking-time" name="booking-time">
            </div>

            <div class="field-group">
                <label for="booking-note">Note (optional)</label>
                <textarea id="booking-note" rows="3"
                    placeholder="Example: Please come after 4 PM..."></textarea>
            </div>

            <button type="submit" class="primary-btn">Confirm Booking</button>
        </form>
    </div>

    <div class="card comments-card">
        <h3>Customer Reviews</h3>

        <div class="reviews-list">
            <div class="review-item">
                <div class="review-top">
                    <span class="review-name">Sadia Islam</span>
                    <span class="review-rating">&#9733; 4.8</span>
                </div>
                <p class="review-text">
                    Very professional and on time. AC is cooling much better now.
                </p>
                <span class="review-date">12 Dec 2025</span>
            </div>

            <div class="review-item">
                <div class="review-top">
                    <span class="review-name">Hasan Ali</span>
                    <span class="review-rating">&#9733; 4.5</span>
                </div>
                <p class="review-text">
                    Good service, friendly behaviour. Will book again.
                </p>
                <span class="review-date">09 Dec 2025</span>
            </div>

            <div class="review-item">
                <div class="review-top">
                    <span class="review-name">Nusaiba Rahman</span>
                    <span class="review-rating">&#9733; 5.0</span>
                </div>
                <p class="review-text">
                    Fast response and clean work. Highly recommended!
                </p>
                <span class="review-date">03 Dec 2025</span>
            </div>
             <div class="review-item">
                <div class="review-top">
                    <span class="review-name">Nusaiba Rahman</span>
                    <span class="review-rating">&#9733; 5.0</span>
                </div>
                <p class="review-text">
                    Fast response and clean work. Highly recommended!
                </p>
                <span class="review-date">03 Dec 2025</span>
            </div>
             <div class="review-item">
                <div class="review-top">
                    <span class="review-name">Nusaiba Rahman</span>
                    <span class="review-rating">&#9733; 5.0</span>
                </div>
                <p class="review-text">
                    Fast response and clean work. Highly recommended!
                </p>
                <span class="review-date">03 Dec 2025</span>
            </div>
        </div>

        <p class="reviews-footer">Showing latest reviews.</p>
    </div>

</section>

<?php } ?>
</main>

</body>
</html>
