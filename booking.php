<?php

declare(strict_types=1);
session_start();



require_once __DIR__ . '/hotelFunctions.php';

$db = connect('hotel.db');

if (isset($_POST['book_room'])) {

    if (isset($_SESSION['checkin'])) {
        $checkIn = $_SESSION['checkin'];
        $checkOut = $_SESSION['checkout'];

        //Get the chosen room's id
        $roomID = (int) $_GET['room_id'];

        //Using transactions to ensure the right guest id is used
        $db->beginTransaction();
        $guestName = htmlspecialchars($_POST['fullname']);
        $guestEmail = htmlspecialchars($_POST['email']);
        $guestCode = htmlspecialchars($_POST['transfer_code']);

        //Insert guest information into the Guest table
        $query = "INSERT INTO Guests (full_name, email, transfer_code) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$guestName, $guestEmail, $guestCode]);

        // Retrieve the last inserted ID (guest_id)
        $guest_id = $db->lastInsertId();

        // Insert booking information into the Reservations table
        $query = "INSERT INTO Reservations (room_id, guest_id, arrival_date, departure_date) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$roomID, $guest_id, $checkIn, $checkOut]);

        $db->commit();  // Commit the transaction
        echo "Thank you for choosing Rainbow Reef Retrat! Enjoy your stay";
        session_unset();
    } else {
        echo "You must choose dates";
    }
}
