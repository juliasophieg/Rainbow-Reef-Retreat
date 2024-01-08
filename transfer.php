<?php

declare(strict_types=1);

use GuzzleHttp\Client;

include_once __DIR__ . '/vendor/autoload.php';

$url = 'https://www.yrgopelag.se/';
$url_deposit = 'https://www.yrgopelag.se/centralbank/deposit';

$client = new Client([
    'base_uri' => $url,
]);

$response = $client->request('POST', $url_deposit, [
    'form_params' => [
        'user' => 'Julia',
        'transferCode' => $transferCode,
    ],
]);

$data = json_decode($response->getBody()->getContents(), true);

if (isset($data['error'])) {
    $error = $data['error'];
}
if (isset($data['message'])) {
    $message = $data['message'];
}

if ($response->getStatusCode() == 200 && !isset($error)) {

    require_once __DIR__ . '/booking.php';
} else {
    echo "Deposit failed";
}