<?php

namespace Src\Application\Http\Controller\Reminder;

use Exception;
use Src\Application\Commands\ListReminders;
use Src\Application\DTO\ListReminders\ListRemindersInput;
use Src\Application\Http\Controller\Controller;
use Src\Application\Http\Controller\Response;
use Src\Application\Http\Request\Validator;

/**
 * Class ListRemindersController
 * 
 * Controller for handling the list of reminders.
 */
final class ListRemindersController extends Controller
{
    public function __construct(
        readonly private ListReminders $listReminders,
        readonly private Validator $validator
    ) {
    }

    public function handle($params, $body): Response
    {
        $errors = $this->validator->validate($params);
        if ($errors) return $errors;

        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $status = isset($params['status']) ? $params['status'] : 'notSend';

        try {
            list($output, $total) = $this->listReminders->execute(
                new ListRemindersInput($page, $limit, $status
            ));
            
            $formattedOutput = array_map(function ($reminder) {
                return $reminder->toArray();
            }, $output);

            $paginationData = [ 'total' => $total, 'perPage' => $limit, 'currentPage' => $page ];
            
            return new Response(array_merge( $formattedOutput, $paginationData ), 200);

        } catch (Exception $e) {
            return new Response(['error' => $e->getMessage()], 422);
        }
    }
}
