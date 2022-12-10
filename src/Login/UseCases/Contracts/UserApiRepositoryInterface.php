<?php

declare(strict_types=1);

namespace App\Login\UseCases\Contracts;

use App\Login\Domain\ValueObjects\User;
use App\Shared\Domain\Entity\Usuario;

interface UserApiRepositoryInterface
{
    public function findUserApi(string $user): ?Usuario;
    public function insertUserApi(User $user, string $password): void;
}
