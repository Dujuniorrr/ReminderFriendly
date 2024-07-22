<?php

namespace Src\Application\Repository;

use Src\Domain\Reminder;

interface ReminderRepository
{
    /**
     * Save a reminder.
     *
     * @param Reminder $reminder The reminder object to save.
     * @return string ID of reminder save.
     */
    function save(Reminder $reminder): string;

    /**
     * Update a reminder.
     *
     * @param Reminder $reminder The reminder object to update.
     * @return string ID of reminder updated.
     */
    function update(Reminder $reminder): string;


    /**
     * List all reminders.
     *
     * @param int $page Current Page
     * @param int $limit Limit of reminders, max 100
     * @param string $status Status of reminder: all, send
     * @param ?string $search Search for reminders
     * @return array<Reminder> An array of Reminder objects.
     */
    public function list(int $page = 1, int $limit = 10, string $status = 'notSend', ?string $search = null): array;

    /**
     * List reminders by month.
     *
     * @param int $month Month
     * @param int $year Year
     * @return array<Reminder> An array of Reminder objects.
     */
    public function listByMonth(int $month, int $year): array;

    /**
     * Delete a reminder by ID.
     *
     * @param string $id The ID of the reminder to delete.
     * @return bool True if the reminder was deleted successfully, false otherwise.
     */
    function delete(string $id): bool;

    /**
     * Count reminders based on status.
     *
     * @param string $status Status of reminders to count: all, send
     * @param ?string $search Search for reminders
     * @return int The total number of reminders.
     */
    function count(string $status = 'notSend', ?string $search = null): int;

    /**
     * Find a reminder by ID.
     *
     * @param string $id The ID of the reminder to find.
     * @return Reminder|null The reminder object if found, or null if not found.
     */
    function find(string $id): ?Reminder;
}
