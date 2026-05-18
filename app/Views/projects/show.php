<?php $title = $project['name']; ?>

<h1><?= htmlspecialchars($project['name']) ?></h1>
<p><?= htmlspecialchars($project['description'] ?? '') ?></p>

<p>
    <a href="/tasks/create?project_id=<?= (int) $project['id'] ?>" class="btn">Add Task</a>
    <a href="/projects/<?= (int) $project['id'] ?>/edit">Edit Project</a>
</p>

<h2>Tasks for this project</h2>

<?php if (empty($tasks)): ?>
    <p>No tasks yet.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Title</th>
            <th>Due Date</th>
            <th>Status</th>
            <th></th>
        </tr>
        <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['due_date'] ?? '-') ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
            <td><a href="/tasks/<?= (int) $task['id'] ?>/edit">Edit</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<p><a href="/projects">Back to Projects</a></p>
