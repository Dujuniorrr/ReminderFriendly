<?php

namespace Src\Infra\Repository;

use DateTime;
use Exception;
use Src\Application\Connection\Connection;
use Src\Application\Repository\ReminderRepository;
use Src\Domain\Reminder;

class DatabaseReminderRepository implements ReminderRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(Reminder $reminder): bool
    {
        $query = "INSERT INTO reminders (originalMessage, processedMessage, date, characterId, `send`, createdAt) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    
     
        $params = [
            $reminder->getOriginalMessage(),
            $reminder->getProcessedMessage(),
            $reminder->getDate()->format('Y-m-d H:i:s'),
            $reminder->getCharacterId(),
            (int) $reminder->getSend(),
            $reminder->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    
        try {
            $this->connection->query($query, $params);
            return true;
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
            return !empty($result);
        } catch (Exception $e) {
            throw new Exception("Error deleting reminder");
        }
    }


    public function list(): array
    {
        $query = "SELECT * FROM reminders";

        try {
            $results = $this->connection->query($query);
            $reminders = [];

            foreach ($results as $reminderData) {
                $reminders[] = $this->mapToReminder($reminderData);
            }

            return $reminders;
        } catch (Exception $e) {
            throw new Exception("Error listing reminders");
        }
    }

    private function mapToReminder(array $data): Reminder
    {
        return Reminder::create(
            $data['id'],
            $data['originalMessage'],
            $data['processedMessage'],
            new DateTime($data['date']), // Criando objeto DateTime a partir do banco de dados
            $data['characterId'],
            new DateTime($data['createdAt']), // Criando objeto DateTime a partir do banco de dados
            (bool) $data['send'], // Convertendo para booleano
        );
    }
}
