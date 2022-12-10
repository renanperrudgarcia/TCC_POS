<?php

declare(strict_types=1);

namespace App\Login\Domain\Factory;

use App\Login\Domain\Login;

final class LoginFactory
{
    public static function create(?array $values = []): ?Login
    {
        if (empty($values)) {
            return null;
        }

        $login = new Login();
        $login->fill($values);

        return $login;
    }
}
