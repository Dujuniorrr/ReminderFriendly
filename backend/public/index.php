<?php

use Src\Application\Commands\CreateReminder;
use Src\Application\Commands\DeleteReminder;
use Src\Application\Commands\ListCharacters;
use Src\Application\Commands\ListReminders;
use Src\Application\Commands\ListRemindersByMonth;
use Src\Application\Commands\SendReminder;
use Src\Application\Http\Controller\Character\ListCharactersController;
use Src\Application\Http\Controller\Reminder\CreateReminderController;
use Src\Application\Http\Controller\Reminder\DeleteReminderController;
use Src\Application\Http\Controller\Reminder\ListRemindersByMonthController;
use Src\Application\Http\Controller\Reminder\ListRemindersController;
use Src\Application\Http\Controller\Reminder\SendReminderController;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Gateway\OpenAINLPGateway;
use Src\Infra\Gateway\ZAPIMessageSenderGateway;
use Src\Infra\Http\Request\CreateReminderValidator;
use Src\Infra\Http\Request\ListCharactersValidator;
use Src\Infra\Http\Request\ListRemindersByMonthValidator;
use Src\Infra\Http\Request\ListRemindersValidator;
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

$httpServer->register('get', '/api/character', function () use ($characterRepository) {
    $command = new ListCharacters($characterRepository);
    $validator = new ListCharactersValidator();
    return [new ListCharactersController($command, $validator), 'handle'];
});

$httpServer->register('delete', '/api/reminder/{id}', function () use ($reminderRepository) {
    $command = new DeleteReminder($reminderRepository);
    return [new DeleteReminderController($command), 'handle'];
});

$httpServer->register('get', '/api/reminder', function () use ($reminderRepository) {
    $command = new ListReminders($reminderRepository);
    $validator = new ListRemindersValidator();
    return [new ListRemindersController($command, $validator), 'handle'];
});

$httpServer->register('get', '/api/reminder/by-month/{month}/{year}', function () use ($reminderRepository) {
    $command = new ListRemindersByMonth($reminderRepository);
    $validator = new ListRemindersByMonthValidator();
    return [new ListRemindersByMonthController($command, $validator), 'handle'];
});

$httpServer->register('post', '/api/reminder', function () use (
    $httpClient,
    $env,
    $characterRepository,
    $reminderRepository,
) {
    $nlpGateway = new OpenAINLPGateway($httpClient, $env);
    $validator = new CreateReminderValidator();
    $command = new CreateReminder($characterRepository, $reminderRepository, $nlpGateway);
    return [new CreateReminderController($validator, $command), 'handle'];
});

$httpServer->register('put', '/api/reminder/{id}/send', function () use (
    $reminderRepository,
    $httpClient,
    $env,
) {
    $messageSenderGateway = new ZAPIMessageSenderGateway($httpClient, $env);
    $command = new SendReminder($reminderRepository, $messageSenderGateway);
    return [new SendReminderController($command), 'handle'];
});


$httpServer->run();
