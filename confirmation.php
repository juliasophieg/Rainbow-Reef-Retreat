<?php

declare(strict_types=1);

header('Content-Type: application/json');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/hotelFunctions.php';
$db = connect('hotel.db');

$checkIn = $_SESSION['checkin'];
$checkOut = $_SESSION['checkout'];
$selectedFeatures = $_SESSION['features'];
$totalCost = $_SESSION['total_cost'];


$bookingConfirmation = [
    'island' => "Rainbow Reef",
    'hotel' => "Rainbow Reef Retreat",
    'arrival_date' => $checkIn,
    'departure_date' => $checkOut,
    'total_cost' => $totalCost,
    'stars' => 2,
    'features' => [],
    'additional_info' => "Thank you for choosing Rainbow Reef Retreat! We hope you will enjoy your stay, gain a tan and leave well rested.",
];


// Loop through each selected feature and add it to the 'features' array
foreach ($selectedFeatures as $selectedFeature) {
    $statement = $db->prepare("SELECT * FROM Features WHERE feature_name = :selectedFeature");
    $statement->execute(['selectedFeature' => $selectedFeature]);

    $feature = $statement->fetch(PDO::FETCH_ASSOC);

    $bookingConfirmation['features'][] = [
        'name' => $feature['feature_name'],
        'cost' => $feature['extra_cost']
    ];
}

echo json_encode($bookingConfirmation, JSON_PRETTY_PRINT);
