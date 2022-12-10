<?php

declare(strict_types=1);

namespace App\Shared\Infra\Presentation\Payload;

use App\Shared\Adapters\Contracts\Presentation\PayloadPresenter;

/**
 * @OA\Server(url="http://localhost:8081")
 * @OA\Info(title="Slim OpenApi Introduction", version="0.1")
 */
final class JsonPresenter implements PayloadPresenter
{
    public function output(array $data, array $options = []): string
    {
        return json_encode($data);
    }
}
