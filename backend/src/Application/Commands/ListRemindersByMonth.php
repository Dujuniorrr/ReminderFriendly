<?php

namespace Src\Application\Commands;

use Src\Application\DTO\ListReminders\ListRemindersOutput;
use Src\Application\Repository\ReminderRepository;

/**
 * Class ListRemindersByMonth
 * 
 * Command to list reminders by month.
 */
final class ListRemindersByMonth
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
     * @param int $month Month for filtering by month
     * @param int $year Year for filtering by year
     * 
     * @return array<array<ListRemindersOutput>|int> Output data of reminders list and total reminders count
     * 
     */
    public function execute(int $month, int $year): array
    {
        $reminders = $this->reminderRepository->listByMonth(
            $month ?? date('n'),
            $year ?? date('Y')
        );

        $total = count($reminders);

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
        return [$output, $total];
    }
}
