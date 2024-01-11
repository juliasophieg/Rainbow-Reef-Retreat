<?php

declare(strict_types=1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//Get the chosen room's id
$roomID = (int) $_GET['room_id'];

//Array for error messages
$errors = [];

//Validate form
if (isset($_POST['book_room'])) {
    $guestName = htmlspecialchars($_POST['fullname']);
    $guestEmail = htmlspecialchars($_POST['email']);
    $guestCode = htmlspecialchars($_POST['transfer_code']);
    $selectedFeatures = $_POST['features'] ?? [];

    //Confirm that dates are picked
    if (isset($_SESSION['checkin'])) {
        $checkIn = $_SESSION['checkin'];
        $checkOut = $_SESSION['checkout'];
    } else {
        $errors[] = "You must choose dates";
    }

    //Check if room is already booked on picked dates
    $availableRooms = getAvailableRooms($checkIn, $checkOut);
    if (!in_array($roomID, $availableRooms)) {
        $errors[] = "The room is no longer available on the chosen dates.";
    }

    // Validating name
    if (empty($guestName)) {
        $errors[] = "Please enter your full name.";
    }

    // Validating email
    if (empty($guestEmail)) {
        $errors[] = "Please enter your email.";
    } elseif (!filter_var($guestEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "The email format is invalid.";
    }

    // Process feature if selected
    if (!empty($selectedFeatures)) {

        $featureCost = 0;

        foreach ($selectedFeatures as $selectedFeature) {
            // Fetch extra_cost
            $statement = $db->prepare("SELECT * FROM Features WHERE feature_name = :selectedFeature");
            $statement->execute(['selectedFeature' => $selectedFeature]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Add the extra_cost to the total cost
                $featureCost += $result['extra_cost'];
            }
        }
    }

    // Control if transfer code is submitted
    if (empty($guestCode)) {
        $errors[] = "Transfer code is required.";
    }

    // If errors = 0, Validate transfer code
    if (empty($errors)) {
        //Transfer code validation
        require_once __DIR__ . '/codevalidation.php';

        if ($isValid === false) {
            $errors[] = "The submitted transfer code is not valid. Please control the code and amount.";
        } elseif ($isValid === true) {
            //If code is valid, continue with transfer process
            if ($transaction === false) {
                echo "Problem with transaction. Please contact your bank.";
            } elseif ($isValid === true && $transaction === true) {
                //If code is valid, continue with booking process

                $db->beginTransaction(); //Using transactions to ensure the right guest id is used

                include __DIR__ . '/totalcost.php';

                //Insert guest information into the Guest table
                $statement = "INSERT INTO Guests (full_name, email) VALUES (?, ?)";
                $stmt = $db->prepare($statement);
                $stmt->bindParam(1, $guestName, PDO::PARAM_STR);
                $stmt->bindParam(2, $guestEmail, PDO::PARAM_STR);
                $stmt->execute();

                // Retrieve the last inserted ID (guest_id)
                $guest_id = $db->lastInsertId();

                // Insert booking information into the Reservations table
                $statement = "INSERT INTO Reservations (room_id, guest_id, arrival_date, departure_date, total_cost) VALUES (?, ?, ?, ?, ?)";
                $stmt = $db->prepare($statement);
                $stmt->bindParam(1, $roomID, PDO::PARAM_INT);
                $stmt->bindParam(2, $guest_id, PDO::PARAM_INT);
                $stmt->bindParam(3, $checkIn, PDO::PARAM_STR);
                $stmt->bindParam(4, $checkOut, PDO::PARAM_STR);
                $stmt->bindParam(5, $totalCost, PDO::PARAM_INT); //KOLLA UPP!
                $stmt->execute();

                // Insert features information into the reservation_features table
                if ($selectedFeatures) {

                    // Retrieve the last inserted ID (reservations_id)
                    $reservation_id = $db->lastInsertId();

                    foreach ($selectedFeatures as $selectedFeature) {

                        $statement = $db->prepare("SELECT id FROM Features WHERE feature_name = :selectedFeature");
                        $statement->execute(['selectedFeature' => $selectedFeature]);

                        $result = $statement->fetch(PDO::FETCH_ASSOC);

                        $feature_id = $result['id'];

                        $statement = "INSERT INTO reservation_features (reservation_id, feature_id) VALUES (?, ?)";
                        $stmt = $db->prepare($statement);
                        $stmt->bindParam(1, $reservation_id, PDO::PARAM_INT);
                        $stmt->bindParam(2, $feature_id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
                // Commit the transaction
                $db->commit(); ?>
                <script>
                    window.location.href = 'confirmation.php';
                </script>
<?php
            }
        }
    }
}
?>