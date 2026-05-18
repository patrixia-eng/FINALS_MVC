<?php $title = 'Add Task'; ?>

<h1>Add New Task</h1>

<?php include __DIR__ . '/../partials/errors.php'; ?>

<form method="post" action="/tasks">
    <label>
        Project *
        <select name="project_id" required>
            <option value="">-- select --</option>
            <?php foreach ($projects as $project): ?>
                <option value="<?= (int) $project['id'] ?>" <?= ((string) ($old['project_id'] ?? '') === (string) $project['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($project['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>
        Title *
        <input type="text" name="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>" required>
    </label>

    <label>
        Description
        <textarea name="description" rows="3"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </label>

    <label>
        Due Date
        <input type="date" name="due_date" value="<?= htmlspecialchars($old['due_date'] ?? '') ?>">
    </label>

    <label>
        Status *
        <select name="status">
            <?php foreach ($statuses as $opt): ?>
                <option value="<?= htmlspecialchars($opt['value']) ?>" <?= (($old['status'] ?? 'pending') === $opt['value']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($opt['label']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <button type="submit" class="btn">Save</button>
    <a href="/tasks">Cancel</a>
</form>
