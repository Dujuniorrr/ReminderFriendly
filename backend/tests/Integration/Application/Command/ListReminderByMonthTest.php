<?php

namespace Tests\Integration\Application\Command;

use Exception;
use PHPUnit\Framework\TestCase;
use Src\Application\Enviroment\Env;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Application\Commands\ListReminders;
use Src\Application\Commands\ListRemindersByMonth;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Application\DTO\ListReminders\ListRemindersInput;
use Src\Application\DTO\ListReminders\ListRemindersOutput;

class ListReminderByMonthTest extends TestCase
{
    private Env $fakeEnv;

    public function setUp(): void
    {
        $this->fakeEnv = new class extends DotEnvAdapter
        {
            public function get(string $key, mixed $default = null): mixed
            {
                $val = parent::get($key, $default);
                return ($key == 'ENVIROMENT') ? 'local' : $val;
            }
        };
    }

    public function testSuccessListOfReminders()
    {
        $connection = new PDOConnection($this->fakeEnv);
        $reminderRepository = new DatabaseReminderRepository($connection);

        $command = new ListRemindersByMonth($reminderRepository);


        list($output, $total) = $command->execute(date('n'), date('Y'));

        $this->assertIsArray($output);

        $this->assertNotEmpty($output);

        foreach ($output as $item) {
            $this->assertInstanceOf(ListRemindersOutput::class, $item);
            $this->assertObjectHasProperty('id', $item);
            $this->assertObjectHasProperty('originalMessage', $item);
            $this->assertObjectHasProperty('processedMessage', $item);
            $this->assertObjectHasProperty('date', $item);
            $this->assertObjectHasProperty('createdAt', $item);
            $this->assertObjectHasProperty('characterId', $item);
            $this->assertObjectHasProperty('send', $item);
            $this->assertObjectHasProperty('name', $item);
            $this->assertObjectHasProperty('humor', $item);
            $this->assertObjectHasProperty('role', $item);
            $this->assertObjectHasProperty('ageVitality', $item);
            $this->assertObjectHasProperty('origin', $item);
            $this->assertObjectHasProperty('speechMannerisms', $item);
            $this->assertObjectHasProperty('accent', $item);
            $this->assertObjectHasProperty('archetype', $item);
            $this->assertObjectHasProperty('imagePath', $item);
        }
    }

    public function testFailedListOfReminders()
    {
        $connection = new PDOConnection($this->fakeEnv);
        $reminderRepository = new DatabaseReminderRepository($connection);

        $command = new ListRemindersByMonth($reminderRepository);

        list($output, $total) = $command->execute(13, 2024);
        $this->assertEquals($total, 0);
        $this->assertCount(0, $output);
    }
}
