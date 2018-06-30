<?php

require "../includes/init.php";

Auth::requireLogin();

if (isset($_GET["id"])) {

    $link = require "../includes/db.php";

    $article = Article::getByID($link, $_GET["id"]);

    } else {

    echo "This is bullshit, try again...";
    $article = null;
}

?>

<?php include "../includes/header.php"; ?>

<?php if ($article): ?>
    <h2><?= htmlspecialchars($article->title); ?></h2>

    <?php if ($article->image_file): ?>
        <img src="/uploads/<?= $article->image_file ?>">
    <?php endif; ?>

    <p><?= htmlspecialchars($article->content); ?></p><br>
<?php else: ?>
    <p>There's nothing new here.</p>
<?php endif; ?>

<a href="edit-article.php?id=<?= $article->id ?>">Edit Article</a><br>
<a href="delete-article.php?id=<?= $article->id ?>">Delete Article</a><br>
<a href="edit-article-image.php?id=<?= $article->id ?>">Edit Image</a>

<?php include "../includes/footer.php"; ?>
