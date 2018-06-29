<?php

require "includes/init.php";

//you can assign variables to require files, making them quite dynamic
$link = require "includes/db.php";

//coalescing operator puts conditional WITHIN the argument to see if it should set default pg 1 or requested pg num
$paginator = new Paginator($_GET["page"] ?? 1, 5, Article::getTotal($link));

$articles = Article::getPage($link, $paginator->limit, $paginator->offset);

?>

<?php include "includes/header.php"; ?>


    <?php if (empty($articles)): ?>
        <p>There's nothing new here.</p>
    <?php else: ?>

        <?php foreach ($articles as $article): ?>
            <h2><a href="article.php?id=<?= $article['id']; ?>"><?= $article["title"]; ?></a></h2>
            <p><?= $article["content"]; ?></p>
        <?php endforeach; ?>

    <?php require "includes/pagination.php"; ?>

    <?php endif; ?>

<?php include "includes/footer.php"; ?>

