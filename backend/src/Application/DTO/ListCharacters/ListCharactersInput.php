<?php

namespace Src\Application\DTO\ListCharacters;

use Src\Application\DTO\BaseDTO;

/**
 * Class ListCharactersInput
 * 
 * Data Transfer Object for list reminders.
 */
class ListCharactersInput extends BaseDTO
{

    /**
     * Constructor for ListCharactersInput
     * 
     * @param int $page Current page
     * @param int $limit Limit of characters 
     */
    public function __construct(
        readonly public int $page,
        readonly public int $limit,

    ) {
    }
}
