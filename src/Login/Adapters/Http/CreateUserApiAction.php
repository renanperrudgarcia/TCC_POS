<?php

declare(strict_types=1);

namespace App\Login\Adapters\Http;

use App\Login\UseCases\User\CreateUserApiUseCase;
use App\Login\UseCases\User\CreateUserInputBoundary;
use App\Shared\Adapters\Http\PayloadAction;

final class CreateUserApiAction extends PayloadAction
{
    private CreateUserApiUseCase $useCase;

    public function __construct(CreateUserApiUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    protected function handle(): array
    {
        $name = $this->body["name"];
        $user = $this->body["user"];
        $password = $this->body["password"];
        $input = new CreateUserInputBoundary($name, $user, $password);

        return $this->useCase->handle($input);
    }
}
