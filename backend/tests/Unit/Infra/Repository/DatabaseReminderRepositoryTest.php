<?php

namespace Tests\Unit\Infra\Repository;

use PHPUnit\Framework\TestCase;
use Src\Infra\Repository\DatabaseReminderRepository;
use Src\Domain\Reminder;
use Src\Application\Connection\Connection;
use DateTime;
use Src\Domain\Character;

class DatabaseReminderRepositoryTest extends TestCase
{

    public function testSaveReminder()
    {
        $reminder = new Reminder(
            'Test original message',
            'Test processed message',
            new DateTime('2024-07-18 15:00:00'),
            Character::create(
                '1',
                'John Doe',
                'Sarcastic',
                'Detective',
                'Adult',
                'New York',
                'Blunt and direct',
                'American',
                'Anti-hero',
                '/path/to/image.jpg',
                'blue'
            ),
            false,
            new DateTime()
        );

        $mockConnection = new class implements Connection
        { 
            public function lastInsertId(): string
            {
                return "1";
            }

            public function query(string $query, array $params = []): array
            {

                return  [true];
            }
        };
        $reminderRepository = new DatabaseReminderRepository($mockConnection);

        $result = $reminderRepository->save($reminder);
        $this->assertEquals("1", $result);
    }

    public function testDeleteReminder()
    {
        $reminderData = [];

        $mockConnection = new class($reminderData) implements Connection
        {
            private $reminderData;

            public function __construct(array $reminderData)
            {
                $this->reminderData = $reminderData;
            }

            public function lastInsertId(): string
            {
                return "1";
                
            }

            public function query(string $query, array $params = []): array
            {

                return [];
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
            public function lastInsertId(): string
            {
                return "1";
                
            }

            public function query(string $query, array $params = []): array
            {
                return [true];
            }
        };

        $reminderRepository = new DatabaseReminderRepository($mockConnection);

        $result = $reminderRepository->delete('999'); //Not exists

        $this->assertFalse($result);
    }

    public function testListReminders()
    {
        $character = [
            'characterId' => '1',
            'name' => 'John Doe',
            'humor' => 'Sarcastic',
            'role' => 'Detective',
            'ageVitality' => 'Adult',
            'origin' => 'New York',
            'speechMannerisms' => 'Blunt and direct',
            'accent' => 'American',
            'archetype' => 'Anti-hero',
            'imagePath' => '/path/to/image.jpg',
            'color' => 'blue'
        ];

        $remindersData = [
            array_merge(
                [
                    'reminderId' => '1',
                    'originalMessage' => 'Test original message 1',
                    'processedMessage' => 'Test processed message 1',
                    'date' => '2024-07-18 15:00:00',
                    'send' => '0',
                    'createdAt' => (new DateTime())->format('Y-m-d H:i:s'),
                ],
                $character
            ),
            array_merge(
                [
                    'reminderId' => '2',
                    'originalMessage' =>  'Test original message 2',
                    'processedMessage' => 'Test processed message 2',
                    'date' => '2024-07-19 10:00:00',
                    'send' =>  '1',
                    'createdAt' => (new DateTime())->format('Y-m-d H:i:s'),
                ], $character
            ),
        ];

        $mockConnection = new class($remindersData) implements Connection
        {
            private $remindersData;

            public function lastInsertId(): string
            {
                return "1";
                
            }
            
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
