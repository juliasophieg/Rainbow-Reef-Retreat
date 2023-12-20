<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rainbow Reef Retreat</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&family=Roboto:ital,wght@0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
</head>

<!--CHECK ROOM AVAILABILITY -->

<body>
    <main>
        <form class="dates" action="/" method="post">
            <label for="checkin">Check in:</label>
            <input type="date" id="checkin" name="checkin" min="2024-01-01" max="2024-01-31">
            <label for="checkout">Check out:</label>
            <input type="date" id="checkout" name="checkout" min="2024-01-01" max="2024-01-31">

            <input type="submit" id="availability" name="availability" value="Check availability">
        </form>
        <!-- IF NO DATES ARE PICKED, ALL ROOMS SHOW. IF DATES ARE PICKED ONLY AVAILABLE ROOMS SHOW -->
        <div class="rooms-wrapper">
            <?php require_once __DIR__ . '/availability.php'; ?>
        </div>

    </main>
</body>

</html>