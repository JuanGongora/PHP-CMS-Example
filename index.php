<?php

require "includes/init.php";

//you can assign variables to require files, making them quite dynamic
$link = require "includes/db.php";

$articles = Article::getAll($link);

?>

<?php include "includes/header.php"; ?>

<?php if (Auth::isLoggedIn()): ?>

    <p>You are logged in. <a href="logout.php">Log out</a></p>
    <a href="new-article.php">New article</a><br>

<?php else: ?>

    <p>You are not logged in. <a href="login.php">Log in</a></p>

<?php endif; ?>

    <?php if (empty($articles)): ?>
        <p>There's nothing new here.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <h2><a href="article.php?id=<?= $article['id']; ?>"><?= $article["title"]; ?></a></h2>
            <p><?= $article["content"]; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

<?php include "includes/footer.php"; ?>

