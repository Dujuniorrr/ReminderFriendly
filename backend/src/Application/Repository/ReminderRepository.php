<?php

namespace Src\Application\Repository;

use Src\Domain\Reminder;

interface ReminderRepository
{
    /**
     * Save a reminder.
     *
     * @param Reminder $reminder The reminder object to save.
     * @return bool True if the reminder was saved successfully, false otherwise.
     */
    function save(Reminder $reminder): bool;

    /**
     * List all reminders.
     *
     * @return array<Reminder> An array of Reminder objects.
     */
    function list(): array;

    /**
     * Delete a reminder by ID.
     *
     * @param string $id The ID of the reminder to delete.
     * @return bool True if the reminder was deleted successfully, false otherwise.
     */
    function delete(string $id): bool;

   
}

?>
