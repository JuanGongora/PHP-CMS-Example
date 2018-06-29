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

    <nav>
        <ul>
            <li>
                <!-- checks conditional true statement from Paginator -->
                <?php if ($paginator->previous): ?>
                    <a href="?page=<?= $paginator->previous ?>">Previous</a>
                <?php else: ?>
                    Previous
                <?php endif; ?>
            </li>
            <li>
                <!-- checks conditional true statement from Paginator -->
                <?php if ($paginator->next): ?>
                    <a href="?page=<?= $paginator->next ?>">Next</a>
                <?php else: ?>
                    Next
                <?php endif; ?>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

<?php include "includes/footer.php"; ?>

