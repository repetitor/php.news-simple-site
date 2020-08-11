<h1>View test</h1>

<?= $paramTest ?>

<?php if ($isAdmin): ?>
    <p>hasPermissionChange - true</p>
<?php else: ?>
    <p>hasPermissionChange - false</p>
<?php endif; ?>
