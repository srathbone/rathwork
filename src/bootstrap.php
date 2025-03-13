<?php
declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));
define('APP_ENV', getenv('APP_ENV'));
require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/src/functions.php';

function register_error_handler(): void
{
    if (isProduction()) {
    } else {
        ini_set('display_errors', '1');
        error_reporting(E_ALL);
        $whoops = new \Whoops\Run();
        $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler());
        $whoops->register();
    }
}

function create_container(): Psr\Container\ContainerInterface
{
    return require ROOT_DIR . '/src/Dependencies.php';
}

function create_request(): Psr\Http\Message\RequestInterface
{
    return \Laminas\Diactoros\ServerRequestFactory::fromGlobals();
}

function create_response(
    \Psr\Container\ContainerInterface $container,
    \Psr\Http\Message\RequestInterface $request,
): \Psr\Http\Message\ResponseInterface {
    $strategy = (new \Rathwork\RouteThrowableStrategy())->setContainer($container);
    $router = (new \League\Route\Router())->setStrategy($strategy);
    require ROOT_DIR . '/src/routes.php';

    return $router->dispatch($request);
}

function send_response(\Psr\Http\Message\ResponseInterface $response): void
{
    (new \Laminas\HttpHandlerRunner\Emitter\SapiEmitter())->emit($response);
}

register_error_handler();
$container = create_container();
$request = create_request();
$response = create_response($container, $request);
send_response($response);
