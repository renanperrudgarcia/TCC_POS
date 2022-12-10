<?php

declare(strict_types=1);

namespace App\Login\Domain\ValueObjects;

use App\Shared\Domain\Constants\HttpStatusCode;
use DomainException;
use Fig\Http\Message\StatusCodeInterface;

final class User
{
    private string $user;

    public function __construct(string $name, string $user)
    {
        if (empty($name)) {
            throw new DomainException("Campo nome não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        if (empty($user)) {
            throw new DomainException("Campo usuário não pode ser vazio.", StatusCodeInterface::STATUS_BAD_REQUEST);
        }

        $this->name = $name;
        $this->user = $user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUser(): string
    {
        return $this->user;
    }
}
