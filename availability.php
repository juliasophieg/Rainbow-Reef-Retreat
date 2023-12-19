<?php

declare(strict_types=1);

require_once __DIR__ . '/hotelFunctions.php';

$db = connect('hotel.db');

//Check which rooms that are available on selected dates
if (isset($_POST['availability'])) {
    $checkIn = $_POST['checkin'];
    $checkOut = $_POST['checkout'];

    $statement = $db->query("SELECT *
        FROM Rooms
        INNER JOIN Reservations ON Rooms.id = Reservations.room_id
        WHERE Reservations.arrival_date IS NOT '$checkIn'");

    $rooms = $statement->fetchAll(PDO::FETCH_ASSOC);

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
    $statement = $db->query("SELECT * FROM Rooms");

    $rooms = $statement->fetchAll(PDO::FETCH_ASSOC);

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