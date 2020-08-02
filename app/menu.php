<a href="index-old.php">Все новости</a>

<?php
$sql = 'SELECT * FROM categories ORDER BY id ASC';

foreach (connectBD()->query($sql) as $row) {
    echo '<a href="index-old.php?category=' . $row['id'] . '">' . $row['name'] . '</a> ';
}
?>
