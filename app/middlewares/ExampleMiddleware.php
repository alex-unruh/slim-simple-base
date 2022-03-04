<?php

namespace app\middlewares;

use core\classes\Validation;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Middleware de Exemplo
 */
class ExampleMiddleware extends Validation
{

	/**
	 * Método de entrada
	 *
	 * @param Request $request
	 * @param RequestHandler $handler
	 * @return ResponseInterface
	 */
	public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
	{
    // Your logic here ...

		return $handler->handle($request);
	}
}
