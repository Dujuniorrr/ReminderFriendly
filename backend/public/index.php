<?php

use Src\Application\Commands\CreateReminder;
use Src\Application\Http\Controller\Reminder\CreateReminderController;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Gateway\OpenAINLPGateway;
use Src\Infra\Http\Request\CreateReminderValidator;
use Src\Infra\Http\Server\GuzzleHTTPClient;
use Src\Infra\Http\Server\SlimServerAdapter;
use Src\Infra\Repository\DatabaseCharacterRepository;
use Src\Infra\Repository\DatabaseReminderRepository;

date_default_timezone_set("America/Sao_Paulo");
require __DIR__ . '/../vendor/autoload.php';

$httpServer = new SlimServerAdapter();
$env = new DotEnvAdapter();
$connection = new PDOConnection($env);
$httpClient = new GuzzleHTTPClient();
$reminderRepository = new DatabaseReminderRepository($connection);
$characterRepository = new DatabaseCharacterRepository($connection);

$httpServer->register('post', '/api/reminder', function () use (
    $httpClient, $env, $characterRepository, $reminderRepository,
) {
    $nlpGateway = new OpenAINLPGateway($httpClient, $env);
    $validator = new CreateReminderValidator();
    $useCase = new CreateReminder($characterRepository, $reminderRepository, $nlpGateway);
    
    return [ new CreateReminderController($validator, $useCase), 'handle' ];
});

$httpServer->run();
