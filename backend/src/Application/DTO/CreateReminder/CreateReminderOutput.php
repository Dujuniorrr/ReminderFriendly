<?php

namespace Src\Application\DTO\CreateReminder;

use Src\Application\DTO\BaseDTO;

/**
 * Class CreateReminderOutput
 * 
 * Data Transfer Object for the output of a created reminder.
 */
class CreateReminderOutput extends BaseDTO
{
    /**
     * @param string $id ID of the reminder
     * @param string $originalMessage The original message of the reminder
     * @param string $processedMessage The processed message of the reminder
     * @param string $date The date of the reminder
     * @param string $createdAt The creation date of the reminder
     * @param string $characterId The ID of the character associated with the reminder
     * @param bool $send Indicates whether the reminder should be sent
     */
    public function __construct(
        readonly public string $id,
        readonly public string $originalMessage,
        readonly public string $processedMessage,
        readonly public string $date,
        readonly public string $createdAt,
        readonly public string $characterId,
        readonly public bool $send
    ) {
    }
}
