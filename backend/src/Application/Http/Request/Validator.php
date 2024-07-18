<?php

namespace Src\Application\Http\Request;

use Respect\Validation\Exceptions\NestedValidationException;
use Src\Application\Http\Controller\Response;


/**
 * Class Validator
 * 
 * Abstract base class for request data validation.
 */

abstract class Validator
{
    /**
     * @var mixed $rules Validation rules for request data
     */
    protected $rules;


    /**
     * Validates request data against defined rules.
     * 
     * @param array|null $body The request body to validate
     * 
     * @return Response|null A response object containing validation errors or null if no errors
     */
    public function validate(array|null $body): Response|null
    {
        if (!$body) $body = [];

        $errors = [];

        foreach ($this->rules as $field => $rule) {
            try {
                $rule->assert(isset($body[$field]) ? $body[$field] : null);
            } catch (NestedValidationException $e) {
                $errors[$field] = $e->getMessages();
            }
        }

        return $errors ? new Response(
            ['errors' =>  $errors],
            422
        ) : null;
    }
}
