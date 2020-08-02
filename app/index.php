<?php

include_once 'helper.php';

$categoryId = $_GET['category'] ?? null;
$title = isset($_GET['category']) ? getCategoryName($categoryId) : 'Все новости';

$currentPage = $_GET['page'] ?? 1;
$prevPage = $currentPage - 1;
$nextPage = $currentPage + 1;

$uriPrevPage = '?page=' . $prevPage;
$uriNextPage = '?page=' . $nextPage;

if($categoryId){
    $uriPrevPage .= '&category=' . $categoryId;
    $uriNextPage .= '&category=' . $categoryId;
}

$news = getNewsList($categoryId);

$content = render('views/news-list.php', [
    'title' => $title,
    'isAuthenticated' => isAuthenticated(),
    'news' => $news,
    'uriPrevPage' => ($prevPage != 0) ? $uriPrevPage : null,
    'uriNextPage' => $uriNextPage,
]);

echo buildPage($content, $title);
