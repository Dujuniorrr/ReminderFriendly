<?php

namespace Src\Infra\Http\Request;

use Respect\Validation\Validator as v;
use Src\Application\Http\Request\Validator;

final class ListRemindersByMonthValidator extends Validator
{
    public function __construct()
    {
        $this->rules = [
            'month' => v::optional(v::intVal()->between(1, 100)),
            'year' => v::optional(v::intVal()->min(0)->max(date('Y'))),
        ];
    }
}
