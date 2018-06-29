<?php

require "../includes/init.php";

//check to see that the user is allowed to make article
Auth::requireLogin();

$article = new Article();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $link = require "../includes/db.php";

    $article->title = $_POST["title"];
    $article->content = $_POST["content"];
    //extra content added below in order to resolve compatibility issue with other browsers
    $article->published_at = str_replace('T', ' ', $_POST['published_at']);


    if ($article->create($link)) {

        Url::redirect("/admin/article.php?id={$article->id}");

    }

}

?>

<?php include "../includes/header.php"; ?>

<h2>New Article</h2>

<?php include "includes/article-form.php"; ?>

<?php include "../includes/footer.php"; ?>

