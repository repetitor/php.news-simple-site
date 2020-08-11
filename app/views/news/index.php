<h1><?= $title ?? 'Все новости' ?></h1>

<!--pagination-->
<div class="center">
    <?php if ($uriPrevPage): ?>
        <a href="<?= $uriPrevPage ?>">Prev</a>
    <?php endif; ?>

    <?php if ($uriNextPage): ?>
        <a href="<?= $uriNextPage ?>">Next</a>
    <?php endif; ?>
</div>

<!--button create-->
<?php if ($has_permission_change): ?>
    <a href="<?= $uri_create ?>"><button>Добавить</button></a>
<?php endif; ?>

<!--news-->
<table rules="all">
    <tr>
        <th>№</th>

        <?php if ($has_permission_change): ?>
        <th>Действие</th>
        <?php endif; ?>

        <th>Заголовок</th>
        <th>Автор</th>
        <th>Категория</th>
        <th>Текст новости</th>
        <th width="100">Дата добавления</th>
        <th width="100">Дата редактирования (последнего)</th>
    </tr>

    <?php foreach ($news as $row): ?>
    <tr>
        <td><?= $row['id'] ?></td>

        <?php if ($has_permission_change): ?>
        <td>
            <a href="<?= $row['uri_edit'] ?>"><button>Редактировать</button></a>
            <a href="<?= $row['uri_delete'] ?>"><button>DELETE</button></a>
        </td>
        <?php endif; ?>

        <td><a href="<?= $row['uri'] ?>"><?= $row['title'] ?></a></td>
        <td><?= $row['author'] ?></td>
        <td><?= $row['category'] ?></td>
        <td><a href="<?= $row['uri'] ?>"><?= $row['description'] ?></a></td>
        <td><?= $row['created_at'] ?></td>
        <td><?= $row['updated_at'] ?></td>

    </tr>
    <?php endforeach; ?>

</table>

<!--pagination-->
<div class="center">
    <?php if ($uriPrevPage): ?>
        <a href="<?= $uriPrevPage ?>">Prev</a>
    <?php endif; ?>

    <?php if ($uriNextPage): ?>
        <a href="<?= $uriNextPage ?>">Next</a>
    <?php endif; ?>
</div>
