<?php

declare(strict_types=1);

namespace App\Api\Adapters\Http;

use App\Shared\Adapters\Http\PayloadAction;

class ApiAction extends PayloadAction
{
    protected function handle(): array
    {
        return ["API" => "Servidor de Trabalho."];
    }
}
