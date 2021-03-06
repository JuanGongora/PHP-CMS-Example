<?php

require "../includes/init.php";

Auth::requireLogin();

//you can assign variables to require files, making them quite dynamic
$link = require "../includes/db.php";

//coalescing operator puts conditional WITHIN the argument to see if it should set default pg 1 or requested pg num
$paginator = new Paginator($_GET["page"] ?? 1, 6, Article::getTotal($link));

$articles = Article::getPage($link, $paginator->limit, $paginator->offset);

?>

<?php include "../includes/header.php"; ?>

    <h2>Administration</h2>

    <a href="new-article.php">New article</a><br>

    <?php if (empty($articles)): ?>
        <p>There's nothing new here.</p>
    <?php else: ?>

    <table class="table">
        <thead>
            <th>Title</th>
            <th>Published</th>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><a href="article.php?id=<?= $article["id"]; ?>"><?= htmlspecialchars($article["title"]); ?></a></td>

                <?php if ($article["published_at"]) : ?>
                    <td><time><?= $article["published_at"]; ?></time></td>
                <?php else: ?>
                    <td><em>Unpublished</em> <button class="publish" data-id="<?= $article["id"] ?>">Publish</button></td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php require "../includes/pagination.php";?>

    <?php endif; ?>

<?php include "../includes/footer.php"; ?>

