<?php
declare(strict_types=1);

namespace Rathwork\Framework\Renderer;

final readonly class CliTemplateRenderer implements TemplateRenderer
{
    public function __construct(
        private string $pathToTemplates,
        private TemplateRenderer $htmlRenderer,
    ) {}

    #[Override]
    public function render(string $template, array $data = []): string
    {
        $cliTemplate = sprintf('%s.txt', $template);
        $templatePath = sprintf('%s/%s', $this->pathToTemplates, $cliTemplate);

        if (file_exists($templatePath)) {
            $templateData = [];
            foreach ($data as $key => $value) {
                $templateData[sprintf('%%%%%s%%%%', $key)] = $value;
            }

            $templateContents = file_get_contents($templatePath);
            return str_replace(array_keys($templateData), array_values($templateData), $templateContents);
        }

        return $this->htmlRenderer->render($template, $data);
    }
}
