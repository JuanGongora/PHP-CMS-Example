<?php

require "../includes/init.php";

Auth::requireLogin();

if (isset($_GET["id"])) {

    $link = require "../includes/db.php";

    $article = Article::getByID($link, $_GET["id"]);

    if (!$article) {
        die("There's no article to edit with that id...");
    }
}
else {

    die("This is bullshit, try again...");
}

//given an array of assoc. arrays, this function will return an array of just the values from a chosen column
$category_ids = array_column($article->getCategories($link), "id");

$categories = Category::getAll($link);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $article->title = $_POST["title"];
    $article->content = $_POST["content"];
    //extra content added below in order to resolve compatibility issue with other browsers
    $article->published_at = str_replace('T', ' ', $_POST['published_at']);


        if ($article->update($link)) {

            Url::redirect("/admin/article.php?id={$article->id}");

        }
}

?>

<?php include "../includes/header.php"; ?>

<h2>Edit Article</h2>

<?php include "includes/article-form.php"; ?>

<?php include "../includes/footer.php"; ?>