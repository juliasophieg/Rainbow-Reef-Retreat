<?php

declare(strict_types=1);

require_once __DIR__ . '/hotelFunctions.php';
$db = connect('hotel.db');

//If dates are picked
if (isset($checkIn) && isset($checkOut)) {

    // Get available rooms function
    $availableRooms = getAvailableRooms($checkIn, $checkOut);

    // Display available rooms
    if (!empty($availableRooms)) {

        //Get information about all rooms
        require_once __DIR__ . '/rooms.php';

        //Generate room cards for available rooms
        foreach ($availableRooms as $availableRoom) {

            foreach ($roomInfo as $room) :
                if ($availableRoom === $room['id']) { ?>
                    <a href="room.php?room_id=<?= $room['id']; ?>">
                        <div class="room-card">
                            <img src="<?= $room['room_img'] ?>" style="width:100%">
                            <div class="room-card-text">
                                <h3><?= $room['name'] ?></h3>
                                <div class="room-title">
                                    <p><?= ucfirst($room['type']) ?></p>
                                    <h3>$<?= $room['price_per_day'] ?></h3>
                                </div>
                            </div>
                        </div>
                    </a>
        <?php }
            endforeach;
        };
    } else { ?>
        <p>Unfortunately there are no rooms available for the selected dates. Please try other dates.</p>
<?php }
}
