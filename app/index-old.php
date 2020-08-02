<?php include_once 'helper-old.php'; ?>

<div> <?php include 'header.php'; ?> </div>

<div>
<?php
$categoryName = 'Все новости';
$categoryId = 'default';

if(isset($_GET['category'])){
    $categoryId = $_GET['category'];
    $categoryName = getCategoryName($_GET['category']);
}

$news = getNewsList($categoryId);
showList($news, $categoryName);
?>
</div>

<div> <?php include 'footer.php'; ?> </div>
