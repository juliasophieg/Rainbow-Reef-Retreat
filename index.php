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
        <div class="rooms-wrapper">
            <div class="room-card">
                <img src="/assets/images/lagoonloft.jpeg" style="width:100%">
                <div class="room-card-text">
                    <div class="room-title">
                        <h3>Lagoon Loft</h3>
                        <h3>$8</h3>
                    </div>
                    <p>Single room</p>
                </div>
            </div>
            <div class="room-card">
                <img src="/assets/images/turtleterrace.jpeg" style="width:100%">
                <div class="room-card-text">
                    <div class="room-title">
                        <h3>Turtle Terrace</h3>
                        <h3>$12</h3>
                    </div>
                    <p>Double room</p>
                </div>
            </div>
            <div class="room-card">
                <img src="/assets/images/coralsuite.jpeg" style="width:100%">
                <div class="room-card-text">
                    <div class="room-title">
                        <h3>Coral Suite</h3>
                        <h3>$16</h3>
                    </div>
                    <p>Suite</p>
                </div>
            </div>
        </div>

    </main>
</body>

</html>