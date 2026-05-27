<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? 'Task Manager') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <a href="/" class="logo">Task Manager</a>
        <a href="/">Home</a>
        <a href="/projects">Projects</a>
        <a href="/tasks">Tasks</a>
        <a href="/projects/create">+ Project</a>
        <a href="/tasks/create">+ Task</a>
    </header>

    <main>
        <?= $content ?? '' ?>
    </main>

    <footer>
        MVC NI PAT - TRES lang sir 2026
    </footer>
</body>
</html>
