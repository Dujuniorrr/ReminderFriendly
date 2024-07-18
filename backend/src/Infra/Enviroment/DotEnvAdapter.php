<?php

namespace Src\Infra\Enviroment;

use Dotenv\Dotenv;
use Src\Application\Enviroment\Env;

class DotEnvAdapter implements Env
{
    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();
    }
    
    public function get(string $key, mixed $default = null): mixed
    {
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}
