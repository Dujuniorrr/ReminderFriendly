<?php

namespace Src\Application\Http\Controller\Character;

use Exception;
use Src\Application\Commands\ListCharacters;
use Src\Application\DTO\ListCharacters\ListCharactersInput;
use Src\Application\Http\Controller\Controller;
use Src\Application\Http\Controller\Response;
use Src\Application\Http\Request\Validator;

/**
 * Class ListCharactersController
 * 
 * Controller for handling the list of reminders.
 */
final class ListCharactersController extends Controller
{
    /**
     * Contructor of List Characters controller
     * @param ListCharacters $listCharacters Command for listing characters
     * @param Validator $validator Validator of request params
     */
    public function __construct(
        readonly private ListCharacters $listCharacters,
        readonly private Validator $validator
    ) {
    }

    public function handle($params, $body): Response
    {
        $errors = $this->validator->validate($params);
        if ($errors) return $errors;

        $page = isset($params['page']) ? $params['page'] : 1;
        $limit = isset($params['limit']) ? $params['limit'] : 20;

        try {
            list($output, $total) = $this->listCharacters->execute(
                new ListCharactersInput(
                    $page,
                    $limit
                )
            );

            $formattedOutput = ['characters' => []];
            foreach ($output as $item) {
                $formattedOutput['characters'][] = $item->toArray();
            }

            $paginationData = ['total' => $total, 'perPage' => $limit, 'currentPage' => $page];

            return new Response(array_merge($formattedOutput, $paginationData), 200);
        } catch (Exception $e) {
            return new Response(['error' => $e->getMessage()], 422);
        }
    }
}
