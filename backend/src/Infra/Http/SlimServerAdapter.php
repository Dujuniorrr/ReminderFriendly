<?php
namespace Src\Infra\Http;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Src\Application\Http\Server\HttpServer;

class SlimServerAdapter implements HttpServer
{
    private $app;

    public function __construct()
    {
        $this->app = AppFactory::create();
        $this->configCORS($this->app);

        $this->app->addErrorMiddleware(true, true, true);
    }

    public function register(string $method, string $url, callable $callback): void
    {
        $this->app->{strtolower($method)}($url, function (Request $request, Response $response, $args) use ($callback) {
            $data = $callback();

            if (!is_array($data) || count($data) !== 2) {
                throw new \RuntimeException('Invalid callback return format');
            }

            $controller = $data[0];

            $output = call_user_func_array([$controller, $data[1]], [$args, $request->getParsedBody()]);

            $response->getBody()->write(json_encode($output));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });
    }

    public function run(): void
    {
        $this->app->run();
    }

    private function configCORS(&$app)
    {
        $app->add(function ($request, $handler) use ($app) {
            $response = $handler->handle($request);

            $response = $response
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8000')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

            return $response;
        });
    }
}
