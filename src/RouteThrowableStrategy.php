<?php
declare(strict_types=1);

namespace Rathwork;

use League\Route\ContainerAwareInterface;
use League\Route\ContainerAwareTrait;
use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Server\MiddlewareInterface;
use Rathwork\Middleware\ErrorHandler;

final class RouteThrowableStrategy extends ApplicationStrategy implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    #[Override]
    public function getNotFoundDecorator(NotFoundException $exception): MiddlewareInterface
    {
        return $this->getContainer()->get(ErrorHandler::class);
    }

    #[Override]
    public function getMethodNotAllowedDecorator(MethodNotAllowedException $exception): MiddlewareInterface
    {
        return $this->getContainer()->get(ErrorHandler::class);
    }

    #[Override]
    public function getThrowableHandler(): MiddlewareInterface
    {
        return $this->getContainer()->get(ErrorHandler::class);
    }
}
