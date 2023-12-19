<?php

require_once __DIR__ . '/hotelFunctions.php';

$db = connect('hotel.db');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rainbow Reef Retreat</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&family=Roboto:ital,wght@0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
</head>

<body>
    <main>


        <!-- PRESENT INFORMATION ABOUT CHOSEN ROOM -->

        <?php
        if (isset($_GET['checkin']) && isset($_GET['checkout'])) {
            echo "Arrival date: " . $_GET['checkin'] . "  |  Departure date: " . $_GET['checkout'];
        }

        $roomID = $_GET['room_id'];

        $statement = $db->query("SELECT * FROM Rooms WHERE id = '$roomID'");

        $room = $statement->fetchAll(PDO::FETCH_ASSOC); ?>

        <div class="room-card">
            <img src="<?php echo $room[0]['img_src'] ?>" style="width:100%">
            <div class="room-card-text">
                <div class="room-title">
                    <h3><?php echo $room[0]['room_name'] ?></h3>
                    <h3>$<?php echo $room[0]['price_per_day'] ?></h3>
                </div>
                <p><?php echo ucfirst($room[0]['room_type']) ?></p>
            </div>
        </div>

        <!-- FORM FOR BOOKING -->


        <form class="book" action="/" method="post">
            <h4>Name</h4>
            <div class="guesttname">
                <input type="text" id="fullname" name="fullname" placeholder="Full name">
            </div>
            <h4>Contact information</h4>
            <div class="guestcontact">
                <input type="text" id="email" name="email" placeholder="E-mail">
            </div>
            <h4>Activity</h4>
            <div class="guestfeature">
                <select name="features" id="features">
                    <option value="">No acitivity chosen</option>
                    <?php
                    $statement = $db->query("SELECT * FROM Features");
                    $features = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($features as $feature) { ?>
                        <option value="<?php echo $feature['id'] ?>"><?php echo $feature['feature_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <h4>Confirmation</h4>
            <div class="confirmation">
                <input type="text" id="transfercode" name="transfercode" placeholder="Transfer code">


                <input type="submit" id="bookroom" name="bookroom" value="Book room">
            </div>

        </form>

    </main>
</body>

</html>