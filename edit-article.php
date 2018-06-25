<?php

require "includes/database.php";
require "includes/article.php";

if (isset($_GET["id"])) {

    //the getDB() is inside because we are first using the conditional to check if we need it, thus only loading the db from the require when we need it
    $link = getDB();

    $article = getArticle($link, $_GET["id"]);

    if ($article) {
        $id = $article["id"];
        $title = $article["title"];
        $content = $article["content"];
        //extra content added below in order to resolve compatibility issue with other browsers
        $published_at = str_replace('T', ' ', $article['published_at']);
    } else {
        die("There's no article to edit with that id...");
    }
}
else {

    echo "This is bullshit, try again...";
//    $article = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $content = $_POST["content"];
    //extra content added below in order to resolve compatibility issue with other browsers
    $published_at = str_replace('T', ' ', $_POST['published_at']);

    $errors = validateArticle($title, $content, $published_at);

    //if array is empty of errors, or is non-existant
    if (empty($errors)) {

        $sql = "UPDATE article SET title = ?, content = ?, published_at = ? WHERE id = ?";

        // mysqli_escape_string($link, $_POST["content"])
        //the mysqli_escape_string can also be used to help prevent sql injections

        $result = mysqli_prepare($link, $sql);

        if ($result === FALSE) {

            echo mysqli_error($link);

        } else {

            if ($published_at == "") {
                $published_at == NULL;
            }

            mysqli_stmt_bind_param($result, "sssi", $title, $content, $published_at, $id);

            if (mysqli_stmt_execute($result)) {

                redirect("/article.php?id=$id");

            } else {
                echo mysqli_stmt_error($result);
            }
        }
    }
}
?>

<?php include "includes/header.php"; ?>

<h2>Edit Article</h2>

<?php include "includes/article-form.php"; ?>

<?php include "includes/footer.php"; ?>
