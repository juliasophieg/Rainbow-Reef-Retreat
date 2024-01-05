<?php

declare(strict_types=1);
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
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body style="background: linear-gradient(270deg, #A1EEFF 0%, #FFD789 50%, #FFBEE1 100%);">

    <main>


        <!-- PRESENT INFORMATION ABOUT CHOSEN ROOM -->

        <?php
        //Selected dates
        if (isset($_SESSION['checkin'])) {
            $checkIn = $_SESSION['checkin'];
            $checkOut = $_SESSION['checkout'];
            echo "<br>Arrival date: " . $checkIn . "  |  Departure date: " . $checkOut;
        } ?>

        <a href="/" style="color:var(--water);">Choose dates</a>
        <?php
        //Get the chosen room's id
        $roomId = (int) $_GET['room_id'];

        //Get info about chosen room from the rooms array
        foreach ($roomInfo as $rooms) {
            if ($rooms['id'] === $roomId) {
                echo "<br>" . $rooms['name'] . "<br><br>";
            }
        }
        require_once __DIR__ . '/booking.php';
        ?>

    </main>
</body>

</html>