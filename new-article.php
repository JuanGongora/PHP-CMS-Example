<?php

require "classes/Database.php";
require "classes/Article.php";
require "includes/article.php";
require "includes/url.php";
require "includes/auth.php";

session_start();

//check to see that the user is allowed to make article
if (!isLoggedIn()) {
    die("unauthorized");
}

$article = new Article();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();
    $link = $db->getConn();

    $article->title = $_POST["title"];
    $article->content = $_POST["content"];
    //extra content added below in order to resolve compatibility issue with other browsers
    $article->published_at = str_replace('T', ' ', $_POST['published_at']);


    if ($article->create($link)) {

        redirect("/article.php?id={$article->id}");

    }

}

?>

<?php include "includes/header.php"; ?>

<h2>New Article</h2>

<?php include "includes/article-form.php"; ?>

<?php include "includes/footer.php"; ?>

