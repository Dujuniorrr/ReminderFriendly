<?php

namespace Src\Application\Commands;

use Exception;
use Src\Application\DTO\CreateReminder\CreateReminderInput;
use Src\Application\DTO\CreateReminder\CreateReminderOutput;
use Src\Application\Gateways\NLPGateway;
use Src\Application\Repository\CharacterRepository;
use Src\Application\Repository\ReminderRepository;
use Src\Domain\Reminder;

/**
 * Class CreateReminder
 * 
 * Command to create a reminder.
 */
final class CreateReminder
{
    /**
     * @var CharacterRepository $characterRepository Repository for characters
     * @var ReminderRepository $reminderRepository Repository for reminders
     * @var NLPGateway $nlpGateway NLP Gateway
     */
    public function __construct(
        readonly private CharacterRepository $characterRepository,
        readonly private ReminderRepository $reminderRepository,
        readonly private NLPGateway $nlpGateway
    ) {
    }

    /**
     * Executes the command to create a reminder.
     *
     * @param CreateReminderInput $input Input data for creating the reminder
     * 
     * @return CreateReminderOutput|null Output data after creating the reminder
     * 
     * @throws Exception If the character is not found or content not understandable
     */
    public function execute(CreateReminderInput $input): ?CreateReminderOutput
    {
        $character = $this->characterRepository->find($input->characterId);

        if ($character) {
            $nlpData = $this->nlpGateway->formatMessage($input->content, $character);

            $reminder = new Reminder(
                $input->content,
                $nlpData->processedMessage,
                $nlpData->date,
                $character
            );

            $reminderId = $this->reminderRepository->save($reminder);

            return new CreateReminderOutput(
                $reminderId,
                $reminder->getOriginalMessage(),
                $reminder->getProcessedMessage(),
                $reminder->getDate()->format('Y-m-d H:i:s'),
                $reminder->getCreatedAt()->format('Y-m-d H:i:s'),
                $reminder->getCharacter()->getId(),
                $reminder->getSend(),
            );
        }

        throw new Exception('Character not found');
    }
}
