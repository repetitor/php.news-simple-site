<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $params['title']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="main-header">
    <h1 class="visually-hidden"><?= $params['title']; ?></h1>
</header>
<div class="main-content">
    <main class="content"><?= $params['content']; ?></main>
</div>
<footer class="main-footer"> Дневник наблюдения за погодой. Все права защищены</footer>
</body>
</html>
