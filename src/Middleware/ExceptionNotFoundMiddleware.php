<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Throwable;

class ExceptionNotFoundMiddleware
{
    protected array $options;

    /**
     * Example middleware invokable class
     *
     * @param  Request  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (HttpNotFoundException $exception) {
           
        $data['error'] = [
            'status' => $exception->getCode(),
            'message' => "Página não encontrada"
        ];

        if ($_ENV['APP_ENV'] === 'dev') {
            $data['error']['type'] = get_class($exception);
            $data['error']['trace'] = $exception->getTraceAsString();
            $data['error']['line'] = $exception->getFile() . ': ' . $exception->getLine();
        }

        $response = (new Response(
            404, 
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream(json_encode($data))
        ));
        
        return $response;
        throw $exception;
        }
    }
}
