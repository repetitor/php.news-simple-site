<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $title_tab ?></title>
    <link rel="stylesheet" href="<?= $link_css ?>">
</head>

<body class="gradient">
    <header>HEADER</header>

    <!--login or logout form-->
    <div>
        <?php if($is_admin): ?>
            <?php include 'views/auth/logout-form.php'; ?>
        <?php else: ?>
            <?php include 'views/auth/login-form.php'; ?>
        <?php endif; ?>
    </div>

    <!--menu-->
    <div>
        <a href="/">Все новости</a>

        <?php foreach ($categories as $category): ?>
            <?php $uri = '?category=' . $category['id']; ?>
            <a href="<?= $uri ?>"><?= $category['name'] ?></a>
        <?php endforeach; ?>
    </div>

    <!--content-->
    <div>
        <?= $content_rendered ?? '' ?>
    </div>

    <footer>FOOTER</footer>
</body>
</html>