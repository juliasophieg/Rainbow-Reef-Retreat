<?php
/*$database = new PDO('sqlite:hotel.db');

$statement = $database->query('SELECT * FROM Rooms');

$rooms = $statement->fetchAll(PDO::FETCH_ASSOC);
echo $rooms[1]['room_name'];*/

include_once __DIR__ . '/hotelFunctions.php';

$db = connect('hotel.db');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form class="dates" action="/availability.php" method="post">
        <label for="checkin">Check in:</label>
        <input type="date" id="checkin" name="checkin" min="2024-01-01" max="2024-01-31">
        <label for="checkout">Check out:</label>
        <input type="date" id="checkout" name="checkout" min="2024-01-01" max="2024-01-31">

        <input type="submit" id="availability" name="availability" value="Check availability">
    </form>

    <?php
    //Check which rooms are available on selected dates
    $statement = $db->query('SELECT * FROM Rooms');
    $rooms = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['availability'])) {
        echo "These rooms are available:";
    } else {
        foreach ($rooms as $room) {
            echo $room['room_name'] . ", $" . $room['price_per_day'] . " per day";
            echo "<br>";
        };
    } ?>
</body>

</html>