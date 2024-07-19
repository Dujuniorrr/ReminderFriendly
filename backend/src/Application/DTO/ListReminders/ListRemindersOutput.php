<?php

namespace Src\Application\DTO\ListReminders;

use Src\Application\DTO\BaseDTO;

/**
 * Class ListRemindersOutput
 * 
 * Data Transfer Object for the output of a reminders list.
 */
class ListRemindersOutput extends BaseDTO
{
    /**
     * @param string $id The ID of the reminder
     * @param string $originalMessage The original message of the reminder
     * @param string $processedMessage The processed message of the reminder
     * @param string $date The date of the reminder
     * @param string $createdAt The creation date of the reminder
     * @param string $characterId The ID of the character associated with the reminder
     * @param bool $send Indicates whether the reminder should be sent
     * @param string $name The name of the character associated with the reminder
     * @param string $humor The humor of the character associated with the reminder
     * @param string $role The role of the character associated with the reminder
     * @param string $ageVitality The age and vitality of the character associated with the reminder
     * @param string $origin The origin of the character associated with the reminder
     * @param string $speechMannerisms The speech mannerisms of the character associated with the reminder
     * @param string $accent The accent of the character associated with the reminder
     * @param string $archetype The archetype of the character associated with the reminder
     * @param string $imagePath The image path of the character associated with the reminder
     * @param string $color Color representation of the character 
     */
    public function __construct(
        readonly public string $id,
        readonly public string $originalMessage,
        readonly public string $processedMessage,
        readonly public string $date,
        readonly public string $createdAt,
        readonly public string $characterId,
        readonly public bool $send,
        readonly public string $name,
        readonly public string $humor,
        readonly public string $role,
        readonly public string $ageVitality,
        readonly public string $origin,
        readonly public string $speechMannerisms,
        readonly public string $accent,
        readonly public string $archetype,
        readonly public string $imagePath,
        readonly public string $color,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'originalMessage' => $this->originalMessage,
            'processedMessage' => $this->processedMessage,
            'date' => $this->date,
            'createdAt' => $this->createdAt,
            'send' => $this->send,
            'character' => [
                'id' => $this->characterId,
                'name' => $this->name,
                'humor' => $this->humor,
                'role' => $this->role,
                'ageVitality' => $this->ageVitality,
                'origin' => $this->origin,
                'speechMannerisms' => $this->speechMannerisms,
                'accent' => $this->accent,
                'archetype' => $this->archetype,
                'imagePath' => $this->imagePath,
                'color' => $this->color
            ]
        ];
    }
}
