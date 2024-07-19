<?php

namespace Src\Application\Commands;

use Src\Application\DTO\ListCharacters\ListCharactersInput;
use Src\Application\DTO\ListCharacters\ListCharactersOutput;
use Src\Application\Repository\CharacterRepository;

/**
 * Class ListCharacters
 * 
 * Command to list a character.
 */
final class ListCharacters
{
    /**
     * @var CharacterRepository $characterRepository Repository for characters
     */
    public function __construct(
        readonly private CharacterRepository $characterRepository,
    ) {
    }

    /**
     * Executes the command to create a character.
     * 
     * @param ListCharactersInput $input Input data for listing characters
     * @return array<array<ListCharactersOutput>|int> Output data of characters list and total characters count
     * 
     */
    public function execute(ListCharactersInput $input): array
    {
        $characters = $this->characterRepository->list($input->page, $input->limit);
        $
        $total = $this->characterRepository->count();

        $output = array_map(
            function ($character) {
                return new ListCharactersOutput(
                    $character->getId(),
                    $character->getName(),
                    $character->getHumor(),
                    $character->getRole(),
                    $character->getAgeVitality(),
                    $character->getOrigin(),
                    $character->getSpeechMannerisms(),
                    $character->getAccent(),
                    $character->getArchetype(),
                    $character->getImagePath(),
                    $character->getColor()
                );
            },
            $characters
        );
        return [$output, $total ];
    }
}
