<?php
include "connection.php";

$id = $_GET["id"];

$query = "SELECT * FROM customers WHERE id=$id";

$run = mysqli_query($con, $query);

$row = mysqli_fetch_assoc($run);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="customer_dashboard.css">
</head>
<body>
        <div id="page">
        <div id="emergency-banner">24/7 emergency services +1 (877) 555-6666</div>

        <div id="nav">
            <div id="nav-left">
                <div id="logo-wrap">
                    <img id="logo" src="media/logo.png" alt="RIPO logo">
                    <div id="logo-text">RIPO</div>
                </div>
            </div>
            <div id="nav-right">
                <div id="service-location">
                    <div id="service-text">Service In</div>
                    <div id="service-area"><?php echo $row['location'] ?></div>
                </div>
                <div id="profile-icon"><a href="profile.php?id=<?php echo $row['id']; ?>">👤</a></div>
            </div>
        </div>

</body>
</html>