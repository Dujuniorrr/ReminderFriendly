<?php

namespace Src\Application\Http\Controller\Reminder;

use Exception;
use Src\Application\Commands\ListRemindersByMonth;
use Src\Application\Http\Controller\Controller;
use Src\Application\Http\Controller\Response;
use Src\Application\Http\Request\Validator;

/**
 * Class ListRemindersByMonthController
 * 
 * Controller for handling the list of reminders by month.
 */
final class ListRemindersByMonthController extends Controller
{
    /**
     * Contructor of List Reminders controller
     * @param ListRemindersByMonth $listRemindersByMonth Command for listing reminders by month
     * @param Validator $validator Validator of request params
     */
    public function __construct(
        readonly private ListRemindersByMonth $listRemindersByMonth,
        readonly private Validator $validator
    ) {
    }

    public function handle($params, $body): Response
    {
        $errors = $this->validator->validate($params);
        if ($errors) return $errors;

        try {
            list($output, $total) = $this->listRemindersByMonth->execute($params['month'], $params['year']);

            $formattedOutput = [
                'reminders' => []
            ];

            foreach ($output as $item) {
                $formattedOutput['reminders'][] = $item->toArray();
            }

            $paginationData = ['total' => $total];

            return new Response(array_merge($formattedOutput, $paginationData), 200);
        } catch (Exception $e) {
            return new Response(['error' => $e->getMessage()], 422);
        }
    }
}
