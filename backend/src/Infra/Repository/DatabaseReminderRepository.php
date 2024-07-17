<?php

namespace Src\Infra\Repository;

use DateTime;
use Exception;
use Src\Application\Connection\Connection;
use Src\Application\Repository\ReminderRepository;
use Src\Domain\Character;
use Src\Domain\Reminder;

class DatabaseReminderRepository implements ReminderRepository
{
    private Connection $connection;
    private array $reminderStatus;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->reminderStatus = [
            'send' => 1,
            'notSend' => 0,
        ];
    }

    public function save(Reminder $reminder): string
    {
        $query = "INSERT INTO reminders (originalMessage, processedMessage, date, characterId, `send`, createdAt) 
                  VALUES (?, ?, ?, ?, ?, ?)";


        $params = [
            $reminder->getOriginalMessage(),
            $reminder->getProcessedMessage(),
            $reminder->getDate()->format('Y-m-d H:i:s'),
            $reminder->getCharacter()->getId(),
            (int) $reminder->getSend(),
            $reminder->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        try {
            $this->connection->query($query, $params);
            return $this->connection->lastInsertId();
        } catch (Exception $e) {

            throw new Exception("Error saving reminder" . $e->getMessage());
        }
    }

    public function delete(string $id): bool
    {
        $query = "DELETE FROM reminders WHERE id = ?";
        $params = [$id];

        try {
            $result = $this->connection->query($query, $params);
            return empty($result);
        } catch (Exception $e) {
            throw new Exception("Error deleting reminder");
        }
    }


    public function list(int $page = 1, int $limit = 10, string $status = 'notSend'): array
    {
        if (!isset($this->reminderStatus[$status])) {
            throw new Exception('Status of reminder invalid. Options: send, notSend');
        }

        if ($limit > 100) $limit = 100;
        $offset = ($page - 1) * $limit;

        $statusFilter = $this->reminderStatus[$status];

        $query = "SELECT *, reminders.id AS reminderId
                  FROM reminders INNER JOIN characters
                  ON characters.id = reminders.characterId 
                  WHERE reminders.send = ?
                  LIMIT ? OFFSET ?";

        $params = [$statusFilter, $limit, $offset];

        try {
            $results = $this->connection->query($query, $params);
            $reminders = [];

            foreach ($results as $reminderData) {
                $reminders[] = $this->mapToReminder($reminderData);
            }

            return $reminders;
        } catch (Exception $e) {
            throw new Exception("Error listing reminders" . $e->getMessage());
        }
    }

    public function count(string $status = 'send'): int
    {
        if (!isset($this->reminderStatus[$status])) {
            throw new Exception('Status of reminder invalid. Options: send, notSend');
        }

        $statusFilter = $this->reminderStatus[$status];

        $query = "SELECT COUNT(*) AS total FROM reminders WHERE send = ?";

        $params = [$statusFilter];

        try {
            $result = $this->connection->query($query, $params);

            return (int) $result[0]['total'];
        } catch (Exception $e) {
            throw new Exception("Error counting reminders: " . $e->getMessage());
        }
    }


    public function find(string $id): ?Reminder
    {
        $query = "SELECT *, reminders.id AS reminderId
              FROM reminders INNER JOIN characters
              ON characters.id = reminders.characterId
              WHERE reminders.id = ?";

        $params = [$id];

        try {
            $result = $this->connection->query($query, $params);

            if (empty($result)) {
                return null; 
            }

            return $this->mapToReminder($result[0]);
        } catch (Exception $e) {
            throw new Exception("Error finding reminder: " . $e->getMessage());
        }
    }


    private function mapToReminder(array $data): Reminder
    {
        return Reminder::create(
            $data['reminderId'],
            $data['originalMessage'],
            $data['processedMessage'],
            new DateTime($data['date']),
            Character::create(
                $data['characterId'],
                $data['name'],
                $data['humor'],
                $data['role'],
                $data['ageVitality'],
                $data['origin'],
                $data['speechMannerisms'],
                $data['accent'],
                $data['archetype'],
                $data['imagePath']
            ),
            new DateTime($data['createdAt']),
            (bool) $data['send'],
        );
    }
}
