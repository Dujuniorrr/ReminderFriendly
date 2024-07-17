<?php

namespace Src\Application\Commands;

use Exception;
use Src\Application\Exceptions\NotFoundException;
use Src\Application\Repository\ReminderRepository;

/**
 * Class ListReminder
 * 
 * Command to list a reminder.
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
