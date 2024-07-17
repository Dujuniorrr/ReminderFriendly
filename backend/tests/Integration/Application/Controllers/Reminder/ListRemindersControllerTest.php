<?php

namespace Tests\Integration\Application\Controllers\Reminder;

use PHPUnit\Framework\TestCase;
use Src\Application\Commands\ListReminders;
use Src\Application\Http\Controller\Reminder\ListRemindersController;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Application\Enviroment\Env;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Http\Request\ListRemindersValidator;

class ListRemindersControllerTest extends TestCase
{
    private Env $fakeEnv;
    private PDOConnection $connection;
    private DatabaseReminderRepository $reminderRepository;
    private ListRemindersController $controller;

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

        $listReminders = new ListReminders($this->reminderRepository);
        $validator = new ListRemindersValidator();

        $this->controller = new ListRemindersController($listReminders, $validator);
    }

    public function testSuccessfulReminderList()
    {
        $params = [
            'page' => 1,
            'limit' => 20,
            'status' => 'notSend',
        ];
        $body = [];

        $response = $this->controller->handle($params, $body);
        $this->assertEquals(200, $response->status);
        $this->assertIsArray($response->data);
        $this->assertArrayHasKey('reminders', $response->data);
        $this->assertArrayHasKey('total', $response->data);
        $this->assertArrayHasKey('perPage', $response->data);
        $this->assertArrayHasKey('currentPage', $response->data);
    }

    public function testInvalidStatus()
    {
        $params = [
            'page' => 1,
            'limit' => 20,
            'status' => 'invalidStatus',
        ];
        $body = [];

        $response = $this->controller->handle($params, $body);
        $this->assertEquals(422, $response->status);
        $this->assertIsArray($response->data);
        $this->assertArrayHasKey('errors', $response->data);
        $this->assertArrayHasKey('status', $response->data['errors']);
    }
}
