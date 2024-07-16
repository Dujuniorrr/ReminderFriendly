<?php

namespace Src\Application\Repository;

use Src\Domain\Character;

interface CharacterRepository
{
    /**
     * Find a character by ID.
     *
     * @param string $id The ID of the character to find.
     * @return Character|null The found Character object or null if not found.
     */
    function find(string $id): ?Character;

    /**
     * List all characters.
     *
     * @return array<Character> An array of Character objects.
     */
    function list(): array;
}

?>
