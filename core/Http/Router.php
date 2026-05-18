<?php

declare(strict_types=1);

namespace Core\Http;

// Handles URL routing for the framework
class Router
{
    /** @var list<array{method: string, pattern: string, action: array{class: class-string, method: string}}> */
    private array $routes = [];

    public function get(string $uri, array $action): void
    {
        $this->register('GET', $uri, $action);
    }

    public function post(string $uri, array $action): void
    {
        $this->register('POST', $uri, $action);
    }

    public function put(string $uri, array $action): void
    {
        $this->register('PUT', $uri, $action);
    }

    public function delete(string $uri, array $action): void
    {
        $this->register('DELETE', $uri, $action);
    }

    /** @param array{class: class-string, method: string} $action */
    public function register(string $method, string $uri, array $action): void
    {
        $uri = rtrim($uri, '/') ?: '/';
        $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $uri);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'action' => $action,
        ];
    }

    /**
     * @return array{action: array{class: class-string, method: string}, params: array<string, string>}|null
     */
    public function resolve(Request $request): ?array
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method()) {
                continue;
            }

            if (!preg_match($route['pattern'], $request->uri(), $matches)) {
                continue;
            }

            $params = [];
            foreach ($matches as $key => $value) {
                if (is_string($key)) {
                    $params[$key] = $value;
                }
            }

            return [
                'action' => $route['action'],
                'params' => $params,
            ];
        }

        return null;
    }
}
