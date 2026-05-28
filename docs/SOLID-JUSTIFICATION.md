# SOLID Justification

**Name:** Pantine Hernando
**Project:** PHP MVC Framework + Task Manager

This document explains how I applied the SOLID principles in my final project code.

---

## S - Single Responsibility Principle

I tried to give each class one main job:

- `Core\Http\Router` - only handles routing (register routes and match URL). It does not run the controller.
- `Core\Http\Dispatcher` - only calls the controller method after routing.
- `Core\Http\Request` - stores GET/POST data and route parameters.
- `Core\Http\Response` - handles HTTP response (html, redirect, status code).
- `App\Controllers\ProjectController` - handles project pages but does NOT write SQL directly. SQL is in the Model/Repository.

So the controller is separate from the database logic, and the router is separate from dispatching.

---

## O - Open/Closed Principle

For the database I made a `DatabaseDriver` interface. Then I created:

- `SQLiteDriver` (what I use for this project)
- `MySQLDriver` (optional, if I want MySQL later)

The `Connection` class uses the interface, so I can add a new driver without changing `Connection.php`. I only add a new class that implements `DatabaseDriver`.

In `Application.php` I pick the driver based on config:

```php
$driver = match ($dbConfig['driver']) {
    'mysql' => new MySQLDriver(),
    default => new SQLiteDriver(),
};
```

---

## L - Liskov Substitution Principle

Both `SQLiteDriver` and `MySQLDriver` implement `DatabaseDriver` and return a PDO connection. The `Connection` class expects a `DatabaseDriver`, so either driver can be used the same way without breaking the code.

---

## I - Interface Segregation Principle

Instead of one big interface for everything, I split database operations:

- `Core\Database\Findable` - `all()`, `find()`
- `Core\Database\Persistable` - `create()`, `update()`, `delete()`

My repository interfaces extend these. A read-only class could use only `Findable` and does not need to implement delete methods.

---

## D - Dependency Inversion Principle

Controllers depend on interfaces, not the actual repository class:

```php
public function __construct(
    private TaskRepositoryInterface $tasks,
    private ProjectRepositoryInterface $projects,
    ...
) {}
```

The binding is in `bootstrap/bindings.php`:

```php
TaskRepositoryInterface::class => TaskRepository::class,
```

The `Container` class resolves this when creating the controller. So high-level code (controllers) does not depend directly on low-level database code.

---

## Conclusion

I designed the framework so routing, HTTP, database, and views are separated. SOLID helped keep the code organized and easier to explain for the final project requirements.
