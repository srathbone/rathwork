<?php
declare(strict_types=1);

namespace Rathwork\Framework\Renderer;

use Twig\Environment;

final readonly class TwigTemplateRenderer implements TemplateRenderer
{
    public function __construct(private Environment $twigEnvironment)
    {}

    #[Override]
    public function render(string $template, array $data = []): string
    {
        $template = sprintf('%s.html.twig', $template);
        return $this->twigEnvironment->render($template, $data);
    }
}
