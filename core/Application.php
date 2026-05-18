<?php

declare(strict_types=1);

namespace Core;

use Core\Container\Container;
use Core\Database\Connection;
use Core\Database\DatabaseDriver;
use Core\Database\MySQLDriver;
use Core\Database\SQLiteDriver;
use Core\Http\Dispatcher;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Router;
use Core\View\Engine;

// Main application class - bootstraps the framework
class Application
{
    private Container $container;
    private Router $router;

    private function __construct(
        private string $basePath,
    ) {
        $this->container = new Container();
        $this->container->instance(Container::class, $this->container);
        $this->router = new Router();
        $this->bootstrap();
    }

    public static function create(string $basePath): self
    {
        return new self($basePath);
    }

    public function container(): Container
    {
        return $this->container;
    }

    public function bind(string $abstract, string|object $concrete): void
    {
        $this->container->bind($abstract, $concrete);
    }

    public function run(): void
    {
        $request = Request::capture();
        $resolved = $this->router->resolve($request);

        if ($resolved === null) {
            Response::notFound('Page not found.')->send();
            return;
        }

        $request->setRouteParams($resolved['params']);
        $dispatcher = $this->container->make(Dispatcher::class);
        $dispatcher->dispatch($resolved['action'], $request)->send();
    }

    // load config, database, routes, and DI bindings
    private function bootstrap(): void
    {
        $appConfig = require $this->basePath . '/config/app.php';
        $dbConfig = require $this->basePath . '/config/database.php';

        $this->container->singleton(Engine::class, new Engine($appConfig['views_path']));

        $driver = match ($dbConfig['driver']) {
            'mysql' => new MySQLDriver(),
            default => new SQLiteDriver(),
        };

        $connectionConfig = $dbConfig['driver'] === 'mysql'
            ? $dbConfig['mysql']
            : $dbConfig['sqlite'];

        $this->container->singleton(DatabaseDriver::class, $driver);
        $this->container->singleton(Connection::class, new Connection($driver, $connectionConfig));

        $this->initializeDatabase();
        $this->registerApplicationBindings();
        $this->loadRoutes();
    }

    private function initializeDatabase(): void
    {
        $pdo = $this->container->make(Connection::class)->pdo();
        $schema = file_get_contents($this->basePath . '/database/schema.sql');

        if ($schema !== false) {
            $pdo->exec($schema);
        }
    }

    private function registerApplicationBindings(): void
    {
        $bindings = require $this->basePath . '/bootstrap/bindings.php';

        foreach ($bindings as $abstract => $concrete) {
            $this->container->bind($abstract, $concrete);
        }
    }

    private function loadRoutes(): void
    {
        $router = $this->router;
        $app = $this;
        require $this->basePath . '/routes/web.php';
    }

    public function router(): Router
    {
        return $this->router;
    }
}
