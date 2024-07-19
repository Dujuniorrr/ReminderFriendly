<?php

namespace Src\Infra\Repository;

use Src\Application\Repository\CharacterRepository;
use Src\Domain\Character;
use Exception;
use Src\Application\Connection\Connection;

class DatabaseCharacterRepository implements CharacterRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(string $id): ?Character
    {

        $query = "SELECT * FROM characters WHERE id = ?";
        $params = [$id];

        try {
            $result = $this->connection->query($query, $params);

            if (empty($result)) {
                return null;
            }

            $characterData = $result[0];

            return $this->mapToCharacter($characterData);
        } catch (Exception $e) {
            throw new Exception("Error finding character");
        }
    }

    public function list(int $page = 1, int $limit = 10): array
    {
        if ($limit > 100) $limit = 100;

        $offset = ($page - 1) * $limit;

        $query = "SELECT * FROM characters LIMIT ? OFFSET ?";
        $params = [$limit, $offset];

        try {
            $results = $this->connection->query($query, $params);
            $characters = [];

            foreach ($results as $characterData) {
                $characters[] = $this->mapToCharacter($characterData);
            }

            return $characters;
        } catch (Exception $e) {
            throw new Exception("Error listing characters");
        }
    }

    public function count(): int
    {

        $query = "SELECT COUNT(*) AS total FROM characters";

        try {
            $result = $this->connection->query($query);

            return (int) $result[0]['total'];
        } catch (Exception $e) {
            throw new Exception("Error counting characters");
        }
    }



    private function mapToCharacter(array $data): Character
    {
        return Character::create(
            $data['id'],
            $data['name'],
            $data['humor'],
            $data['role'],
            $data['ageVitality'],
            $data['origin'],
            $data['speechMannerisms'],
            $data['accent'],
            $data['archetype'],
            $data['imagePath'],
            $data['color'],
        );
    }
}
