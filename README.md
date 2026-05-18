# WEB Final Project - PHP MVC Framework + Task Manager

**Student:** Patricia  
**Subject:** Advanced Web Development (SP ELEC 2A)  
**MVP chosen:** Task Manager (projects, tasks, due dates, status)

This repository is my final examination project. I built a small MVC framework in PHP and a Task Manager app on top of it.

## Requirements to run

- PHP 8.0 or higher (tested with XAMPP)
- Composer
- PDO (SQLite is used by default)

## How to run (XAMPP / local)

1. Open terminal in the **WEB** folder
2. Run:

```
composer install
php -S 127.0.0.1:8080 -t public public/router.php
```

Or double-click **start.bat**

3. Open browser: http://127.0.0.1:8080

The database file is created automatically at `database/taskmanager.sqlite`.

## Folder structure

- `core/` - my MVC framework (router, request, response, database, container, views)
- `app/` - Task Manager application (controllers, models, views)
- `public/index.php` - front controller (entry point)
- `routes/web.php` - all routes
- `config/` - app and database settings
- `docs/SOLID-JUSTIFICATION.md` - explanation of SOLID in my code

## Routes list

| Method | URL | Description |
|--------|-----|-------------|
| GET | / | Home page |
| GET | /projects | List projects |
| GET | /projects/create | Add project form |
| POST | /projects | Save new project |
| GET | /projects/{id} | View project + tasks |
| GET | /projects/{id}/edit | Edit project form |
| POST | /projects/{id} | Update project |
| POST | /projects/{id}/delete | Delete project |
| GET | /tasks | List all tasks |
| GET | /tasks/create | Add task form |
| POST | /tasks | Save new task |
| GET | /tasks/{id}/edit | Edit task |
| POST | /tasks/{id} | Update task |
| POST | /tasks/{id}/delete | Delete task |

## What the Task Manager does

- Create/edit/delete **projects**
- Create/edit/delete **tasks** under a project
- Set **due date** and **status** (pending, in_progress, completed)
- Basic **form validation** (required fields, date check, etc.)
- Uses **SQLite** database (no setup needed)

## Framework notes (short)

- PSR-4 autoloading with `Core\` and `App\` namespaces
- Front controller pattern in `public/index.php`
- Router supports URL parameters like `/projects/{id}`
- DI container binds repository interfaces to concrete classes
- Separate `Router` and `Dispatcher` classes (Single Responsibility)

See `docs/SOLID-JUSTIFICATION.md` for more detail about SOLID principles.
