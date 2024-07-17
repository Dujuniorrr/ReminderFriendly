<?php

namespace Src\Application\Commands;

use Src\Application\Exceptions\NotFoundException;
use Src\Application\Repository\ReminderRepository;

/**
 * Class DeleteReminder
 * 
 * Command to delete a reminder.
 */
final class DeleteReminder
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
     * @param string $id ID of reminder to delete
     * 
     * @return bool True if reminder deleted, false otherwise.
     * 
     */
    public function execute(string $id): bool
    {
        $reminder = $this->reminderRepository->find($id);

        if(!$reminder){
            throw new NotFoundException('Reminder not found');
        }
        
        return $this->reminderRepository->delete($id);
    }
}
