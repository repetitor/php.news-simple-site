<h1><?= $title ?? 'Все новости' ?></h1>

<table rules="all">
    <tr>
        <th>№</th>

        <?php if ($isAuthenticated): ?>
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

        <?php if ($isAuthenticated): ?>
        <td><a href="edit.php"><button>Редактировать</button></a></td>
        <?php endif; ?>

        <td><a href="show-item.php"><?= $row['title'] ?>...</a></td>
        <td><?= $row['author'] ?></td>
        <td><?= $row['category'] ?></td>
        <td><a href="show-item.php?id=<?= $row['id'] ?>"><?= $row['description'] ?>...</a></td>
        <td><?= $row['created_at'] ?></td>
        <td><?= $row['updated_at'] ?></td>

    </tr>
    <?php endforeach; ?>

</table>

<!--pagination-->
<?php if ($uriPrevPage): ?>
    <a href="<?= $uriPrevPage ?>">Prev</a>
<?php endif; ?>

<?php if ($uriNextPage): ?>
    <a href="<?= $uriNextPage ?>">Next</a>
<?php endif; ?>



<?php




//// Find out how many items are in the table
//$total = connectBD()->query('
//SELECT
//COUNT(*)
//FROM
//news
//')->fetchColumn();
//
//// How many items to list per page
//$limit = 2;
//
//// How many pages will there be
//$pages = ceil($total / $limit);
//
//if(isset($_GET['page'])){
//$currentPage = $_GET['page'];
//} else {
//$currentPage = 1;
//}
//
//$prevPage = $currentPage - 1;
//$nextPage = $currentPage + 1;
//
//echo '<a href="index-old.php?page='.$prevPage.'">Prev</a>';
//echo '<a href="index-old.php?page='.$nextPage.'">Next</a>';
