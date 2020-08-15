<div class="brd">
    <h1><?= $title ?></h1>

    <p>Дата создания: <?= $created_at ?></p>
    <p>Дата последнего обновления: <?= $updated_at ?></p>
    <p><?= $author ?></p>

    <?php if (isset($path_image)): ?>
        <img src="<?= $path_image ?>" width="600">
    <?php endif; ?>

    <pre><?= $description ?></pre>
</div>

<?php if ($is_admin): ?>
    <a href="<?= $uri_edit ?>"><button>Редактировать</button></a>

    <form method="post" action="<?= $uri_parent ?>">
        <input type="hidden" name="delete">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="submit" value="Удалить">
    </form>
<?php endif; ?>
