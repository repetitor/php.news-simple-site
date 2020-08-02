<?php

function render($view, $data = null)
{
    if($data){
        extract($data);
    }
    ob_start();
    require $view;

    return ob_get_clean();
}

function buildPage($content, $title = 'Новости'){
    return render('views/main-template.php', [
        'content' => $content,
        'title' => $title,
        'categories' => getCategories(),
    ]);
}

/**
 * @return PDO|string
 */
function connectBD(){
    //$servername = "localhost";
    //$servername = "172.19.0.2";
    $servername = "db_service_1";
    $username = "root";
    $password = "12345678";
    $dbname = 'db';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch(PDOException $e) {
        return "Connection failed: " . $e->getMessage();
    }
}

function getNewsList($categoryId = null){
    $limit = 2; // How many items to list per page

    $currentPage = $_GET['page'] ?? 1;

    $offset = ($currentPage-1) * $limit;

    $sql = 'SELECT 
        news.id,
        news.name AS title, 
        authors.name AS author,
        categories.name AS category,
        news.description,
        news.created_at,
        news.updated_at
        FROM news 
        JOIN authors ON news.author_id = authors.id
        JOIN categories ON news.category_id = categories.id 
    ';

    if($categoryId){
        $sql .=' WHERE news.category_id = ' . $categoryId;
    }

    $sql .= ' ORDER BY news.id DESC LIMIT ' . $limit . ' OFFSET ' . $offset;

    $news = connectBD()->query($sql);

    $newsUpdated = [];

    foreach ($news as $item){
        $item['title'] = trimText($item['title'], 30);
        $item['description'] = trimText($item['description'], 150);

        array_push($newsUpdated, $item);
    }

    return $newsUpdated;
}

function getNewsItem($id){
    $sql = 'SELECT 
        news.name AS title, 
        authors.name AS author,
        categories.name AS category,
        news.description,
        news.created_at,
        news.updated_at
        FROM news 
        LEFT JOIN authors ON news.author_id = authors.id
        LEFT JOIN categories ON news.category_id = categories.id 
        WHERE news.id = ' . $id . ' 
        LIMIT 1
    ';

    return connectBD()->query($sql)->fetch();
}

function getCategories(){
    return connectBD()->query('SELECT * FROM categories ORDER BY id ASC');
}

function getCategoryName($id){
    if($id){
        $sql = 'SELECT name FROM categories WHERE id = ' . $id . ' LIMIT 1';

        return connectBD()->query($sql)->fetch()['name'];
    }
}

function trimText($text, $maxLength){
    $textMaxLength = substr($text, 0, $maxLength);
    $textWithoutSigns = rtrim($textMaxLength, "!,.-");

    return substr($textWithoutSigns, 0, strrpos($textWithoutSigns, ' '));
}
function isAuthenticated(){
    if(isset($_SESSION['auth']) && $_SESSION['auth'] == true){
        return true;
    } else {
        return false;
    }
}

