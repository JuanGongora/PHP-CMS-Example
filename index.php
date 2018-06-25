<?php

include "includes/database.php";

$link = getDB();

$sql = "SELECT * FROM article ORDER BY published_at;";

$result = mysqli_query($link, $sql);

if ($result === FALSE) {
    echo mysqli_error($link);
} else {
    $articles = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>

<?php include "includes/header.php"; ?>

    <a href="new-article.php">New article</a>

    <?php if (empty($articles)): ?>
        <p>There's nothing new here.</p>
    <?php else: ?>
        <?php foreach ($articles as $article): ?>
            <h2><a href="article.php?id=<?= $article['id']; ?>"><?= $article["title"]; ?></a></h2>
            <p><?= $article["content"]; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

<?php include "includes/footer.php"; ?>

