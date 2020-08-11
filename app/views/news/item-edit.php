<h1><?= $title ?? '' ?></h1>

<form method="post" action="<?= $uri ?>">
    <input type="hidden" name="action" value="<?= $action ?>">

    <div>Title: <input type="text" name="name" value="<?= $title ?? '' ?>"></div>

    <div>
        Author:
        <select name="author_id">
            <?php foreach ($authors as $option): ?>
                <?php $isbeforeSelected = ($option['id'] == $author_id) ? "selected" : '' ?>
                <option value="<?= $option['id'] ?>" <?= $isbeforeSelected ?>><?= $option['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        Category:
        <select name="category_id">
            <?php foreach ($categories as $option): ?>
                <?php $isbeforeSelected = ($option['id'] == $category_id) ? "selected" : '' ?>
                <option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        Описание: <textarea name="description"><?= $description ?? '' ?></textarea>
    </div>

    <input type="submit" value="Save">
</form>
