<?php

namespace Tests\Integration\Application\Commands;

use PHPUnit\Framework\TestCase;
use Src\Application\Commands\DeleteReminder;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Domain\Reminder;
use Src\Domain\Character;
use Src\Application\Exceptions\NotFoundException;
use DateTime;
use Src\Infra\Connection\PDOConnection;
use Src\Infra\Enviroment\DotEnvAdapter;

class DeleteReminderTest extends TestCase
{
    private DatabaseReminderRepository $reminderRepository;
    private DeleteReminder $deleteReminder;
    private PDOConnection $connection;

    protected function setUp(): void
    {
   
        $fakeEnv = new class extends DotEnvAdapter
        {
            public function get(string $key, mixed $default = null): mixed
            {
                $val = parent::get($key, $default);
                return ($key == 'ENVIROMENT') ? 'local' : $val;
            }
        };

        $this->connection = new PDOConnection($fakeEnv);

        $this->reminderRepository = new DatabaseReminderRepository($this->connection);
        $this->deleteReminder = new DeleteReminder($this->reminderRepository);

    }

    public function testExecuteDeletesExistingReminder()
    {
        $character = Character::create(
            '1',
            'Character Name',
            'Happy',
            'Hero',
            'Young',
            'Origin',
            'Speech',
            'Accent',
            'Archetype',
            'ImagePath'
        );

        $reminder = new Reminder(
            'Original Message',
            'Processed Message',
            new DateTime('2024-07-16 12:00:00'),
            $character,
        );

       $reminderId = $this->reminderRepository->save($reminder);

        $result = $this->deleteReminder->execute($reminderId);
        $this->assertTrue($result);

        $this->assertNull($this->reminderRepository->find($reminderId));
    }

    public function testExecuteThrowsNotFoundExceptionForNonexistentReminder()
    {
        $reminderId = 'nonexistent';

        $this->expectException(NotFoundException::class);

        $this->deleteReminder->execute($reminderId);
    }
}
