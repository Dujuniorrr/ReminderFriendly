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

class CreateReminderTest extends TestCase
{
    public function testSuccessDate()
    {
        $env = new DotEnvAdapter();
        $connection = new PDOConnection($env);
        $httpClient = new GuzzleHTTPClient();
        $reminderRepository = new DatabaseReminderRepository($connection);
        $characterRepository = new DatabaseCharacterRepository($connection);
        $nlpGateway = new OpenAINLPGateway($httpClient, $env);
        $useCase = new CreateReminder($characterRepository, $reminderRepository, $nlpGateway);

        // Caso de teste com sucesso na interpretação da data
        $output = $useCase->execute(new CreateReminderInput(
            'Dançar na chuva quinta feira as 3 da tarde',
            "1"
        ));

        $this->assertEquals("2024-07-18 15:00:00", $output->date);
        $this->assertIsString($output->processedMessage);
        $this->assertEquals(false, $output->send);
        $this->assertEquals("1", $output->characterId);
    }

    public function testNoTaskError()
    {
        $this->expectException(Exception::class);

        $env = new DotEnvAdapter();
        $connection = new PDOConnection($env);
        $httpClient = new GuzzleHTTPClient();
        $reminderRepository = new DatabaseReminderRepository($connection);
        $characterRepository = new DatabaseCharacterRepository($connection);
        $nlpGateway = new OpenAINLPGateway($httpClient, $env);
        $useCase = new CreateReminder($characterRepository, $reminderRepository, $nlpGateway);

        // Caso de teste onde não há menção explícita de uma tarefa 
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

        // Caso de teste onde não há menção explícita do horario 
        $output = $useCase->execute(new CreateReminderInput(
            'Lembrar de algo amanhã',
            "1"
        ));

    }


}
