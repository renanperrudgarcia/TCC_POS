<?php

declare(strict_types=1);

namespace App\Login\Adapters\Http;

use App\Login\UseCases\Login\ValidateTokenUseCase;
use App\Shared\Adapters\Http\PayloadAction;
use Exception;

class ValidateTokenAction extends PayloadAction
{
    private ValidateTokenUseCase $useCase;

    public function __construct(ValidateTokenUseCase $validateTokenUseCase)
    {
        $this->useCase = $validateTokenUseCase;
    }

    protected function handle(): array
    {
        try {
            $token = $this->request->getHeaderLine('Authorization');
            $validateToken = $this->useCase->handle($token);

            return ["token" => $validateToken];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
