<?php

namespace Tests\Unit\Infra\Repository;

use PHPUnit\Framework\TestCase;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Domain\Reminder;
use Src\Application\Connection\Connection;
use DateTime;

class DatabaseReminderRepositoryTest extends TestCase
{

    public function testSaveReminder()
    {
        $reminder = new Reminder(
            'Test original message',
            'Test processed message',
            new DateTime('2024-07-18 15:00:00'),
            '1',
            false,
            new DateTime()
        );

        $mockConnection = new class implements Connection
        {
            public function query(string $query, array $params = []): array
            {

                return  [true];
            }
        };
        $reminderRepository = new DatabaseReminderRepository($mockConnection);

        $result = $reminderRepository->save($reminder);
        $this->assertTrue($result);
    }

    public function testDeleteReminder()
    {
        $reminderData = [
            'id' => '1',
            'originalMessage' => 'Test original message',
            'processedMessage' => 'Test processed message',
            'date' => '2024-07-18 15:00:00',
            'characterId' => '1',
            'send' => '0',
            'createdAt' => (new DateTime())->format('Y-m-d H:i:s'),
        ];

        $mockConnection = new class($reminderData) implements Connection
        {
            private $reminderData;

            public function __construct(array $reminderData)
            {
                $this->reminderData = $reminderData;
            }

            public function query(string $query, array $params = []): array
            {

                return [true];
            }
        };

        $reminderRepository = new DatabaseReminderRepository($mockConnection);

        $result = $reminderRepository->delete('1');

        $this->assertTrue($result);
    }

    public function testDeleteNonExistingReminder()
    {
        $mockConnection = new class implements Connection
        {
            public function query(string $query, array $params = []): array
            {
                return [];
            }
        };

        $reminderRepository = new DatabaseReminderRepository($mockConnection);

        $result = $reminderRepository->delete('999'); // Id que não existe

        $this->assertFalse($result);
    }

    public function testListReminders()
    {
        $remindersData = [
            [
                'id' => '1',
                'originalMessage' => 'Test original message 1',
                'processedMessage' => 'Test processed message 1',
                'date' => '2024-07-18 15:00:00',
                'characterId' => '1',
                'send' => '0',
                'createdAt' => (new DateTime())->format('Y-m-d H:i:s'),
            ],
            [
                'id' => '2',
                'originalMessage' => 'Test original message 2',
                'processedMessage' => 'Test processed message 2',
                'date' => '2024-07-19 10:00:00',
                'characterId' => '2',
                'send' => '1',
                'createdAt' => (new DateTime())->format('Y-m-d H:i:s'),
            ],
        ];


        $mockConnection = new class($remindersData) implements Connection
        {
            private $remindersData;

            public function __construct(array $remindersData)
            {
                $this->remindersData = $remindersData;
            }

            public function query(string $query, array $params = []): array
            {

                return $this->remindersData;
            }
        };

        $reminderRepository = new DatabaseReminderRepository($mockConnection);

        $reminders = $reminderRepository->list();

        $this->assertNotEmpty($reminders);
        $this->assertCount(2, $reminders);
        $this->assertInstanceOf(Reminder::class, $reminders[0]);
        $this->assertEquals('Test original message 1', $reminders[0]->getOriginalMessage());
        $this->assertInstanceOf(Reminder::class, $reminders[1]);
        $this->assertEquals('Test original message 2', $reminders[1]->getOriginalMessage());
    }
}