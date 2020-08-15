<h1><?= $title ?? 'Все новости' ?></h1>

<!--pagination-->
<div class="center">
    <?php if (isset($uriPrevPage)): ?>
        <a href="<?= $uriPrevPage ?>">Prev</a>
    <?php endif; ?>

    <?php if (isset($uriNextPage)): ?>
        <a href="<?= $uriNextPage ?>">Next</a>
    <?php endif; ?>
</div>

<!--button create-->
<?php if ($is_admin): ?>
    <a href="<?= $uri_create ?>"><button>Добавить новость</button></a>
<?php endif; ?>

<!--news-->
<div class="brd">
<table rules="all" align="center" border="1">
    <tr>
        <th>№</th>

        <?php if ($is_admin): ?>
        <th width="150">Действие</th>
        <?php endif; ?>

        <th width="250">Изображение</th>

        <th width="250">Заголовок</th>
        <th width="100">Автор</th>
        <th width="100">Категория</th>
        <th width="300">Текст новости</th>
        <th width="200">Дата добавления</th>
        <th width="200">Дата редактирования (последнего)</th>
    </tr>

    <?php foreach ($news as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>

        <?php if ($is_admin): ?>
        <td>
            <a href="<?= $row['uri_edit'] ?>"><button>Редактировать</button></a>

            <form method="post" action="<?= $uri_parent ?>">
                <input type="hidden" name="delete">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="submit" value="Удалить">
            </form>
        </td>
        <?php endif; ?>

        <td>
            <?php if (isset($row['path_image'])): ?>
                <img src="<?= $row['path_image'] ?>" width="100">
            <?php endif; ?>
        </td>

        <td><a href="<?= $row['uri'] ?>"><?= $row['title'] ?></a></td>
        <td><?= $row['author'] ?></td>
        <td><?= $row['category'] ?></td>
        <td><a href="<?= $row['uri'] ?>"><?= $row['description'] ?></a></td>
        <td><?= $row['created_at'] ?></td>
        <td><?= $row['updated_at'] ?></td>

    </tr>
    <?php endforeach; ?>

</table>
</div>

<!--pagination-->
<div class="center">
    <?php if (isset($uriPrevPage)): ?>
        <a href="<?= $uriPrevPage ?>">Prev</a>
    <?php endif; ?>

    <?php if (isset($uriNextPage)): ?>
        <a href="<?= $uriNextPage ?>">Next</a>
    <?php endif; ?>
</div>
