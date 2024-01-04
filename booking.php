<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/hotelFunctions.php';
$db = connect('hotel.db');

//Get the chosen room's id
$roomID = (int) $_GET['room_id'];

//Array for error messages
$errors = [];

//Validate form
if (isset($_POST['book_room'])) {
    $guestName = htmlspecialchars($_POST['fullname']);
    $guestEmail = htmlspecialchars($_POST['email']);
    $guestCode = htmlspecialchars($_POST['transfer_code']);

    //Confirm that dates are picked
    if (isset($_SESSION['checkin'])) {
        $checkIn = $_SESSION['checkin'];
        $checkOut = $_SESSION['checkout'];
    } else {
        $errors[] = "You must choose dates";
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

    // Validate transfer code
    if (empty($guestCode)) {
        $errors[] = "Transfer code is required.";
    } /*else {
        // Check transfer code against database (pseudo-code)

    }*/

    // If errors = 0, proceed with booking
    if (empty($errors)) {

        //Using transactions to ensure the right guest id is used
        $db->beginTransaction();

        //Insert guest information into the Guest table
        $statement = "INSERT INTO Guests (full_name, email, transfer_code) VALUES (?, ?, ?)";
        $stmt = $db->prepare($statement);
        $stmt->bindParam(1, $guestName, PDO::PARAM_STR);
        $stmt->bindParam(2, $guestEmail, PDO::PARAM_STR);
        $stmt->bindParam(3, $guestCode, PDO::PARAM_INT);
        $stmt->execute();

        // Retrieve the last inserted ID (guest_id)
        $guest_id = $db->lastInsertId();

        // Insert booking information into the Reservations table
        $statement = "INSERT INTO Reservations (room_id, guest_id, arrival_date, departure_date) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($statement);
        $stmt->bindParam(1, $roomID, PDO::PARAM_INT);
        $stmt->bindParam(2, $guest_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $checkIn, PDO::PARAM_STR);
        $stmt->bindParam(4, $checkOut, PDO::PARAM_STR);
        $stmt->execute();

        $db->commit();  // Commit the transaction
        echo "Thank you for choosing Rainbow Reef Retrat! Enjoy your stay";
        session_unset();
    }
}
?>

<!-- ERROR MESSAGE(S) -->
<div class="error">
    <?php
    if (isset($errors)) {
        foreach ($errors as $error) { ?>
            <li><?php echo $error; ?></li>
    <?php }
    }
    ?>
</div>

<!-- FORM FOR BOOKING -->

<form class="book" action="" method="post">
    <h4>Name</h4>
    <div class="guesttname">
        <input type="text" id="fullname" name="fullname" placeholder="Full name" value="<?php echo isset($guestName) ? $guestName : ''; ?>">
    </div>
    <h4>Contact information</h4>
    <div class="guestcontact">
        <input type="text" id="email" name="email" placeholder="E-mail" value="<?php echo isset($guestEmail) ? $guestEmail : ''; ?>">
    </div>
    <h4>Activity</h4>
    <div class=" features">
        <?php
        //Generate list of features
        $statement = $db->query("SELECT * FROM Features");
        $features = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($features as $feature) { ?>
            <div class="feature">
                <input type="checkbox" id="<?php echo $feature['feature_name']; ?>" name="feature" value="<?php echo $feature['feature_name']; ?>">
                <label for="<?php echo $feature['feature_name']; ?>"><?php echo $feature['feature_name']; ?></label>
            </div>
        <?php } ?>
    </div>


    <h4>Confirmation</h4>
    <?php //Total cost
    foreach ($roomInfo as $rooms) {
        if ($rooms['id'] === $roomId) {
            $roomCost = $rooms['price_per_day'];
        }
    }
    echo "Room: $" . $roomCost;
    ?>


    <div class="confirmation">
        <input type="text" id="transfercode" name="transfer_code" placeholder="Transfer code" value="<?php echo isset($guestCode) ? $guestCode : ''; ?>">
        <input type="submit" id="book_room" name="book_room" value="Book room">
    </div>
</form>