<?php

declare(strict_types=1);

namespace App\Reports\UseCases\User;

use App\Shared\Helpers\DTO;

final class UserOutputBoundary extends DTO
{
    public int $id;
    public string $nome;
    public int $tipoUsuario;
}
