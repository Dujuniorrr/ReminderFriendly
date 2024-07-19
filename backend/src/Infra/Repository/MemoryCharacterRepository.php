<?php

namespace Src\Infra\Repository;

use Src\Application\Repository\CharacterRepository;
use Src\Domain\Character;

class MemoryCharacterRepository implements CharacterRepository
{
    private array $characters;

    public function __construct()
    {
        $this->characters = [
            '1' =>  Character::create(
                '1',
                'Sherlock Holmes',
                'Witty',
                'Detective',
                'Energetic',
                'London',
                'Analytical',
                'British',
                'Investigator',
                'sherlock.jpg',
                'blue'
            ),
            '2' => Character::create(
                '2',
                'Spider-Main',
                'Intelligent',
                'Hero',
                'Young',
                'Marvel',
                'Articulate',
                'New York',
                'Funny Hero',
                'hermione.jpg',
                'red'
            ),
            '3' => Character::create(
                '3', 
                'Darth Vader',
                'Powerful',
                'Dark Lord of the Sith',
                'Former Jedi Knight turned Sith Lord', 
                'Galactic Empire', 
                'Intimidating',
                'Human', 
                'Dark Lord of the Sith', 
                'darthvader.jpg',
                'black'
            )
            
        ];
    }

    public function find(string $id): ?Character
    {
        return isset($this->characters[$id]) ? $this->characters[$id] : null;
    }

    public function list(int $page = 10, int $limit = 0): array
    {
        return $this->characters;
    }

    function count(): int
    {
        return 3;
    }
}

?>
