<?php

namespace app\services;

use core\classes\Service;
use AlexUnruh\Config\Config;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Classe modelo para serviços
 * @author Alexandre Unruh <alexandre@sincronica.com.br>
 */
class ExampleService extends Service
{

  /**
   * Método de entrada
   *
   * @param ServerRequestInterface $request
   * @param ResponseInterface $response
   * @param array $args
   * @return ResponseInterface
   */
  public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
  {
    $this->request = $request->getParsedBody();
    $this->response = $response;

    $app_name = Config::get('app.app_name');
    $app_version= Config::get('app.app_version');

    return $this->sendResponse(['status' => true, 'message' => 'Welcome from ' . $app_name . ' - version ' . $app_version ]);
  }
}
