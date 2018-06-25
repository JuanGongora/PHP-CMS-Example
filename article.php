<?php

include "includes/database.php";
include "includes/article.php";

if (isset($_GET["id"])) {

    //the getDB() is inside because we are first using the conditional to check if we need it, thus only loading the db from the require when we need it
    $link = getDB();

    $article = getArticle($link, $_GET["id"]);

    } else {

    echo "This is bullshit, try again...";
    $article = null;
}

?>

<?php include "includes/header.php"; ?>

<?php if ($article === null): ?>
    <p>There's nothing new here.</p>
<?php else: ?>
    <h2><?= htmlspecialchars($article["title"]); ?></h2>
    <p><?= htmlspecialchars($article["content"]); ?></p><br>
<?php endif; ?>

<a href="edit-article.php?id=<?= $article["id"] ?>">Edit Article</a><br>
<a href="delete-article.php?id=<?= $article["id"] ?>">Delete Article</a>

<?php include "includes/footer.php"; ?>
