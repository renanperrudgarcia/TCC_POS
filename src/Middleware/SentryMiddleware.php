<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Throwable;

class SentryMiddleware
{
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
        } catch (Throwable $exception) {

            $data['error'] = [
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];

            if ($_ENV['APP_ENV'] === 'dev') {
                $data['error']['type'] = get_class($exception);
                $data['error']['trace'] = $exception->getTraceAsString();
                $data['error']['line'] = $exception->getFile() . ': ' . $exception->getLine();
            }

            return new Response(
                $exception->getCode() > 0 ? $exception->getCode() : 500,
                new Headers(['Content-Type' => 'application/json']),
                (new StreamFactory())->createStream(json_encode($data))
            );
            throw $exception;
        }
    }
}
