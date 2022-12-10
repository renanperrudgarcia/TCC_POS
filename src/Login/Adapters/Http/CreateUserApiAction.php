<?php

declare(strict_types=1);

namespace App\Login\Adapters\Http;

use App\Login\Domain\Exceptions\UserDomainException;
use App\Login\UseCases\User\CreateUserApiUseCase;
use App\Login\UseCases\User\CreateUserInputBoundary;
use App\Shared\Adapters\Http\PayloadAction;
use DomainException;
use Fig\Http\Message\StatusCodeInterface;

final class CreateUserApiAction extends PayloadAction
{
    private CreateUserApiUseCase $useCase;
    private string $name;
    private string $user;
    private string $password;
    private int $type_user;

    public function __construct(CreateUserApiUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    protected function handle(): array
    {
        $this->ValidateInput($this->body);

        $input = new CreateUserInputBoundary($this->name,  $this->user,  $this->password, $this->type_user);

        return $this->useCase->handle($input);
    }

    protected function ValidateInput(array $input)
    {
        if (empty($input['name'])) {
            throw new UserDomainException("Campo nome não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (empty($input['user'])) {
            throw new DomainException("Campo usuário não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (empty($input['password'])) {
            throw new DomainException("Campo senha não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (empty($input['type_user'])) {
            throw new DomainException("Campo tipo_usuario não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $this->name = $input['name'];
        $this->user = $input['user'];
        $this->password = $input['password'];
        $this->type_user = $input['type_user'];
    }
}
