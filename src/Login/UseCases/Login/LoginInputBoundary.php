<?php

declare(strict_types=1);

namespace App\Login\UseCases\Login;

use App\Login\Domain\ValueObjects\Login;
use Exception;

final class LoginInputBoundary
{
    private Login $login;

    public function __construct(string $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
