<?php

require "includes/init.php";

if (isset($_GET["id"])) {

    $link = require "includes/db.php";

    $article = Article::getByID($link, $_GET["id"]);

    } else {

    echo "This is bullshit, try again...";
    $article = null;
}

?>

<?php include "includes/header.php"; ?>

<?php if ($article): ?>
    <h2><?= htmlspecialchars($article->title); ?></h2>

    <?php if ($article->image_file): ?>
        <img src="/uploads/<?= $article->image_file ?>">
    <?php endif; ?>

    <p><?= htmlspecialchars($article->content); ?></p><br>
<?php else: ?>
    <p>There's nothing new here.</p>
<?php endif; ?>

<?php include "includes/footer.php"; ?>
