<h1>View test</h1>

<p>
    <?= $param_test ?>
</p>

<p>
    <?= $param_test2 ?>
</p>

<p>
    <?php if (isset($is_admin)): ?>
        <p>is admin isset - true</p>
    <?php else: ?>
        <p>is admin isset - false</p>
    <?php endif; ?>
</p>
