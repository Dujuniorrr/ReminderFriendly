<?php

namespace Tests\Integration\Application\Command;

use Exception;
use PHPUnit\Framework\TestCase;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Gateway\OpenAINLPGateway;
use Src\Infra\Http\Server\GuzzleHTTPClient;
use Src\Application\Commands\CreateReminder;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Infra\Repository\DatabaseCharacterRepository;
use Src\Application\DTO\CreateReminder\CreateReminderInput;
use Src\Application\Exceptions\NLPErrorException;

class CreateReminderTest extends TestCase
{
    public function testSuccessReminderCreated()
    {
        $env = new DotEnvAdapter();
        $connection = new PDOConnection($env);
        $httpClient = new GuzzleHTTPClient();
        $reminderRepository = new DatabaseReminderRepository($connection);
        $characterRepository = new DatabaseCharacterRepository($connection);
        $nlpGateway = new OpenAINLPGateway($httpClient, $env);
        $useCase = new CreateReminder($characterRepository, $reminderRepository, $nlpGateway);

        $output = $useCase->execute(new CreateReminderInput(
            'Dançar na chuva quinta feira as 3 da tarde',
            "1"
        ));

        $this->assertEquals("2024-07-25 15:00:00", $output->date);
        $this->assertIsString($output->processedMessage);
        $this->assertEquals(false, $output->send);
        $this->assertEquals("1", $output->characterId);
    }

    public function testNoTaskError()
    {
        $this->expectException(NLPErrorException::class);

        $env = new DotEnvAdapter();
        $connection = new PDOConnection($env);
        $httpClient = new GuzzleHTTPClient();
        $reminderRepository = new DatabaseReminderRepository($connection);
        $characterRepository = new DatabaseCharacterRepository($connection);
        $nlpGateway = new OpenAINLPGateway($httpClient, $env);
        $useCase = new CreateReminder($characterRepository, $reminderRepository, $nlpGateway);

        $output = $useCase->execute(new CreateReminderInput(
            'Lembrar de algo',
            "1"
        ));

    }

    public function testInvalidDateError()
    {
        $this->expectException(Exception::class);

        $env = new DotEnvAdapter();
        $connection = new PDOConnection($env);
        $httpClient = new GuzzleHTTPClient();
        $reminderRepository = new DatabaseReminderRepository($connection);
        $characterRepository = new DatabaseCharacterRepository($connection);
        $nlpGateway = new OpenAINLPGateway($httpClient, $env);
        $useCase = new CreateReminder($characterRepository, $reminderRepository, $nlpGateway);

        $output = $useCase->execute(new CreateReminderInput(
            'Lembrar de algo amanhã',
            "1"
        ));

    }


}
