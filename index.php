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
        <div class="logo"></div>
        <nav>
            <a href="/">The Island</a>
            <a href="/">The Hotel</a>
            <a href="/">Activities</a>
            <a href="/">Contact</a>
        </nav>
    </header>
    <div class="intro">
        <h2>Welcome to</h2>
        <h1>Rainbow Reef Retreat</h1>
    </div>
    <main>
        <!--CHECK ROOM AVAILABILITY -->
        <form class="dates" action="/" method="post">
            <div class="checkin-col">
                <label for="checkin">Check in:</label>
                <input type="date" id="checkin" name="checkin" min="2024-01-01" max="2024-01-31">
            </div>
            <div class="checkout-col">
                <label for="checkout">Check out:</label>
                <input type="date" id="checkout" name="checkout" min="2024-01-01" max="2024-01-31">
            </div>
            <input type="submit" id="availability" name="availability" value="Check availability">
        </form>
        <!-- IF NO DATES ARE PICKED, ALL ROOMS SHOW. IF DATES ARE PICKED ONLY AVAILABLE ROOMS SHOW -->
        <div class="rooms-wrapper">
            <?php require_once __DIR__ . '/availability.php'; ?>
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
</body>

</html>