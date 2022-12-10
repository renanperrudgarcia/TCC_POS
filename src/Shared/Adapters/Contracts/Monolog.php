<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Contracts;

interface Monolog
{
    public function info(string $message, array $dados): bool;
}
