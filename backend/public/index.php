<?php

use Src\Application\Http\Controller\Reminder\GetReminderController;
use Src\Infra\Http\SlimServerAdapter;

require __DIR__ . '/../vendor/autoload.php';

$httpServer = new SlimServerAdapter();

$httpServer->register('get', '/api/{id}', function () {
    return [new GetReminderController(), 'handle'];
});

$httpServer->run();
