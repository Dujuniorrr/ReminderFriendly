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
                'sherlock.jpg'
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
                'hermione.jpg'
            ),
            '3' => Character::create(
                '3', // ID ou outro identificador único
                'Darth Vader', // Nome
                'Powerful', // Traço característico
                'Dark Lord of the Sith', // Ocupação
                'Former Jedi Knight turned Sith Lord', // Descrição
                'Galactic Empire', // Afiliação
                'Intimidating', // Característica
                'Human', // Nacionalidade
                'Dark Lord of the Sith', // Título
                'darthvader.jpg' // Imagem
            )
            
        ];
    }

    public function find(string $id): ?Character
    {
        return isset($this->characters[$id]) ? $this->characters[$id] : null;
    }

    public function list(): array
    {
        return $this->characters;
    }
}

?>
