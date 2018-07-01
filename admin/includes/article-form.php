<?php if(! empty($article->errors)): ?>
    <?php foreach ($article->errors as $error): ?>
        <ul>
            <ol><strong><?= $error ?></strong></ol>
        </ul>
    <?php endforeach; ?>
<?php endif; ?>

<form method="post">

    <div>
        <label for="title">Title</label>
        <input name="title" id="title" placeholder="Article Title" value="<?= htmlspecialchars($article->title) ?>">
        <!-- the htmlspecialchars() function converts any risky characters into php versioned outputs that clean it, to reduce chance of XSS(cross site scripting)-->
    </div>

    <div>
        <label for="content">Content</label>
        <textarea name="content" rows="4" cols="40" id="content" placeholder="Article Content"><?= htmlspecialchars($article->content) ?></textarea>
    </div>

    <div>
        <label for="published_at">Publication Date and Time</label>
        <!-- extra content added below in order to resolve compatibility issue with other browsers -->
        <input type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars(str_replace(' ', 'T', $article->published_at)); ?>">
    </div>

    <fieldset>
        <legend>Categories</legend>

        <?php foreach ($categories as $category): ?>
            <div>
                <input type="checkbox" name="category[]" value="<?= $category["id"] ?> id="category-<?= $category["id"] ?>"
                <?php if (in_array($category["id"], $category_ids)) : ?>checked<?php endif; ?> >

                <label for="category-<?= $category["id"] ?>" ><?= htmlspecialchars($category["name"]) ?></label>
            </div>
        <?php endforeach; ?>

    </fieldset>

    <input type="submit" value="Add">
</form>