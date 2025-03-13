<?php
declare(strict_types=1);

use Laminas\Diactoros\Response;

function isProduction(): bool
{
    return APP_ENV === 'production';
}

function response(string $body): Response
{
    return responseHtml($body);
}

function responseHtml(string $body): Response
{
    $response = new Response();
    $response->getBody()->write($body);
    $response = $response->withHeader('Content-Type', 'text/html; charset=utf-8');

    return $response;
}

function responseJson(array $body): Response
{
    $response = new Response();
    $response->getBody()->write(json_encode($body));
    $response = $response->withHeader('Content-Type', 'application/json; charset=utf-8');

    return $response;
}
