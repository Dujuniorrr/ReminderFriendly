<?php

namespace Src\Application\Http\Server;

interface HttpServer {
    public function register(string $method, string $url, callable $callback): void;
    public function run(): void;
}