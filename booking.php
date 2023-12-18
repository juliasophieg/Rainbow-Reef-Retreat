<?php

declare(strict_types=1);

require_once __DIR__ . '/hotelFunctions.php';

$db = connect('hotel.db');

if (isset($_POST['book'])) {
    $query = "INSERT INTO Reservations (room_id, guest_id, arrival_date, departure_date, total_cost, transfer_code, feature_id) VALUES ('$checkIn', '$checkOut')";
    $stmt = $db->prepare($query);
    $stmt->execute();
}
