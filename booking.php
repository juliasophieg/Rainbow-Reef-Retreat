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

    //Check if room is alreade booked on picked dates

    // Get available rooms
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

        foreach ($selectedFeatures as $feature) {
        }

        //Getting cost of chosen feature
        $statement = $db->query("SELECT extra_cost FROM Features where feature_name = '$feature'");
        $featureCosts = $statement->fetchAll(PDO::FETCH_ASSOC);

        $featureCost = $featureCosts[0]['extra_cost'];
    }

    // Control if transfer code is submitted
    if (empty($guestCode)) {
        $errors[] = "Transfer code is required.";
    }


    // If errors = 0, Check if transfer code is valid
    if (empty($errors)) {
        //Transfer code validation
        require_once __DIR__ . '/codevalidation.php';

        if ($isValid === false) {
            echo "The submitted transfer code is not valid. Please control the code and amount.";
        } elseif ($isValid === true) {
            //If code is valid, continue with booking process

            //Using transactions to ensure the right guest id is used
            $db->beginTransaction();

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

            $db->commit();  // Commit the transaction
            echo "Thank you for choosing Rainbow Reef Retrat! Enjoy your stay";
            session_unset();
        }
    }
}
?>

<!-- PRESENTATION -->

<!-- If any errors, display them here -->

<?php if ($errors) { ?>
    <script>
        window.onload = function() {
            // Redirect the user to the error-anchor
            window.location.href = "#error";
        };
    </script>
    <div id="error" class="error">
        <p><strong>Oh no! There seems to be an issue:</strong></p>
        <?php
        if (isset($errors)) {
            foreach ($errors as $error) { ?>
                <p><?php echo "- " . $error; ?></p>
    <?php }
        }
    }
    ?>
    </div>

    <!-- FORM FOR BOOKING -->

    <form class="book" action="" method="post">
        <div class="form-container">

            <h4>Name</h4>
            <div class="form-div">
                <input type="text" id="fullname" name="fullname" placeholder="Full name" value="<?php echo isset($guestName) ? $guestName : ''; ?>">
            </div>
            <h4>Contact information</h4>
            <div class="form-div">
                <input type="text" id="email" name="email" placeholder="E-mail" value="<?php echo isset($guestEmail) ? $guestEmail : ''; ?>">
            </div>
            <h4>Feature - optional</h4>
            <div class="features">
                <?php
                // Generate list of features
                $statement = $db->query("SELECT * FROM Features");
                $features = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($features as $feature) {
                    // Check if feature is selected in order to save the checked feature if form submit fails
                    $isChecked = false;
                    if (!empty($selectedFeatures)) {
                        if (in_array($feature['feature_name'], $selectedFeatures)) {
                            $isChecked = true;
                        }
                    }
                ?>
                    <div class="feature">
                        <input type="checkbox" id="<?= $feature['feature_name']; ?>" name="features[]" value="<?= $feature['feature_name']; ?>">
                        <label for="<?= $feature['feature_name']; ?>"><?= $feature['feature_name'] . " (+$" . $feature['extra_cost'] . ")"; ?></label>
                    </div>
                <?php } ?>
            </div>

        </div>


        <div class="form-container">
            <h4>Confirmation</h4>
            <div id="total_cost"></div>
            <div class="form-div">
                <input type="text" id="transfercode" name="transfer_code" placeholder="Transfer code" value="<?php echo isset($guestCode) ? $guestCode : ''; ?>">
                <input type="submit" id="book_room" name="book_room" value="Book room">
            </div>
        </div>

    </form>

    <?php
    require_once __DIR__ . '/totalcost.php';
    ?>