<?php

include "classes/Database.php";
include "classes/Article.php";
include "includes/article.php";

if (isset($_GET["id"])) {

    $db = new Database();
    $link = $db->getConn();

    $article = Article::getByID($link, $_GET["id"]);

    } else {

    echo "This is bullshit, try again...";
    $article = null;
}

?>

<?php include "includes/header.php"; ?>

<?php if ($article): ?>
    <h2><?= htmlspecialchars($article->title); ?></h2>
    <p><?= htmlspecialchars($article->content); ?></p><br>
<?php else: ?>
    <p>There's nothing new here.</p>
<?php endif; ?>

<a href="edit-article.php?id=<?= $article->id ?>">Edit Article</a><br>
<a href="delete-article.php?id=<?= $article->id ?>">Delete Article</a>

<?php include "includes/footer.php"; ?>
