<?php

namespace Src\Application\Enviroment;

interface Env {
    function get(string $key, mixed $default = null): mixed;
}