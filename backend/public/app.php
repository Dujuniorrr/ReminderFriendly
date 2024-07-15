<?php

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = AppFactory::create();

$app->add(function ($request, $handler) use ($app) {
    $response = $handler->handle($request);

    $response = $response
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8000')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

    return $response;
});

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->addErrorMiddleware(true, true, true);

return $app;
