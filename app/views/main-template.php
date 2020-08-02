<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="center">HEADER</div>
<hr/>

<!--menu-->
<div>
    <a href="/">Все новости</a>

    <?php foreach ($categories as $category): ?>
        <?php $uri = '?category=' . $category['id']; ?>
        <a href="<?= $uri ?>"><?= $category['name'] ?></a>
    <?php endforeach; ?>
</div>

<div>
    <?= $content ?? '' ?>
</div>

<hr/>
<div class="center">FOOTER</div>
</body>
</html>
