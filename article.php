<?php

require "includes/init.php";

if (isset($_GET["id"])) {

    $link = require "includes/db.php";

    $article = Article::getWithCategories($link, $_GET["id"], true);

    } else {

    echo "This is bullshit, try again...";
    $article = null;
}

?>

<?php include "includes/header.php"; ?>

<?php if ($article): ?>
    <!-- doing var_dump($article); will show that internal array is at index 0 -->
    <h2><?= htmlspecialchars($article[0]["title"]); ?></h2>

    <?php if ($article[0]["category_name"]): ?>
        <p>Categories:
            <?php foreach ($article as $internal_arr) : ?>
                <strong><?= $internal_arr["category_name"] ?></strong>
            <?php endforeach; ?>
        </p>
    <?php endif; ?>

    <?php if ($article[0]["image_file"]): ?>
        <img src="/uploads/<?= $article[0]["image_file"] ?>">
    <?php endif; ?>

    <p><?= htmlspecialchars($article[0]["content"]); ?></p><br>
<?php else: ?>
    <p>There's nothing new here.</p>
<?php endif; ?>

<?php include "includes/footer.php"; ?>
