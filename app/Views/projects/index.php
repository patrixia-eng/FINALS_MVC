<?php $title = 'Projects'; ?>

<div class="top-bar">
    <h1>Projects</h1>
    <a href="/projects/create" class="btn">Add New Project</a>
</div>

<?php if (empty($projects)): ?>
    <p>No projects found.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($projects as $project): ?>
        <tr>
            <td><a href="/projects/<?= (int) $project['id'] ?>"><?= htmlspecialchars($project['name']) ?></a></td>
            <td><?= htmlspecialchars($project['description'] ?? '') ?></td>
            <td class="actions">
                <a href="/projects/<?= (int) $project['id'] ?>/edit">Edit</a>
                <form method="post" action="/projects/<?= (int) $project['id'] ?>/delete" class="inline-form" onsubmit="return confirm('Delete?');">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
