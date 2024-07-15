<?php

namespace Src\Application\Http\Controller;

abstract class Controller
{
    abstract function handle ($params, $body) ;
}
