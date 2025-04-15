<?php
declare(strict_types=1);

namespace Rathwork\Middleware;

use OutOfBoundsException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Rathwork\Framework\Renderer\TemplateRenderer;
use Throwable;

final readonly class ErrorHandler implements MiddlewareInterface
{
    public function __construct(
        private bool $isProduction,
        private TemplateRenderer $renderer
    ) {}

    #[Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$this->isProduction) {
            return $handler->handle($request);
        }

        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            return $this->handleException($request, $e);
        }
    }

    private function handleException(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        $body = $this->renderer->render('error500');
        $response = response($body);

        if ($exception instanceof OutOfBoundsException) {
            $response = $response->withStatus(404);
        } else {
            $response = $response->withStatus(500);
        }

        return $response;
    }
}
