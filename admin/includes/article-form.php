<?php if(! empty($article->errors)): ?>
    <?php foreach ($article->errors as $error): ?>
        <ul>
            <ol><strong><?= $error ?></strong></ol>
        </ul>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post" id="formArticle">

    <div class="form-group">
        <label for="title">Title</label>
        <input class="form-control" name="title" id="title" placeholder="Article Title" value="<?= htmlspecialchars($article->title) ?>">
        <!-- the htmlspecialchars() function converts any risky characters into php versioned outputs that clean it, to reduce chance of XSS(cross site scripting)-->
    </div>

    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" name="content" rows="4" cols="40" id="content" placeholder="Article Content"><?= htmlspecialchars($article->content) ?></textarea>
    </div>

    <div class="form-group">
        <label for="published_at">Publication Date and Time</label>
        <!-- extra content added below in order to resolve compatibility issue with other browsers -->
        <input class="form-control" type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars(str_replace(' ', 'T', $article->published_at)); ?>"> Format: 2018-01-01 00:00:00
    </div>

    <fieldset>
        <legend>Categories</legend>

        <?php foreach ($categories as $category): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="category[]" value="<?= $category["id"] ?>" id="category-<?= $category["id"] ?>"
                <?php if (in_array($category["id"], $category_ids)) : ?>checked<?php endif; ?> >

                <label class="form-check-label" for="category-<?= $category["id"] ?>" ><?= htmlspecialchars($category["name"]) ?></label>
            </div>
        <?php endforeach; ?>

    </fieldset>

    <input class="btn" type="submit" value="Add">
</form>