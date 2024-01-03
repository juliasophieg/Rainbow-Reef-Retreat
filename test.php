<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();


$response = $client->get('https://reqres.in/api/users?page=2');

$body = $response->getBody()->getContents();

$data = json_decode($body, true);

print_r($data);
