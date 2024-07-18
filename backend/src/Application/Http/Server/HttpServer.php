<?php

namespace Src\Application\Http\Server;

interface HttpServer
{
    /**
     * Registers a route with the HTTP server.
     *
     * This method allows the registration of a route, associating it with a specific HTTP method,
     * a URL, and a callback function that will be executed when the route is accessed.
     *
     * @param string $method The HTTP method to register the route for (e.g., GET, POST, PUT, DELETE).
     * @param string $url The URL pattern to match for this route.
     * @param callable $callback The callback function to execute when the route is accessed.
     * @return void
     */
    public function register(string $method, string $url, callable $callback): void;

    /**
     * Runs the HTTP server.
     *
     * This method starts the HTTP server, making it ready to accept and handle incoming requests.
     *
     * @return void
     */
    public function run(): void;
}
