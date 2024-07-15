<?php

namespace Src\Application\Http\Controller;


abstract class Controller
{    
     /**
     * Handle the incoming request.
     *
     * This method processes the incoming request parameters and body, performing the necessary
     * actions and returning a response as an associative array.
     *
     * @param mixed $params The parameters extracted from the request URL.
     * @param mixed $body The request body content, typically for POST or PUT requests.
     * @return array The response data to be returned, formatted as an associative array.
     */
    abstract function handle(mixed $params, mixed $body): array;
}
