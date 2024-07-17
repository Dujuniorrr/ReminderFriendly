<?php

namespace Src\Infra\Http\Request;

use Respect\Validation\Validator as v;
use Src\Application\Http\Request\Validator;

final class ListRemindersValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'page' => v::optional(v::intVal()->min(1)),
            'limit' => v::optional(v::intVal()->between(1, 100)),
            'status' => v::optional(v::stringType()->in(['send', 'notSend'])),
        ];
    }
}
