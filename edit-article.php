<?php

require "classes/Database.php";
require "classes/Article.php";
require "includes/article.php";
require "includes/url.php";

if (isset($_GET["id"])) {

    $db = new Database();
    $link = $db->getConn();

    $article = Article::getByID($link, $_GET["id"]);

    if (!$article) {
        die("There's no article to edit with that id...");
    }
}
else {

    echo "This is bullshit, try again...";
//    $article = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $article->title = $_POST["title"];
    $article->content = $_POST["content"];
    //extra content added below in order to resolve compatibility issue with other browsers
    $article->published_at = str_replace('T', ' ', $_POST['published_at']);

    $errors = validateArticle($article->title, $article->content, $article->published_at);

    //if array is empty of errors, or is non-existant
    if (empty($errors)) {

        if ($article->update($link)) {

            redirect("/article.php?id={$article->id}");

        }
    }
}
?>

<?php include "includes/header.php"; ?>

<h2>Edit Article</h2>

<?php include "includes/article-form.php"; ?>

<?php include "includes/footer.php"; ?>