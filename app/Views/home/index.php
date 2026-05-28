<?php $title = 'Home'; ?>

<h1>Task Manager</h1>
<p>Welcome! This is my final project app for managing projects and tasks.</p>

<ul>
    <li><strong>Projects:</strong> <?= (int) $projectCount ?></li>
    <li><strong>Tasks:</strong> <?= (int) $taskCount ?></li>
    <li><strong>Pending tasks:</strong> <?= (int) $pendingCount ?></li>
    <li><strong>Completed tasks:</strong> <?= (int) $completedCount ?></li>
    <li><strong>Overdue tasks:</strong> <?= (int) $overdueCount ?></li>
</ul>

<h2>Recent Tasks</h2>

<?php if (empty($recentTasks)): ?>
    <p>No tasks yet. <a href="/tasks/create">Add a task</a></p>
<?php else: ?>
    <table>
        <tr>
            <th>Title</th>
            <th>Project</th>
            <th>Due Date</th>
            <th>Status</th>
        </tr>
        <?php foreach ($recentTasks as $task): ?>
        <tr>
            <td><a href="/tasks/<?= (int) $task['id'] ?>/edit"><?= htmlspecialchars($task['title']) ?></a></td>
            <td><?= htmlspecialchars($task['project_name'] ?? '') ?></td>
            <td><?= htmlspecialchars($task['due_date'] ?? '-') ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<p><a href="/projects">View Projects</a> | <a href="/tasks">View All Tasks</a></p>
