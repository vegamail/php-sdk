<?php

require_once __DIR__.'/../vendor/autoload.php';

use Vegamail\Client;

// you retrieve theses app Id and app Token in your Vegamail dashboard
$client = new Client('YOUR-APP-IP', 'YOUR-APP-TOKEN');

// Send an email
$email = $client->send([
    'template' => 'welcome',
    'to' => ['john@doe.com'],
    'data' => ['firstname' => 'John', 'lastname' => 'Doe', 'confirmUrl' => 'https://john.doe.com/confirm/xyz'],
    //'cc' => ['john@doe.com'],
    //'bcc' => ['john@doe.com'],
    //'tags' => ['welcome'],
]);

var_dump($email->getBody());
