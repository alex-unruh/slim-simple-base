<?php

namespace core\classes;

use Slim\Psr7\Response;

/**
 * Classe mãe para genrenciamento de serviços
 */
class Service
{

  protected $request;
  protected $response;

  /**
   * Ennvia uma resposta json
   *
   * @param array $data
   * @param integer $status
   * @return Response
   */
  protected function sendResponse(array $data, int $status = 200): Response
  {
    if (!isset($this->response)) $this->response = new Response();
    $json_data = json_encode($data);
    $this->response->getBody()->write($json_data);
    return $this->response->withHeader('Content-Type', 'application/json')->withStatus($status);
  }
}
