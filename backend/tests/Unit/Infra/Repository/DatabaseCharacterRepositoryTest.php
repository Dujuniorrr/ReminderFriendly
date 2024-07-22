<?php

namespace Tests\Unit\Infra\Repository;

use PHPUnit\Framework\TestCase;
use Src\Infra\Repository\DatabaseCharacterRepository;
use Src\Domain\Character;
use Src\Application\Connection\Connection;
use Exception;

class DatabaseCharacterRepositoryTest extends TestCase
{

    public function testFindExistingCharacter()
    {

        $connection = new class implements Connection
        {


            public function lastInsertId(): string
            {
                return "1";
            }

            public function query(string $statement, array $params = []): mixed
            {
                return [
                    [
                        'id' => '1',
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
                    ]
                ];
            }
        };

        $characterRepository = new DatabaseCharacterRepository($connection);

        $character = $characterRepository->find('3');

        $this->assertInstanceOf(Character::class, $character);
        $this->assertEquals('John Doe', $character->getName());
        $this->assertEquals('Sarcastic', $character->getHumor());
    }

    public function testFindNonExistingCharacter()
    {
        $connection = new class implements Connection
        {


            public function lastInsertId(): string
            {
                return "1";
            }

            function query(string $statement, array $params = []): mixed
            {
                return [];
            }
        };

        $characterRepository = new DatabaseCharacterRepository($connection);

        $character = $characterRepository->find('1');

        $this->assertNull($character);
    }

    public function testListCharacters()
    {
        $connection = new class implements Connection
        {
            public function lastInsertId(): string
            {
                return "1";
            }

            function query(string $statement, array $params = []): mixed
            {
                return  [
                    [
                        'id' => '1',
                        'name' => 'John Doe',
                        'humor' => 'Sarcastic',
                        'role' => 'Detective',
                        'ageVitality' => 'Adult',
                        'origin' => 'New York',
                        'speechMannerisms' => 'Blunt and direct',
                        'accent' => 'American',
                        'archetype' => 'Anti-hero',
                        'imagePath' => '/path/to/image.jpg',
                        'color' => 'blue',
                    ],
                    [
                        'id' => '2',
                        'name' => 'Jane Smith',
                        'humor' => 'Witty',
                        'role' => 'Journalist',
                        'ageVitality' => 'Young Adult',
                        'origin' => 'London',
                        'speechMannerisms' => 'Clever and articulate',
                        'accent' => 'British',
                        'archetype' => 'Investigator',
                        'imagePath' => '/path/to/image.jpg',
                        'color' => 'blue',
                    ],
                ];
            }
        };

        $characterRepository = new DatabaseCharacterRepository($connection);

        $characters = $characterRepository->list();

        $this->assertCount(2, $characters);

        $this->assertInstanceOf(Character::class, $characters[0]);
        $this->assertEquals('John Doe', $characters[0]->getName());

        $this->assertInstanceOf(Character::class, $characters[1]);
        $this->assertEquals('Jane Smith', $characters[1]->getName());
    }

    public function testFindThrowsException()
    {
        $connection = new class implements Connection
        {


            public function lastInsertId(): string
            {
                return "1";
            }

            function query(string $statement, array $params = []): mixed
            {
                throw new Exception('Database error');
            }
        };
        $characterRepository = new DatabaseCharacterRepository($connection);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Error finding character');

        $characterRepository->find('1');
    }

    public function testListThrowsException()
    {
        $connection = new class implements Connection
        {


            public function lastInsertId(): string
            {
                return "1";
            }

            function query(string $statement, array $params = []): mixed
            {
                throw new Exception('Database error');
            }
        };
        $characterRepository = new DatabaseCharacterRepository($connection);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Error listing characters');

        $characterRepository->list();
    }
}
