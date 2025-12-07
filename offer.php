<?php
    include 'connection.php';

    $key = '';
    if (isset($_GET['search'])) {
        $key = trim($_GET['search']);
    }

    $safeKey = mysqli_real_escape_string($con, $key);
    $query = "
        SELECT id, product_name, price, rating, offer_off
        FROM product
        WHERE COALESCE(offer_off, 0) > 0
          AND (
            product_name LIKE '%$safeKey%'
            OR product_code LIKE '%$safeKey%'
            OR description LIKE '%$safeKey%'
          )";

    $run = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <link rel="stylesheet" href="services.css">
</head>

<body>
    <form class="search-container" method="get" action="services.php">
        <div id="hero-search">
            <div id="search-icon">&#128269;</div>
            <input id="search-input" name="search" type="text" placeholder="Search ..." value="<?php echo htmlspecialchars($key); ?>">
        </div>
    </form>
    <div>
        <div id="our-services">
            <h2>Our Services</h2>
            <div id="service-cards">
                <?php if($run && mysqli_num_rows($run) > 0){ ?>
                    <?php while($row = mysqli_fetch_assoc($run)){ ?>
                        <div class="card">
                            <img src="media/service-1.png" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                            <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                            <p>Offer: <?php echo htmlspecialchars($row['offer_off']); ?>% off</p>
                            <p>Rating: <?php echo (isset($row['rating']) && $row['rating'] !== '' ? htmlspecialchars($row['rating']) : 'N/A'); ?></p>
                            <div class="card-bottom">
                                <span class="price">Rs. <?php echo htmlspecialchars($row['price']); ?></span>
                                <a class="cta-button" href="productinfo.php?id=<?php echo urlencode($row['id']); ?>">Book</a>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>No services found.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>
