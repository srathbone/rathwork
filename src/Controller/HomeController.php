<?php
declare(strict_types=1);

namespace Rathwork\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rathwork\Framework\Renderer\TemplateRenderer;

final class HomeController
{
    public function __construct(private TemplateRenderer $renderer)
    {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return response($this->renderer->render('home'));
    }
}
