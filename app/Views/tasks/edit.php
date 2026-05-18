<?php $title = 'Edit Task'; ?>

<h1>Edit Task</h1>

<?php include __DIR__ . '/../partials/errors.php'; ?>

<form method="post" action="/tasks/<?= (int) $task['id'] ?>">
    <input type="hidden" name="_method" value="PUT">

    <label>
        Project *
        <select name="project_id" required>
            <?php foreach ($projects as $project): ?>
                <option value="<?= (int) $project['id'] ?>" <?= ((int) ($task['project_id'] ?? 0) === (int) $project['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($project['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>
        Title *
        <input type="text" name="title" value="<?= htmlspecialchars($task['title'] ?? '') ?>" required>
    </label>

    <label>
        Description
        <textarea name="description" rows="3"><?= htmlspecialchars($task['description'] ?? '') ?></textarea>
    </label>

    <label>
        Due Date
        <input type="date" name="due_date" value="<?= htmlspecialchars($task['due_date'] ?? '') ?>">
    </label>

    <label>
        Status
        <select name="status">
            <?php foreach ($statuses as $opt): ?>
                <option value="<?= htmlspecialchars($opt['value']) ?>" <?= (($task['status'] ?? '') === $opt['value']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($opt['label']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <button type="submit" class="btn">Update</button>
    <a href="/projects/<?= (int) ($task['project_id'] ?? 0) ?>">Back</a>
</form>

<br>

<form method="post" action="/tasks/<?= (int) $task['id'] ?>/delete" onsubmit="return confirm('Delete this task?');">
    <input type="hidden" name="_method" value="DELETE">
    <button type="submit" class="btn btn-danger">Delete Task</button>
</form>
