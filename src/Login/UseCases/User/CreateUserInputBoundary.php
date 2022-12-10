<?php

declare(strict_types=1);

namespace App\Login\UseCases\User;

use App\Login\Domain\ValueObjects\Password;
use App\Login\Domain\ValueObjects\User;
use Exception;

final class CreateUserInputBoundary
{
    private User $user;
    private Password $password;

    public function __construct(string $name, string $user, string $password)
    {
        try {
            $this->user = new User($name, $user);
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

    public function getCryptPassword(): string
    {
        $options = ["cost" => 10];
        $cryptPassword = password_hash($this->password->getPassword(), PASSWORD_BCRYPT, $options);

        return $cryptPassword;
    }
}
