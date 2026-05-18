<?php

declare(strict_types=1);

namespace Core\Http;

final class Request
{
    /** @param array<string, string> $routeParams */
    public function __construct(
        private string $method,
        private string $uri,
        private array $query = [],
        private array $body = [],
        private array $server = [],
        private array $routeParams = [],
    ) {}

    public static function capture(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $uri = rtrim($uri, '/') ?: '/';

        $body = $_POST;
        if ($method === 'POST' && ($_POST['_method'] ?? '') !== '') {
            $method = strtoupper((string) $_POST['_method']);
        }

        return new self(
            $method,
            $uri,
            $_GET,
            $body,
            $_SERVER,
        );
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    /** @return array<string, string> */
    public function query(): array
    {
        return $this->query;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }

    /** @return array<string, mixed> */
    public function all(): array
    {
        return array_merge($this->query, $this->body);
    }

    public function setRouteParams(array $params): void
    {
        $this->routeParams = $params;
    }

    public function route(string $key, mixed $default = null): mixed
    {
        return $this->routeParams[$key] ?? $default;
    }
}
