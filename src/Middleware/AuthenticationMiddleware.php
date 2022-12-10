<?php

namespace App\Middleware;

use App\Login\UseCases\Login\ValidateTokenUseCase;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthenticationMiddleware
{
    private ValidateTokenUseCase $validateTokenUseCase;

    public function __construct(ValidateTokenUseCase $validateTokenUseCase)
    {
        $this->validateTokenUseCase = $validateTokenUseCase;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            $token = $request->getHeaderLine('Authorization');

            $validToken = $this->validateTokenUseCase->handle($token);

            if (!$validToken) {
                throw new Exception("Token inválido!", StatusCodeInterface::STATUS_UNAUTHORIZED);
            }

            return $handler->handle($request);
        } catch (Exception $exception) {
            throw new Exception('aa', 200);
        }
    }
}
