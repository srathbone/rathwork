<?php
declare(strict_types=1);

$container = new \League\Container\Container();

$container
    ->add(\Rathwork\Middleware\ErrorHandler::class)
    ->addArgument(isProduction())
    ->addArgument(\Rathwork\Framework\Renderer\TemplateRenderer::class);

$container->add(
    \Rathwork\Framework\Renderer\TemplateRenderer::class,
    static function (): \Rathwork\Framework\Renderer\TemplateRenderer {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT_DIR . '/resources/templates');
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twigRenderer = new \Rathwork\Framework\Renderer\TwigTemplateRenderer($twig);

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        return mb_strpos($userAgent, 'curl/') === 0 || mb_strpos($userAgent, 'Wget/') === 0  ?
            new \Rathwork\Framework\Renderer\CliTemplateRenderer(
                ROOT_DIR . '/resources/templates',
                $twigRenderer
            ) :
            $twigRenderer;
    }
);

$container
    ->add(Rathwork\Controller\HomeController::class)
    ->addArgument(Rathwork\Framework\Renderer\TemplateRenderer::class);

return $container;
