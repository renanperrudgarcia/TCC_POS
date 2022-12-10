<?php

declare(strict_types=1);

namespace App\Login\UseCases\Login;

use App\Shared\Domain\Constants\HttpStatusCode;
use Psr\Container\ContainerInterface;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class ValidateTokenUseCase
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function handle(string $token): bool
    {
        if (empty($token)) {
            throw new Exception('Token não informado na requisição', StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        list($jwt) = sscanf($token, 'Bearer %s');

        if (!$jwt) {
            throw new Exception('Formato do token é inválido', StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        return $this->validateToken($this->container->get('config')['jwt'], $jwt);
    }

    private function validateToken($configJwt, $jwt): bool
    {
        try {
            $token = JWT::decode($jwt, new Key($configJwt['key'], $configJwt['algorithm']));

            if (!$token) {
                return false;
            }

            return true;
        } catch (Exception $exception) {
            throw new Exception('Token inválido.', StatusCodeInterface::STATUS_UNAUTHORIZED);
        }
    }
}
