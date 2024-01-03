<?php

declare(strict_types=1);
session_start();
require_once __DIR__ . '/hotelFunctions.php';
$db = connect('hotel.db');

//If "Check Availability" is pressed
if (isset($_POST['availability'])) {

    //Store picked dates in session variables
    $_SESSION['checkin'] = $_POST['checkin'];
    $_SESSION['checkout'] = $_POST['checkout'];

    $checkIn = $_SESSION['checkin'];
    $checkOut = $_SESSION['checkout'];


    //Check which rooms are available
    // Retrieve available rooms
    $statement = $db->query("SELECT * FROM Rooms");

    $rooms = $statement->fetchAll(PDO::FETCH_ASSOC);


    //Generate room cards for available rooms
    foreach ($rooms as $room) : ?>
        <a href="room.php?room_id=<?php echo $room['id']; ?>&checkin=<?php echo $checkIn; ?>&checkout=<?php echo $checkOut; ?>">
            <div class="room-card">
                <img src="<?php echo $room['img_src'] ?>" style="width:100%">
                <div class="room-card-text">
                    <div class="room-title">
                        <h3><?php echo $room['room_name'] ?></h3>
                        <h3>$<?php echo $room['price_per_day'] ?></h3>
                    </div>
                    <p><?php echo ucfirst($room['room_type']) ?></p>
                </div>
            </div>
        </a>

    <?php endforeach;
} else {
    //Show all rooms if no dates are picked
    $statement = $db->query("SELECT * FROM Rooms");

    $rooms = $statement->fetchAll(PDO::FETCH_ASSOC);

    //Generate room cards
    foreach ($rooms as $room) : ?>
        <a href="room.php?room_id=<?php echo $room['id']; ?>">
            <div class="room-card">
                <img src="<?php echo $room['img_src'] ?>" style="width:100%">
                <div class="room-card-text">
                    <div class="room-title">
                        <h3><?php echo $room['room_name'] ?></h3>
                        <h3>$<?php echo $room['price_per_day'] ?></h3>
                    </div>
                    <p><?php echo ucfirst($room['room_type']) ?></p>
                </div>
            </div>
        </a>

<?php endforeach;
}
?>