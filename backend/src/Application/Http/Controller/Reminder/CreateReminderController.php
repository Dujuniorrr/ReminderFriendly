<?php

namespace Src\Application\Http\Controller\Reminder;

use Exception;
use Src\Application\Commands\CreateReminder;
use Src\Application\DTO\CreateReminder\CreateReminderInput;
use Src\Application\Http\Controller\Controller;
use Src\Application\Http\Controller\Response;
use Src\Application\Http\Request\Validator;

/**
 * Class CreateReminderController
 * 
 * Controller for handling the creation of reminders.
 */
final class CreateReminderController extends Controller
{
    /**
     * @param Validator $validator Validator for request data
     * @param CreateReminder $createReminder Command for creating reminders
     */
    public function __construct(
        readonly private Validator $validator,
        readonly private CreateReminder $createReminder
    ) {
    }

    public function handle($params, $body): Response
    {
        $errors = $this->validator->validate($body);
        if ($errors) return $errors;

        try {
            $output = $this->createReminder->execute(new CreateReminderInput(
                $body['content'],
                $body['characterId'],
            ));

            return new Response($output->toArray(), 200);
        } catch (Exception $e) {
            return new Response(['error' => $e->getMessage()], 422);
        }
    }
}
