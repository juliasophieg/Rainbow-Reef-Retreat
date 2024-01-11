<?php

declare(strict_types=1);

include_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;


$url = 'https://www.yrgopelag.se/';
$depositUrl = 'https://www.yrgopelag.se/centralbank/deposit';

$client = new Client([
    'base_uri' => $url,
]);

$response = $client->request('POST', $depositUrl, [
    'form_params' => [
        'user' => 'Julia',
        'transferCode' => $transferCode,
    ],
]);

$responseData = json_decode($response->getBody()->getContents(), true);

if (isset($responseData['error'])) {
    $error = $responseData['error'];
}
if (isset($responseData['message'])) {
    $message = $responseData['message'];
}

if ($response->getStatusCode() == 200 && !isset($error)) {
    $transaction = true;
} else {
    $transaction = false;
}
