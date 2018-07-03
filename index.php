<?php

require "includes/init.php";

//you can assign variables to require files, making them quite dynamic
$link = require "includes/db.php";

//coalescing operator puts conditional WITHIN the argument to see if it should set default pg 1 or requested pg num
$paginator = new Paginator($_GET["page"] ?? 1, 5, Article::getTotal($link, true));

$articles = Article::getPage($link, $paginator->limit, $paginator->offset, true);

?>

<?php include "includes/header.php"; ?>


    <?php if (empty($articles)): ?>
        <p>There's nothing new here.</p>
    <?php else: ?>

        <?php foreach ($articles as $article): ?>
            <h2><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article["title"]); ?></a></h2>

            <!-- machine readable datetime is in attribute -->
            <time datetime="<?php echo $article["published_at"]; ?>"><?php
                $datetime = new DateTime($article["published_at"]);
                echo $datetime->format("F j, Y");
                ?></time>

            <!-- using the new key assigned to article array to display all assoc. categories -->
            <?php if ($article["category_names"]): ?>
            <p>Categories:
                <?php foreach ($article["category_names"] as $category): ?>
                    <strong><?= $category ?></strong>
                <?php endforeach; ?>
            </p>
            <?php endif; ?>
            <p><?= $article["content"]; ?></p>
        <?php endforeach; ?>

    <?php require "includes/pagination.php"; ?>

    <?php endif; ?>

<?php include "includes/footer.php"; ?>

