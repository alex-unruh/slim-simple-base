<?php

namespace app\controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Classe modelo para controllers
 */
class HomeController
{

  public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $response->getBody()->write('Hello from ' . $_ENV['APP_NAME']);
    return $response;
  }
}
