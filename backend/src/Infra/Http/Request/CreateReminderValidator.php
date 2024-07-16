<?php

namespace Src\Infra\Http\Request;

use Respect\Validation\Validator as v;
use Src\Application\Http\Request\Validator;

final class CreateReminderValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'content' => v::notEmpty()->stringVal(),
            'characterId' => v::notEmpty()->stringVal(),
        ];
    }
}
