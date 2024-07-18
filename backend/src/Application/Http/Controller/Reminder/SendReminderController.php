<?php

namespace Src\Application\Http\Controller\Reminder;

use Exception;
use Src\Application\Commands\SendReminder;
use Src\Application\Exceptions\NotFoundException;
use Src\Application\Http\Controller\Controller;
use Src\Application\Http\Controller\Response;

/**
 * Class SendReminderController
 * 
 * Controller for handling the sending of reminders.
 */
final class SendReminderController extends Controller
{
    /**
     * @param SendReminder $sendReminder Command for send reminders
     */
    public function __construct(
        readonly private SendReminder $sendReminder
    ) {
    }

    public function handle($params, $body): Response
    {
        try {
            $output = $this->sendReminder->execute($params['id']);

            if ($output) {
                return new Response([
                    'message' => 'Reminder sended with success'
                ], 200);
            }

            return new Response([
                'error' => 'Not possible send this Reminder'
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
