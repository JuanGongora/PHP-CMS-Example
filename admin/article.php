<?php

require "../includes/init.php";

Auth::requireLogin();

if (isset($_GET["id"])) {

    $link = require "../includes/db.php";

    $article = Article::getWithCategories($link, $_GET["id"]);

} else {

    echo "This is bullshit, try again...";
    $article = null;
}

?>

<?php include "../includes/header.php"; ?>

<?php if ($article): ?>

    <!-- doing var_dump($article); will show that internal array is at index 0 -->
    <h2><?= htmlspecialchars($article[0]["title"]); ?></h2>

    <?php if ($article[0]["published_at"]) : ?>
        <td><time><?= $article[0]["published_at"]; ?></time></td>
    <?php else: ?>
        <td><em>Unpublished</em></td>
    <?php endif; ?>

    <?php if ($article[0]["category_name"]): ?>
        <p>Categories:
            <?php foreach ($article as $internal_arr) : ?>
                <strong><?= $internal_arr["category_name"] ?></strong>
            <?php endforeach; ?>
        </p>
    <?php endif; ?>

    <?php if ($article[0]["image_file"]): ?>
        <img src="/uploads/<?= $article[0]["image_file"] ?>">
    <?php endif; ?>

    <p><?= htmlspecialchars($article[0]["content"]); ?></p><br>

<?php else: ?>
    <p>There's nothing new here.</p>
<?php endif; ?>

<a href="edit-article.php?id=<?= $article[0]["id"] ?>">Edit Article</a><br>
<a class="delete" href="delete-article.php?id=<?= $article[0]["id"] ?>">Delete Article</a><br>
<a href="edit-article-image.php?id=<?= $article[0]["id"] ?>">Edit Image</a>

<?php include "../includes/footer.php"; ?>
