<?php

require "../includes/init.php";

Auth::requireLogin();

//you can assign variables to require files, making them quite dynamic
$link = require "../includes/db.php";

$articles = Article::getAll($link);

?>

<?php include "../includes/header.php"; ?>

<?php if (Auth::isLoggedIn()): ?>

    <p>You are logged in. <a href="logout.php">Log out</a></p>
    <a href="new-article.php">New article</a><br>

<?php else: ?>

    <p>You are not logged in. <a href="login.php">Log in</a></p>

<?php endif; ?>

    <h2>Administration</h2>

    <?php if (empty($articles)): ?>
        <p>There's nothing new here.</p>
    <?php else: ?>

    <table>
        <thead>
            <th>Title</th>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><a href="article.php?id=<?= $article['id']; ?>"><?= $article["title"]; ?></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

<?php include "../includes/footer.php"; ?>

