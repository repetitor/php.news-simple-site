<?php include_once 'helper-old.php'; ?>

<hr/>

<h1>Все новости</h1>

<?php
$news = getNewsList();
showList($news);
?>
