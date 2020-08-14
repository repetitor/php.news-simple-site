<h1><?= $title ?? '' ?></h1>

<div class="brd">
<form method="post" action="<?= $uri_action ?>">
    <input type="hidden" name="<?= $action ?>">

    <div>Title: <input type="text" name="name" value="<?= $title ?? '' ?>"></div>

    <br><br>
    <div class="center">
        Author:
        <select name="author_id" class="center">
            <?php foreach ($authors as $option): ?>
                <?php $isbeforeSelected = ($option['id'] == $author_id) ? "selected" : '' ?>
                <option value="<?= $option['id'] ?>" <?= $isbeforeSelected ?>><?= $option['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>
    </div>

    <br><br>
    <div>
        Category:
        <select name="category_id">
            <?php foreach ($categories as $option): ?>
                <?php $isbeforeSelected = ($option['id'] == $category_id) ? "selected" : '' ?>
                <option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>
    </div>

    <br><br>
    <div>
        Описание:
        <br>
        <textarea name="description" cols="70" rows="10"><?= $description ?? '' ?></textarea>
    </div>

    <br>
    <input type="submit" value="Save">
</form>
</div>
