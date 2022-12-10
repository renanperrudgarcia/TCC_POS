<?php

declare(strict_types=1);

namespace App\Login\UseCases\Login;

use App\Login\Domain\Login;
use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use App\Shared\Domain\Constants\HttpStatusCode;
use App\Shared\Domain\Entity\Usuario;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class LoginUseCase
{
    private UserApiRepositoryInterface $userApiRepository;

    public function __construct(UserApiRepositoryInterface $userApiRepository)
    {
        $this->userApiRepository = $userApiRepository;
    }

    public function handle(LoginInputBoundary $input): Usuario
    {
        try {
            $user = $input->getUser();
            $login = $this->userApiRepository->findUserApi($user);

            if (!$login) {
                throw new Exception("Não foi encontrado nenhum usuario.", StatusCodeInterface::STATUS_BAD_REQUEST);
            }

            $verifyPassword =  password_verify($input->getPassword(), $login->getSenha());

            if (!$verifyPassword) {
                throw new Exception("Usuário ou Senha incorretos.", StatusCodeInterface::STATUS_UNAUTHORIZED);
            }

            return $login;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
