<?php
session_start();
require_once __DIR__ . '/hotelFunctions.php';
require_once __DIR__ . '/rooms.php';

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
        //Selected dates
        if (isset($_SESSION['checkin'])) {
            $checkIn = $_SESSION['checkin'];
            $checkOut = $_SESSION['checkout'];
            echo "Arrival date: " . $checkIn . "  |  Departure date: " . $checkOut;
        }

        //Get the chosen room's id
        $roomID = (int) $_GET['room_id'];

        //Get info about chosen room from the rooms array
        foreach ($roomInfo as $rooms) {
            if ($rooms['id'] === $roomID) {
                echo $rooms['name'];
            }
        } ?>


        <!-- FORM FOR BOOKING -->


        <form class="book" action="booking.php?room_id=<?php echo $roomID; ?>&checkin=<?php echo $checkIn; ?>&checkout=<?php echo $checkOut; ?>" method="post">
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
                    //Generate list of features
                    $statement = $db->query("SELECT * FROM Features");
                    $features = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($features as $feature) { ?>
                        <option value="<?php echo $feature['id'] ?>"><?php echo $feature['feature_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <h4>Confirmation</h4>
            <div class="confirmation">
                <input type="text" id="transfercode" name="transfer_code" placeholder="Transfer code">

                <input type="submit" id="book_room" name="book_room" value="Book room">
            </div>
        </form>

    </main>
</body>

</html>