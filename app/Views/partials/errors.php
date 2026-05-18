<?php if (!empty($errors)): ?>
<div class="error-box">
    <strong>Please fix the following:</strong>
    <ul>
        <?php foreach ($errors as $fieldErrors): ?>
            <?php foreach ($fieldErrors as $msg): ?>
                <li><?= htmlspecialchars($msg) ?></li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
