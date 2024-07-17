<?php

namespace Tests\Integration\Application\Controllers\Reminder;

use PHPUnit\Framework\TestCase;
use Src\Application\Commands\DeleteReminder;
use Src\Application\Http\Controller\Reminder\DeleteReminderController;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Application\Enviroment\Env;
use Src\Infra\Enviroment\DotEnvAdapter;

class DeleteReminderControllerTest extends TestCase
{
    private Env $fakeEnv;
    private PDOConnection $connection;
    private DatabaseReminderRepository $reminderRepository;
    private DeleteReminderController $controller;

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
        $this->reminderRepository = new DatabaseReminderRepository($this->connection);

        $deleteReminder = new DeleteReminder($this->reminderRepository);
        $this->controller = new DeleteReminderController($deleteReminder);
    }

    public function testSuccessfulReminderDeletion()
    {
        $reminderId = $this->createTestReminder();

        $params = ['id' => $reminderId];
        $body = [];
        $response = $this->controller->handle($params, $body);

        $this->assertEquals(200, $response->status);
        $this->assertIsArray($response->data);
        $this->assertArrayHasKey('message', $response->data);
        $this->assertEquals('Reminder deleted with success', $response->data['message']);
    }

    public function testNotFoundReminderDeletion()
    {
        $params = ['id' => 'non_existing_id'];
        $body = [];

        $response = $this->controller->handle($params, $body);

        $this->assertEquals(404, $response->status);
        $this->assertIsArray($response->data);
        $this->assertArrayHasKey('error', $response->data);
        $this->assertEquals('Reminder not found', $response->data['error']);
    }

    private function createTestReminder(): string
    {
        $query = "INSERT INTO reminders (originalMessage, processedMessage, date, characterId, `send`, createdAt) 
                  VALUES ('Test reminder', 'Processed reminder', NOW(), '1', '0', NOW())";
        
        $this->connection->query($query);
        
        return $this->connection->lastInsertId();
    }
}
