<?php

use DI\ContainerBuilder;
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

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        DotEnvAdapter::class => DI\autowire()->constructor(),

        PDOConnection::class => DI\autowire()->constructor(DI\get(DotEnvAdapter::class)),

        GuzzleHTTPClient::class => DI\autowire(),

        DatabaseReminderRepository::class => DI\autowire()->constructor(DI\get(PDOConnection::class)),

        DatabaseCharacterRepository::class => DI\autowire()->constructor(DI\get(PDOConnection::class)),

        ListCharactersValidator::class => DI\autowire(),

        ListRemindersValidator::class => DI\autowire(),

        ListRemindersByMonthValidator::class => DI\autowire(),

        CreateReminderValidator::class => DI\autowire(),

        ListCharacters::class => DI\autowire()->constructor(DI\get(DatabaseCharacterRepository::class)),

        DeleteReminder::class => DI\autowire()->constructor(DI\get(DatabaseReminderRepository::class)),

        ListReminders::class => DI\autowire()->constructor(DI\get(DatabaseReminderRepository::class)),

        ListRemindersByMonth::class => DI\autowire()->constructor(DI\get(DatabaseReminderRepository::class)),

        CreateReminder::class => DI\autowire()->constructor(
            DI\get(DatabaseCharacterRepository::class),
            DI\get(DatabaseReminderRepository::class),
            DI\get(OpenAINLPGateway::class)
        ),

        SendReminder::class => DI\autowire()->constructor(
            DI\get(DatabaseReminderRepository::class),
            DI\get(ZAPIMessageSenderGateway::class)
        ),

        ListCharactersController::class => DI\autowire()->constructor(
            DI\get(ListCharacters::class),
            DI\get(ListCharactersValidator::class)
        ),

        DeleteReminderController::class => DI\autowire()->constructor(DI\get(DeleteReminder::class)),

        ListRemindersController::class => DI\autowire()->constructor(
            DI\get(ListReminders::class),
            DI\get(ListRemindersValidator::class)
        ),

        ListRemindersByMonthController::class => DI\autowire()->constructor(
            DI\get(ListRemindersByMonth::class),
            DI\get(ListRemindersByMonthValidator::class)
        ),

        CreateReminderController::class => DI\autowire()->constructor(
            DI\get(CreateReminderValidator::class),
            DI\get(CreateReminder::class)
        ),

        SendReminderController::class => DI\autowire()->constructor(DI\get(SendReminder::class)),

        OpenAINLPGateway::class => DI\autowire()->constructor(
            DI\get(GuzzleHTTPClient::class),
            DI\get(DotEnvAdapter::class)
        ),

        ZAPIMessageSenderGateway::class => DI\autowire()->constructor(
            DI\get(GuzzleHTTPClient::class),
            DI\get(DotEnvAdapter::class)
        ),

        SlimServerAdapter::class => DI\autowire(),
    ]);
};