//session_start();
//
//// authenication
//const LOGIN = 'admin';
//const PASSWORD = 'password';
//
//// check login-form
//if(isset($_POST['login']) && $_POST['login'] == LOGIN){
//    $loginAuth = true;
//} else {
//    $loginAuth = false;
//}
//
//if(isset($_POST['password']) && $_POST['password'] == PASSWORD){
//    $passwordAuth = true;
//} else {
//    $passwordAuth = false;
//}
//
//if($loginAuth && $passwordAuth){
//    $_SESSION['auth'] = true;
//}
//
//// check logout-form
//if(isset($_POST['exit'])){
//    $_SESSION['auth'] = false;
//}
//
//function isAuthenicated(){
//    if(isset($_SESSION['auth']) && $_SESSION['auth'] == true){
//        return true;
//    } else {
//        return false;
//    }
//}
//
///**
// * @return PDO|string
// */
//function connectBD(){
//    //$servername = "localhost";
//    //$servername = "172.19.0.2";
//    $servername = "db_service_1";
//    $username = "root";
//    $password = "12345678";
//    $dbname = 'db';
//
//    try {
//        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//        // set the PDO error mode to exception
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
////        echo "Connected successfully";
//        return $conn;
//    } catch(PDOException $e) {
////        echo "Connection failed: " . $e->getMessage();
//        return $e->getMessage();
//    }
//}
//
//function trimText($text, $maxLength){
//    $textMaxLength = substr($text, 0, $maxLength);
//    $textWithoutSigns = rtrim($textMaxLength, "!,.-");
//
//    return substr($textWithoutSigns, 0, strrpos($textWithoutSigns, ' '));
//}
//
//function getNews($categoryId = 'default'){
//    // Find out how many items are in the table
//    $total = connectBD()->query('
//        SELECT
//            COUNT(*)
//        FROM
//            news
//    ')->fetchColumn();
//
//    // How many items to list per page
//    $limit = 2;
//
//    // How many pages will there be
//    $pages = ceil($total / $limit);
//
//    if(isset($_GET['page'])){
//        $currentPage = $_GET['page'];
//    } else {
//        $currentPage = 1;
//    }
//
//    $offset = ($currentPage-1) * $limit;
//
//    $sql = 'SELECT
//        news.id,
//        news.name AS title,
//        authors.name AS author,
//        categories.name AS category,
//        news.description,
//        news.created_at,
//        news.updated_at
//        FROM news
//        JOIN authors ON news.author_id = authors.id
//        JOIN categories ON news.category_id = categories.id
//    ';
//
//    if($categoryId != 'default'){
//        $sql .=' WHERE news.category_id = ' . $categoryId;
//    }
//
//    $sql .= ' ORDER BY news.id DESC LIMIT ' . $limit . ' OFFSET ' . $offset;
//
//    return connectBD()->query($sql);
//}
//
//function showList($news, $categoryName){
//    echo '<h1>' . $categoryName . '</h1>';
//
//    echo '
//<table rules="all">
//    <tr>
//        <th>№</th>';
//
//        if (isAuthenicated()) {
//            echo '<th>Действие</th>';
//        }
//
//        echo '
//        <th>Заголовок</th>
//        <th>Автор</th>
//        <th>Категория</th>
//        <th>Текст новости</th>
//        <th width="100">Дата добавления</th>
//        <th width="100">Дата редактирования (последнего)</th>
//    </tr>';
//
//    foreach ($news as $row) {
//        echo '<tr>';
//        echo '<td>' . $row['id'] . '</td>';
//
//        if (isAuthenicated()) {
//            echo '<td><a href="edit.php"><button>Редактировать</button></a></td>';
//        }
//
//        echo '<td><a href="show-item.php">' . trimText($row['title'], 30) . '...</a></td>';
//        echo '<td>' . $row['author'] . '</td>';
//        echo '<td>' . $row['category'] . '</td>';
//        echo '<td><a href="show-item.php?id='. $row['id'] .'">' . trimText($row['description'], 150) . '...</a></td>';
//        echo '<td>' . $row['created_at'] . '</td>';
//        echo '<td>' . $row['updated_at'] . '</td>';
//
//        echo '</tr>';
//    }
//
//    echo '</table>';
//
//    // Find out how many items are in the table
//    $total = connectBD()->query('
//        SELECT
//            COUNT(*)
//        FROM
//            news
//    ')->fetchColumn();
//
//    // How many items to list per page
//    $limit = 2;
//
//    // How many pages will there be
//    $pages = ceil($total / $limit);
//
//    if(isset($_GET['page'])){
//        $currentPage = $_GET['page'];
//    } else {
//        $currentPage = 1;
//    }
//
//    $prevPage = $currentPage - 1;
//    $nextPage = $currentPage + 1;
//
//    echo '<a href="index-old.php?page='.$prevPage.'">Prev</a>';
//    echo '<a href="index-old.php?page='.$nextPage.'">Next</a>';
//}
//
//function getCategoryName($id){
//    $sql = 'SELECT name FROM categories WHERE id = ' . $id . ' LIMIT 1';
//
//    return connectBD()->query($sql)->fetch()['name'];
//}
//
//function getItem($id){
////    $sql = 'SELECT * FROM news WHERE id = ' . $id . ' LIMIT 1';
//
//    $sql = 'SELECT
//        news.name AS title,
//        authors.name AS author,
//        categories.name AS category,
//        news.description,
//        news.created_at,
//        news.updated_at
//        FROM news
//        LEFT JOIN authors ON news.author_id = authors.id
//        LEFT JOIN categories ON news.category_id = categories.id
//        WHERE news.id = ' . $id . '
//        LIMIT 1
//    ';
//
//    return connectBD()->query($sql)->fetch();
//}
