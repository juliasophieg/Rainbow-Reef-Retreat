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


    //Check which rooms are booked on selected
    $statement = $db->prepare("SELECT room_id FROM Reservations
    WHERE arrival_date BETWEEN :checkIn AND :checkOut
    OR departure_date BETWEEN :checkIn AND :checkOut;");

    $statement->execute(['checkIn' => $checkIn, 'checkOut' => $checkOut]);

    $bookedRooms = $statement->fetchAll(PDO::FETCH_COLUMN);

    // All rooms
    $allRooms = [1, 2, 3];

    // Available rooms
    $availableRooms = array_diff($allRooms, $bookedRooms);

    // Display available rooms
    if (!empty($availableRooms)) {

        //Get information about all rooms
        require_once __DIR__ . '/rooms.php';

        //Generate room cards for available rooms
        foreach ($availableRooms as $availableRoom) {

            foreach ($roomInfo as $room) :
                if ($availableRoom === $room['id']) { ?>
                    <a href="room.php?room_id=<?php echo $room['id']; ?>&checkin=<?php echo $checkIn; ?>&checkout=<?php echo $checkOut; ?>">
                        <div class="room-card">
                            <img src="<?php echo $room['room_img'] ?>" style="width:100%">
                            <div class="room-card-text">
                                <div class="room-title">
                                    <h3><?php echo $room['name'] ?></h3>
                                    <h3>$<?php echo $room['price_per_day'] ?></h3>
                                </div>
                                <p><?php echo ucfirst($room['type']) ?></p>
                            </div>
                        </div>
                    </a>

<?php }
            endforeach;
        };
    }
} else {
    echo "No rooms available for selected dates.";
}
