<?php

declare(strict_types=1);

require_once __DIR__ . '/totalcost.php'; //Get $totalCost (room + feature)
require 'vendor/autoload.php';


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


if (isset($_POST['book_room'])) {
    $baseUrl = 'https://www.yrgopelag.se/centralbank';
    $transferUrl = $baseUrl . '/transferCode';
    $_SESSION['transferCode'] = $_POST['transfer_code']; //Transfer code given by guest
    $transferCode = $_SESSION['transferCode'];

    $client = new Client();

    try {
        $response = $client->request('POST', $transferUrl, [
            'form_params' => [
                'transferCode' => $transferCode,
                'totalcost' => $totalCost
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        if (isset($data['amount'])) {
            $amount = $data['amount'];
        }
        if (isset($data['error'])) {
            $error = $data['error'];
        } else {
            $error = null;
        }

        if ($response->getStatusCode() == 200 && !isset($error) && $amount >= $totalCost) {
            $isValid = true;
            require_once __DIR__ . '/transfer.php';
        } else {
            $isValid = false;
        }
    } catch (RequestException $e) {
        // Handle exceptions
        echo "Error: " . $e->getMessage();
    }
}