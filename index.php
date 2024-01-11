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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rainbow Reef Retreat</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="navbar">
            <div class="logo"></div>
            <nav>
                <a href="/">The Island</a>
                <a href="/">The Hotel</a>
                <a href="/">Activities</a>
                <a href="/">Contact</a>
            </nav>
        </div>
        <div class="intro">
            <h1>Rainbow Reef Retreat</h1>
            <h2>⭑⭑</h2>
        </div>
    </header>
    <main>
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
                <?php require_once __DIR__ . '/availability.php'; ?>
            </div>
        </section>
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
    <footer>
        <div class="footer-column">
            <h4>RAINBOW REEF RETREAT</h4>
            <div class="divider"></div>
            <a href="/">Location</a>
            <a href="/">Rooms</a>
            <a href="/">Restaurant</a>
            <a href="/">Activities</a>
        </div>
        <div class="footer-column">
            <h4>CONTACT</h4>
            <div class="divider"></div>
            <p>+12 345 678 90</p>
            <a href="/">hello@rainbowreefretreat.com</a>
            <p>Rainbow Reef Retreat</p>
            <p>42 Ocean View Lane</p>
            <p>12345 Rainbow Reef Island</p>
        </div>
        <div class="footer-column">
            <h4>CUSTOMER SERVICE</h4>
            <div class="divider"></div>
            <a href="/">FAQ</a>
            <a href="/">Booking policy</a>
        </div>
    </footer>

    <script>
        function validateDates() {
            // Get the checkin and checkout dates
            const checkin = document.getElementById('checkin').value;
            const checkout = document.getElementById('checkout').value;

            // Check if any of them are empty
            if (checkin === '' || checkout === '') {
                // Display error message
                alert('Please select both check-in and check-out dates.');

                // Focus on the first empty date field
                if (checkin === '') {
                    document.getElementById('checkin').focus();
                } else {
                    document.getElementById('checkout').focus();
                }

                // Prevent form submission
                return false;
            }

            // Check if checkin date is after checkout date
            if (checkin >= checkout) {
                // Display error message
                alert('Check-out date must be after check-in date.');

                // Focus on the checkout date field
                document.getElementById('checkout').focus();

                // Prevent form submission
                return false;
            }

            // Continue with form submission
            return true;
        }
    </script>
</body>



</html>