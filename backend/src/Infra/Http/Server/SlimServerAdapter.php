<?php

namespace Src\Infra\Http\Server;

use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Src\Application\Http\Server\HttpServer;

class SlimServerAdapter implements HttpServer
{
    private $app;
    private $container;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $dependencies = require __DIR__ . '/../../../../config/di-config.php';
        $dependencies($containerBuilder);
        $this->container = $containerBuilder->build();

        AppFactory::setContainer($this->container);
        $this->app = AppFactory::create();
        $this->app->addBodyParsingMiddleware();
        $this->configCORS($this->app);

        $this->app->addErrorMiddleware(true, true, true);

        $this->app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });
    }

    public function register(string $method, string $url, $data): void
    {
        $container = $this->container;

        $this->app->{strtolower($method)}($url, function (Request $request, Response $response, $args) use ($data, $container) {
            if (!is_array($data) || count($data) < 2) {
                throw new \RuntimeException('Invalid callback return format');
            }

            [$controllerClass, $method] = $data;
            $controller = $container->get($controllerClass);

            $output = call_user_func_array([$controller, $method], [
                array_merge(
                    $args,
                    $request->getQueryParams()
                ), $request->getParsedBody()
            ]);

            $response->getBody()->write(json_encode($output->data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus($output->status);
        });
    }

    public function run(): void
    {
        $this->app->run();
    }

    /**
     * Configures Cross-Origin Resource Sharing (CORS) settings for the application.
     *
     * This method adds middleware to the Slim application to handle CORS headers,
     * allowing cross-origin requests from specified origins and methods.
     *
     * @param \Slim\App $app The Slim application instance to which the CORS middleware will be added.
     * @return void
     */
    private function configCORS(App $app): void
    {
        $app->add(function ($request, $handler) {
            $response = $handler->handle($request);

            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });
    }
}
