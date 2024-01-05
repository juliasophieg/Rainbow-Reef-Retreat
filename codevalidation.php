<?php

declare(strict_types=1);

//require_once __DIR__ . '/totalcost.php';

require 'vendor/autoload.php';

/*<form action="/codevalidation.php" method="post">

    <input type="text" id="transfer_code" name="transfer_code" placeholder="Transfer code">
    <input type="text" id="total_cost" name="total_cost" placeholder="Total Cost">
    <input type="submit" id="check_code" name="check_code" value="Check code">
    </div>
</form>*/


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


if (isset($_POST['book_room'])) {
    $baseUrl = 'https://www.yrgopelag.se/centralbank';
    $transferUrl = $baseUrl . '/transferCode';
    $transferCode = $_POST['transfer_code']; //Transfer code given by guest
    $totalCost = $totalRoomCost; //Total cost for room and feature

    $client = new Client();

    try {
        $response = $client->request('POST', $transferUrl, [
            'form_params' => [
                'transferCode' => $transferCode,
                //               'totalcost' => $totalCost
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
            echo "Transfer ok";
        } else {
            echo "Transfer failed";
        }
    } catch (RequestException $e) {
        // Handle exceptions
        echo "Error: " . $e->getMessage();
    }
}
