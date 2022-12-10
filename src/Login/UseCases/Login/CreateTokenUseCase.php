<?php

declare(strict_types=1);

namespace App\Login\UseCases\Login;

use App\Shared\Domain\Entity\Usuario;
use Exception;
use Firebase\JWT\JWT;

final class CreateTokenUseCase
{
    public function handle(array $config, Usuario $login): string
    {
        try {
            $expiration = time() + (24 * 60 * 60); // 24 horas
            $payload = [
                "iss" => "unialfa.com.br",
                "iat" => time(),
                "exp" => $expiration,
                'data' => $login->getNome()
            ];
            $key = $config["key"];
            $algorithm = $config["algorithm"];

            $jwt = JWT::encode($payload, $key, $algorithm);

            return $jwt;
        } catch (Exception $exception) {
            throw new Exception("Erro ao gerar token.", $exception->getCode());
        }
    }
}
