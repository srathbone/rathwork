<?php
declare(strict_types=1);

namespace Rathwork\Framework\Renderer;

interface TemplateRenderer
{
    public function render(string $template, array $data = []): string;
}
