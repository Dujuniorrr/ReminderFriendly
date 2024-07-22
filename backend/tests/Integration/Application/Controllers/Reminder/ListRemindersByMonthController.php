<?php

namespace Tests\Integration\Application\Controllers\Reminder;

use PHPUnit\Framework\TestCase;
use Src\Application\Commands\ListRemindersByMonth;
use Src\Application\Http\Controller\Reminder\ListRemindersByMonthController;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Application\Enviroment\Env;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Infra\Http\Request\ListRemindersByMonthValidator;

class ListRemindersByMonthControllerTest extends TestCase
{
    private Env $fakeEnv;
    private PDOConnection $connection;
    private DatabaseReminderRepository $reminderRepository;
    private ListRemindersByMonthController $controller;

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

        $listReminders = new ListRemindersByMonth($this->reminderRepository);
        $validator = new ListRemindersByMonthValidator();

        $this->controller = new ListRemindersByMonthController($listReminders, $validator);
    }

    public function testSuccessfulReminderList()
    {
        $params = [
            'month' => date('n'),
            'year' => date('Y'),
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

    public function testInvalidMonth()
    {
        $params = [
            'month' => 13,

        ];
        $body = [];

        $response = $this->controller->handle($params, $body);
        $this->assertEquals(422, $response->status);
        $this->assertIsArray($response->data);
        $this->assertArrayHasKey('errors', $response->data);
        $this->assertArrayHasKey('month', $response->data['errors']);
    }

    public function testInvalidYear()
    {
        $params = [
            'year' => 2023 * 23,
        ];
        $body = [];

        $response = $this->controller->handle($params, $body);
        $this->assertEquals(422, $response->status);
        $this->assertIsArray($response->data);
        $this->assertArrayHasKey('errors', $response->data);
        $this->assertArrayHasKey('month', $response->data['errors']);
    }
}
