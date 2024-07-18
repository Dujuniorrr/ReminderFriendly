<?php

namespace Src\Application\DTO\CreateReminder;

use Src\Application\DTO\BaseDTO;

/**
 * Class CreateReminderInput
 * 
 * Data Transfer Object for creating a reminder.
 */
class CreateReminderInput extends BaseDTO
{
    /**
     * @param string $content The content of the reminder
     * @param string $characterId The ID of the character associated with the reminder
     */
    public function __construct(
        readonly public string $content,
        readonly public string $characterId
    ) {
    }
}
