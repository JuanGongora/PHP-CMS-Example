<?php

require "../includes/init.php";

Auth::requireLogin();

//you can assign variables to require files, making them quite dynamic
$link = require "../includes/db.php";

$articles = Article::getAll($link);

?>

<?php include "../includes/header.php"; ?>

    <h2>Administration</h2>

    <a href="new-article.php">New article</a><br>

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

