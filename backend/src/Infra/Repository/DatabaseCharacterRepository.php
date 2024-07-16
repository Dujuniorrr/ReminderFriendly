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

    public function list(): array
    {
        $query = "SELECT * FROM characters";

        try {
            $results = $this->connection->query($query);
            $characters = [];

            foreach ($results as $characterData) {
                $characters[] = $this->mapToCharacter($characterData);
            }

            return $characters;
        } catch (Exception $e) {
            throw new Exception("Error listing characters");
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
            $data['imagePath']
        );
    }
}
