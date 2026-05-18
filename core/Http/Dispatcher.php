<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Container\Container;

final class Dispatcher
{
    public function __construct(
        private Container $container,
    ) {}

    /**
     * @param array{class: class-string, method: string} $action
     */
    public function dispatch(array $action, Request $request): Response
    {
        $class = $action['class'] ?? $action[0] ?? null;
        $method = $action['method'] ?? $action[1] ?? null;

        if (!is_string($class) || !is_string($method)) {
            return Response::notFound('Invalid route action.');
        }

        $controller = $this->container->make($class);

        if (!method_exists($controller, $method)) {
            return Response::notFound("Action {$method} not found.");
        }

        $result = $controller->{$method}($request);

        return $result instanceof Response ? $result : Response::html((string) $result);
    }
}
