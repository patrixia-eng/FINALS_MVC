<?php $title = 'Tasks'; ?>

<div class="top-bar">
    <h1>All Tasks</h1>
    <a href="/tasks/create" class="btn">Add New Task</a>
</div>

<?php if (empty($tasks)): ?>
    <p>No tasks found.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Title</th>
            <th>Project</th>
            <th>Due Date</th>
            <th>Status</th>
            <th></th>
        </tr>
        <?php foreach ($tasks as $task): ?>
            <?php
            $overdue = !empty($task['due_date'])
                && $task['status'] !== 'completed'
                && $task['due_date'] < date('Y-m-d');
            ?>
        <tr class="<?= $overdue ? 'overdue' : '' ?>">
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><a href="/projects/<?= (int) $task['project_id'] ?>"><?= htmlspecialchars($task['project_name'] ?? '') ?></a></td>
            <td><?= htmlspecialchars($task['due_date'] ?? '-') ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
            <td><a href="/tasks/<?= (int) $task['id'] ?>/edit">Edit</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
