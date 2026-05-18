<?php $title = 'Edit Project'; ?>

<h1>Edit Project</h1>

<?php include __DIR__ . '/../partials/errors.php'; ?>

<form method="post" action="/projects/<?= (int) $project['id'] ?>">
    <input type="hidden" name="_method" value="PUT">

    <label>
        Project Name *
        <input type="text" name="name" value="<?= htmlspecialchars($project['name'] ?? '') ?>" required>
    </label>

    <label>
        Description
        <textarea name="description" rows="3"><?= htmlspecialchars($project['description'] ?? '') ?></textarea>
    </label>

    <button type="submit" class="btn">Update</button>
    <a href="/projects/<?= (int) $project['id'] ?>">Cancel</a>
</form>
