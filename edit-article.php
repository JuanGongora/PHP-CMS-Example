<?php

require "includes/init.php";

if (isset($_GET["id"])) {

    $link = require "includes/db.php";

    $article = Article::getByID($link, $_GET["id"]);

    if (!$article) {
        die("There's no article to edit with that id...");
    }
}
else {

    die("This is bullshit, try again...");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $article->title = $_POST["title"];
    $article->content = $_POST["content"];
    //extra content added below in order to resolve compatibility issue with other browsers
    $article->published_at = str_replace('T', ' ', $_POST['published_at']);


        if ($article->update($link)) {

            Url::redirect("/article.php?id={$article->id}");

        }
}

?>

<?php include "includes/header.php"; ?>

<h2>Edit Article</h2>

<?php include "includes/article-form.php"; ?>

<?php include "includes/footer.php"; ?>