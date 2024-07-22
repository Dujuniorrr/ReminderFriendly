<?php
use Src\Application\Http\Controller\Character\ListCharactersController;
use Src\Application\Http\Controller\Reminder\CreateReminderController;
use Src\Application\Http\Controller\Reminder\DeleteReminderController;
use Src\Application\Http\Controller\Reminder\ListRemindersByMonthController;
use Src\Application\Http\Controller\Reminder\ListRemindersController;
use Src\Application\Http\Controller\Reminder\SendReminderController;
use Src\Infra\Http\Server\SlimServerAdapter;

$httpServer = new SlimServerAdapter();

$httpServer->register('get', '/api/character', [ListCharactersController::class, 'handle']);

$httpServer->register('delete', '/api/reminder/{id}', [DeleteReminderController::class, 'handle']);
$httpServer->register('get', '/api/reminder', [ListRemindersController::class, 'handle']);
$httpServer->register('get', '/api/reminder/by-month/{month}/{year}', [ListRemindersByMonthController::class, 'handle']);
$httpServer->register('post', '/api/reminder',  [CreateReminderController::class, 'handle']);
$httpServer->register('put', '/api/reminder/{id}/send', [SendReminderController::class, 'handle']);

return $httpServer;