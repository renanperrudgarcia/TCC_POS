<?php

declare(strict_types=1);

namespace App\Login\Adapters\Http;

use App\Login\UseCases\Login\CreateTokenUseCase;
use App\Login\UseCases\Login\LoginInputBoundary;
use App\Login\UseCases\Login\LoginUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use Exception;
use Psr\Container\ContainerInterface;

class LoginAction extends PayloadAction
{
    private LoginUseCase $loginUseCase;
    private CreateTokenUseCase $createTokenUseCase;
    private $container;

    public function __construct(
        LoginUseCase $loginUseCase,
        CreateTokenUseCase $createTokenUseCase,
        ContainerInterface $container
    ) {
        $this->loginUseCase = $loginUseCase;
        $this->createTokenUseCase = $createTokenUseCase;
        $this->container = $container;
    }

    protected function handle(): array
    {
        try {
            $user = $this->body["user"];
            $password = $this->body["password"];
            $input = new LoginInputBoundary($user, $password);

            $login = $this->loginUseCase->handle($input);
            $configJwt = $this->container->get('config')['jwt'];
            $token = $this->createTokenUseCase->handle($configJwt, $login);

            return ['token' => $token];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
