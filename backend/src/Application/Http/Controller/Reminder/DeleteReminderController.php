<?php

namespace Src\Application\Http\Controller\Reminder;

use Exception;
use Src\Application\Commands\DeleteReminder;
use Src\Application\DTO\DeleteReminder\DeleteReminderInput;
use Src\Application\Exceptions\NotFoundException;
use Src\Application\Http\Controller\Controller;
use Src\Application\Http\Controller\Response;
use Src\Application\Http\Request\Validator;

/**
 * Class DeleteReminderController
 * 
 * Controller for handling the deleting of reminders.
 */
final class DeleteReminderController extends Controller
{
    /**
     * @param DeleteReminder $deleteReminder Command for deleting reminders
     */
    public function __construct(
        readonly private DeleteReminder $deleteReminder
    ) {
    }

    public function handle($params, $body): Response
    {
        try {
            $output = $this->deleteReminder->execute($params['id']);

            if ($output) {
                return new Response([
                    'message' => 'Reminder deleted with success'
                ], 200);
            }

            return new Response([
                'error' => 'Not possible delete this Reminder'
            ], 403);

        } 
        catch (NotFoundException $e) {
            return new Response(['error' => $e->getMessage()], 404);
        }
        catch (Exception $e) {
            return new Response(['error' => $e->getMessage()], 422);
        }
    }
}
