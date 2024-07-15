<?php

namespace Src\Application\Http\Controller\Reminder;

use Src\Application\Http\Controller\Controller;

final class GetReminderController extends Controller
{    
    public function handle ($params, $body): array {
        $data = ['msg' => 'teste'];
        return $params;
    }
}
