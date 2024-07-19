<?php

namespace Src\Application\Commands;

use Src\Application\DTO\ListReminders\ListRemindersInput;
use Src\Application\DTO\ListReminders\ListRemindersOutput;
use Src\Application\Repository\ReminderRepository;

/**
 * Class ListReminders
 * 
 * Command to list a reminder.
 */
final class ListReminders
{
    /**
     * @var ReminderRepository $reminderRepository Repository for reminders
     */
    public function __construct(
        readonly private ReminderRepository $reminderRepository,
    ) {
    }

    /**
     * Executes the command to create a reminder.
     *
     * @param ListRemindersInput $input Input data for listing reminders
     * 
     * @return array<array<ListRemindersOutput>|int> Output data of reminders list and total reminders count
     * 
     */
    public function execute(ListRemindersInput $input): array
    {
        $reminders = $this->reminderRepository->list(
            $input->page, $input->limit, $input->status);
        
        $total = $this->reminderRepository->count($input->status);

        $output = array_map(
            function ($reminder) {
                return new ListRemindersOutput(
                    $reminder->getId(),
                    $reminder->getOriginalMessage(),
                    $reminder->getProcessedMessage(),
                    $reminder->getDate()->format('Y-m-d H:i:s'),
                    $reminder->getCreatedAt()->format('Y-m-d H:i:s'),
                    $reminder->getCharacter()->getId(),
                    $reminder->getSend(),
                    $reminder->getCharacter()->getName(),
                    $reminder->getCharacter()->getHumor(),
                    $reminder->getCharacter()->getRole(),
                    $reminder->getCharacter()->getAgeVitality(),
                    $reminder->getCharacter()->getOrigin(),
                    $reminder->getCharacter()->getSpeechMannerisms(),
                    $reminder->getCharacter()->getAccent(),
                    $reminder->getCharacter()->getArchetype(),
                    $reminder->getCharacter()->getImagePath(),
                    $reminder->getCharacter()->getColor()
                );
            },
            $reminders
        );
        return [$output, $total ];
    }
}
