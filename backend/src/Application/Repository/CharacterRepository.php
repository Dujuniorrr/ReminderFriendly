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
     * Count characters.
     *
     * @return int The total number of characters.
     */
    function count(): int;

    /**
     * List all characters.
     * @param int $page Current Page
     * @param int $limit Limit of characters, max 100
     * @return array<Character> An array of Character objects.
     */
    public function list(int $page = 1, int $limit = 10): array;
}
