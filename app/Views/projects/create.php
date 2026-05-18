<?php $title = 'Add Project'; ?>

<h1>Add New Project</h1>

<?php include __DIR__ . '/../partials/errors.php'; ?>

<form method="post" action="/projects">
    <label>
        Project Name *
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
    </label>

    <label>
        Description
        <textarea name="description" rows="3"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </label>

    <button type="submit" class="btn">Save</button>
    <a href="/projects">Cancel</a>
</form>
