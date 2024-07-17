<?php

namespace Src\Application\DTO\ListReminders;

use Src\Application\DTO\BaseDTO;

/**
 * Class ListRemindersInput
 * 
 * Data Transfer Object for list reminders.
 */
class ListRemindersInput extends BaseDTO
{

    /**
     * Constructor for ListReminderInput
     * 
     * @param int $page Current page
     * @param int $limit Limit of reminders 
     * @param string $status Status of reminder
     */
    public function __construct(
        readonly public int $page,
        readonly public int $limit,
        readonly public string $status,

    ) {
    }
}
