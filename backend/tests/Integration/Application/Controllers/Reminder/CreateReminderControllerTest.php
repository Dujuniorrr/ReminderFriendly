<?php

namespace Tests\Integration\Application\Controllers\Reminder;

use PHPUnit\Framework\TestCase;
use Src\Application\Commands\CreateReminder;
use Src\Application\Http\Controller\Reminder\CreateReminderController;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Repository\DatabaseCharacterRepository;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Infra\Gateway\OpenAINLPGateway;
use Src\Application\Enviroment\Env;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Application\Exceptions\NLPErrorException;
use Src\Infra\Http\Request\CreateReminderValidator;
use Src\Infra\Http\Server\GuzzleHTTPClient;

class CreateReminderControllerTest extends TestCase
{
    private Env $fakeEnv;
    private PDOConnection $connection;
    private DatabaseCharacterRepository $characterRepository;
    private DatabaseReminderRepository $reminderRepository;
    private CreateReminderController $controller;

    public function setUp(): void
    {
        $this->fakeEnv = new class extends DotEnvAdapter
        {
            public function get(string $key, mixed $default = null): mixed
            {
                $val = parent::get($key, $default);
                return ($key === 'ENVIROMENT') ? 'local' : $val;
            }
        };

        $this->connection = new PDOConnection($this->fakeEnv);
        $this->characterRepository = new DatabaseCharacterRepository($this->connection);
        $this->reminderRepository = new DatabaseReminderRepository($this->connection);

        $httpClient = new GuzzleHTTPClient();
        $nlpGateway = new OpenAINLPGateway($httpClient, $this->fakeEnv);
        $validator = new  CreateReminderValidator();

        $createReminder = new CreateReminder($this->characterRepository, $this->reminderRepository, $nlpGateway);
        $this->controller = new CreateReminderController($validator, $createReminder);
    }

    public function testSuccessfulReminderCreation()
    {
        $params = [];
        $body = [
            'content' => 'Viajar dia 23 deste mês as 23',
            'characterId' => '1', 
        ];

        $response = $this->controller->handle($params, $body);
        $this->assertEquals(200, $response->status);
        $this->assertIsArray($response->data);
        $this->assertEquals('2024-07-23 23:00:00', $response->data['date']);
        $this->assertArrayHasKey('id', $response->data);
    }

    public function testDateError()
    {
        $params = [];
        $body = [
            'content' => 'viajar',
            'characterId' => '1',
        ];

        $response = $this->controller->handle($params, $body);
        $this->assertEquals(422, $response->status);
        $this->assertIsArray($response->data);
        $this->assertArrayHasKey('content_error', $response->data);
    }

    public function testTaskError()
    {
        $params = [];
        $body = [
            'content' => 'sjfjdf as 3 da tarde',
            'characterId' => '1',
        ];

        $response =  $this->controller->handle($params, $body);
        $this->assertEquals(422, $response->status);
        $this->assertArrayHasKey('content_error', $response->data);
    }
}
