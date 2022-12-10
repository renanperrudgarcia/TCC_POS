<?php

declare(strict_types=1);

namespace App\Login\Adapters\Http;

use App\Login\UseCases\Login\CreateTokenUseCase;
use App\Login\UseCases\Login\LoginInputBoundary;
use App\Login\UseCases\Login\LoginUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use DomainException;
use Exception;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Container\ContainerInterface;

class LoginAction extends PayloadAction
{
    private LoginUseCase $loginUseCase;
    private CreateTokenUseCase $createTokenUseCase;
    private $container;
    private string $user;
    private string $password;

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
            $this->ValidateInput($this->body);

            $input = new LoginInputBoundary($this->user, $this->password);

            $login = $this->loginUseCase->handle($input);
            $configJwt = $this->container->get('config')['jwt'];
            $token = $this->createTokenUseCase->handle($configJwt, $login);

            return ['token' => $token];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    protected function ValidateInput(array $input)
    {


        if (empty($input['user'])) {
            throw new DomainException("Campo usuário não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (empty($input['password'])) {
            throw new DomainException("Campo senha não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $this->user = $input['user'];
        $this->password = $input['password'];
    }
}
