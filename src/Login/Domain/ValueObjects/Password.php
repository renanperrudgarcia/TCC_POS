<?php

declare(strict_types=1);

namespace App\Login\Domain\ValueObjects;

use App\Shared\Domain\Constants\HttpStatusCode;
use DomainException;
use Fig\Http\Message\StatusCodeInterface;

final class Password
{
    private string $password;

    public function __construct(string $password)
    {
        if (empty($password)) {
            throw new DomainException("Campo senha não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
