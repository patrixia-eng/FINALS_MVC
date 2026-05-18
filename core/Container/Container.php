<?php

declare(strict_types=1);

namespace Core\Container;

use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

// Simple dependency injection container
class Container
{
    /** @var array<string, class-string|object|callable(): object> */
    private array $bindings = [];

    /** @var array<string, bool> */
    private array $singletons = [];

    /** @var array<string, object> */
    private array $instances = [];

    public function bind(string $abstract, string|object|callable $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function singleton(string $abstract, string|object|callable $concrete): void
    {
        $this->bind($abstract, $concrete);
        $this->singletons[$abstract] = true;
    }

    public function instance(string $abstract, object $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    public function make(string $abstract): object
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        $concrete = $this->bindings[$abstract] ?? $abstract;

        if (is_callable($concrete) && !is_string($concrete)) {
            $object = $concrete();
        } elseif (is_object($concrete)) {
            $object = $concrete;
        } else {
            $object = $this->build($concrete);
        }

        if (isset($this->singletons[$abstract])) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

  /** @param class-string $class */
    private function build(string $class): object
    {
        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new RuntimeException("Class {$class} is not instantiable.");
        }

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return $reflection->newInstance();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                    continue;
                }

                throw new RuntimeException("Cannot resolve parameter \${$parameter->getName()} for {$class}.");
            }

            $dependencies[] = $this->make($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
