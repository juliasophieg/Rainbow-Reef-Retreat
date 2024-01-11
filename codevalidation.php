<?php

declare(strict_types=1);

require_once __DIR__ . '/totalcost.php'; //Get $totalCost (room + feature)

require 'vendor/autoload.php';


use GuzzleHttp\Client;


if (isset($_POST['book_room'])) {
    $baseUrl = 'https://www.yrgopelag.se/centralbank';
    $transferUrl = $baseUrl . '/transferCode';
    $_SESSION['transferCode'] = $_POST['transfer_code']; //Transfer code given by guest
    $transferCode = $_SESSION['transferCode'];

    $client = new Client();

    $response = $client->request('POST', $transferUrl, [
        'form_params' => [
            'transferCode' => $transferCode,
            'totalcost' => $totalCost
        ],
    ]);

    $responseData = json_decode($response->getBody()->getContents(), true);
    if (isset($responseData['amount'])) {
        $amount = $responseData['amount'];
    }
    if (isset($responseData['error'])) {
        $error = $responseData['error'];
    } else {
        $error = null;
    }

    if (!isset($error) && $amount == $totalCost) {
        $isValid = true;
        require_once __DIR__ . '/transfer.php';
    } else {
        $isValid = false;
    }
}
