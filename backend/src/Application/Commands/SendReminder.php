<?php

namespace Src\Application\Commands;

use Exception;
use Src\Application\Exceptions\NotFoundException;
use Src\Application\Gateways\MessageSenderGateway;
use Src\Application\Repository\ReminderRepository;

/**
 * Class ListReminder
 * 
 * Command to send a reminder.
 */
final class SendReminder
{
    /**
     * @var ReminderRepository $reminderRepository Repository for reminders
     * @var MessageSenderGateway $messageSenderGateway Gateway for send messages
     */
    public function __construct(
        readonly private ReminderRepository $reminderRepository,
        readonly private MessageSenderGateway $messageSenderGateway
    ) {
    }

    /**
     * Executes the command to send a reminder.
     *
     * @param string $id ID of reminder to send
     * 
     * @return bool True if reminder send, false otherwise.
     * 
     */
    public function execute(string $id): bool
    {
        $reminder = $this->reminderRepository->find($id);
 
        if(!$reminder){
            throw new NotFoundException('Reminder not found');
        }
        
        $reminder->send();
        $sendWithSuccess = $this->messageSenderGateway->sendReminder($reminder);
        
        if($sendWithSuccess){
            $this->reminderRepository->update($reminder);
        }

        return $sendWithSuccess;
    }
}
