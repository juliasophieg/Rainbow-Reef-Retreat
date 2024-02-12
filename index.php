<?php

declare(strict_types=1);
session_start();

$checkIn = '';
$checkOut = '';

if (isset($_POST['availability'])) {

    //Store picked dates in session variables
    $_SESSION['checkin'] = $_POST['checkin'];
    $_SESSION['checkout'] = $_POST['checkout'];
}

$checkIn = isset($_SESSION['checkin']) ? $_SESSION['checkin'] : '';
$checkOut = isset($_SESSION['checkout']) ? $_SESSION['checkout'] : '';

?>

<?php require __DIR__ . '/views/header.php'; ?>

<main>
    <!-- AVAILABILITY -->
    <section>
        <!--PICK DATES -->
        <form class="dates" action="/" method="post" onsubmit="return validateDates()">
            <div class="checkin-col">
                <label for="checkin">Check in:</label>
                <input type="date" id="checkin" name="checkin" min="2024-01-01" max="2024-01-31" value="<?= $checkIn ?>">
            </div>
            <div class=" checkout-col">
                <label for="checkout">Check out:</label>
                <input type="date" id="checkout" name="checkout" min="2024-01-01" max="2024-01-31" value="<?= $checkOut ?>">
            </div>
            <input type="submit" id="availability" name="availability" value="Check availability">
        </form>

        <!-- PRESENT AVAILABLE ROOMS -->
        <div class="rooms-wrapper">
            <?php
            require_once __DIR__ . '/availability.php'; ?>
        </div>
    </section>

    <!-- HOTEL INFO -->
    <div class="hotel-info">
        <div class="left">
            <h2>The Hotel</h2>
            <p>Nestled on the pristine shores of a secluded island, Rainbow Reef Retreat invites you to experience a harmonious blend of luxury, serenity, and natural beauty. Surrounded by azure waters and lush tropical landscapes, our boutique hotel offers an idyllic sanctuary where you can relax, rejuvenate, and create cherished memories with your loved ones.</p>
            <p>Discover a hidden gem where the rhythmic sounds of the waves lull you into a state of tranquility, and the gentle caress of the ocean breeze soothes your soul. </p>
            <div class="stars">
                <h1>⭑ ⭑</h1>
            </div>
        </div>
        <div class="right">
            <h2>Additional Features</h2>
            <p>We offer a curated selection of additional features and experiences to elevate your stay. From thrilling adventures on the water to serene moments of relaxation and rejuvenation.</p>
            <p>Discover the extraordinary experiences that await you at our exclusive retreat.</p>
            <div class="features-container">
                <div class="features-div">
                    <div class="features-img" id="one"></div>
                    <h5>Wildlife Watching</h5>
                </div>
                <div class="features-div">
                    <div class="features-img" id="two"></div>
                    <h5>Lotus Spa</h5>
                </div>
                <div class="features-div">
                    <div class="features-img" id="three"></div>
                    <h5>Jet Ski Adventures</h5>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require __DIR__ . '/views/footer.php'; ?>

<script src="assets/scripts/index.js"></script>