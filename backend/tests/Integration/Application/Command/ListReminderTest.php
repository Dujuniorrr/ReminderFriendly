<?php

namespace Tests\Integration\Application\Command;

use Exception;
use PHPUnit\Framework\TestCase;
use Src\Application\Enviroment\Env;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;
use Src\Application\Commands\ListReminders;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Application\DTO\ListReminders\ListRemindersInput;
use Src\Application\DTO\ListReminders\ListRemindersOutput;

class ListReminderTest extends TestCase
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

        $command = new ListReminders($reminderRepository);

        $input = new ListRemindersInput(1, 20, 'notSend');

        list($output, $total) = $command->execute($input);

        $this->assertIsArray($output);

        $this->assertCount(20, $output);

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
        $this->expectException(Exception::class);
        $connection = new PDOConnection($this->fakeEnv);
        $reminderRepository = new DatabaseReminderRepository($connection);

        $command = new ListReminders($reminderRepository);

        $input = new ListRemindersInput(1, 20, 'sjsdj');

        $command->execute($input);
    }
}
