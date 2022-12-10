<?php

declare(strict_types=1);

namespace App\Shared\Adapters\Contracts;

use Psr\Http\Message\ResponseInterface as Response;

interface HttpClient
{
    public function get(string $uri, array $params = []): Response;
    public function post(string $uri, array $params = []): Response;
    public function request(string $method, string $url, ?array $options = []): Response;
}
