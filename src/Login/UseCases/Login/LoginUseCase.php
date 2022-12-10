<?php

declare(strict_types=1);

namespace App\Login\UseCases\Login;

use App\Login\Domain\Login;
use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use App\Shared\Domain\Constants\HttpStatusCode;
use App\Shared\Domain\Entity\Usuario;
use Exception;

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
            $user = $input->getUser()->getUser();
            $login = $this->userApiRepository->findUserApi($user);
            echo '<pre>';
            print_r($login);
            exit;


            // $verifyPassword =  password_verify($input->getPassword()->getPassword(), $login->getPassword());

            // if (!$verifyPassword) {
            //     throw new Exception("Usuário ou Senha incorretos.", HttpStatusCode::UNAUTHORIZED);
            // }

            return $login;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
