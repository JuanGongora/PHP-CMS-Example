<?php

require "includes/init.php";

//you can assign variables to require files, making them quite dynamic
$link = require "includes/db.php";

$articles = Article::getAll($link);

?>

<?php include "includes/header.php"; ?>


    <?php if (empty($articles)): ?>
        <p>There's nothing new here.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <h2><a href="article.php?id=<?= $article['id']; ?>"><?= $article["title"]; ?></a></h2>
            <p><?= $article["content"]; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

<?php include "includes/footer.php"; ?>

