<?php

declare(strict_types=1);

namespace App\Login\UseCases\Login;

use App\Login\Domain\ValueObjects\Password;
use App\Login\Domain\ValueObjects\User;
use Exception;

final class LoginInputBoundary
{
    private User $user;
    private Password $password;

    public function __construct(string $user, string $password)
    {
        try {
            $this->user = new User($user);
            $this->password = new Password($password);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
