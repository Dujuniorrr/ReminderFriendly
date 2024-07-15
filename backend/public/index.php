<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = require __DIR__ . '/app.php';

$app->get('/api/hello', function (Request $request, Response $response, $args) {
    $data = ['msg' => 'test'];

    $response->getBody()->write(json_encode($data));
   
    return $response
    ->withHeader('Content-Type', 'application/json')
    ->withStatus(200);
});

$app->run();
