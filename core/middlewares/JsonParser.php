<?php

namespace core\middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Middleware para converter o body em requisições JSON para array
 */
class JsonParser
{

  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $contentType = $request->getHeaderLine('Content-Type');
    if (strstr($contentType, 'application/json')) {
      $contents = json_decode(file_get_contents('php://input'));
      if (json_last_error() === JSON_ERROR_NONE) {
        $request = $request->withParsedBody($contents);
      }
    }

    return $handler->handle($request);
  }
}
