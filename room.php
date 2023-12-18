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

        //Check which rooms that are available on selected dates
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
            <div class="touristname">
                <input type="text" id="firstname" name="firstname" placeholder="First name">
                <input type="text" id="lastname" name="lastname" placeholder="Last name">
            </div>
            <h4>Contact information</h4>
            <div class="touristcontact">
                <input type="text" id="email" name="email" placeholder="E-mail">
                <input type="text" id="phone" name="phone" placeholder="Phone number">
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