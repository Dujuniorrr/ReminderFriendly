<?php

namespace Src\Application\Http\Controller;

/**
 * Class Response
 * 
 * @attribute array $data Response data.
 * @attribute int $status HTTP status code of the response.
 */
class Response
{
    public function __construct(
        readonly public array $data,
        readonly public int $status
    ) {
    }
}
