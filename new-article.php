<?php

require "includes/database.php";
require "includes/article.php";
require "includes/url.php";
require "includes/auth.php";

session_start();

//check to see that the user is allowed to make article
if (!isLoggedIn()) {
    die("unauthorized");
}

//by making a container for errors, we are able to report multiple errors instead of one
$title = "";
$content = "";
$published_at = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $content = $_POST["content"];
    //extra content added below in order to resolve compatibility issue with other browsers
    $published_at = str_replace('T', ' ', $_POST['published_at']);

    $errors = validateArticle($title, $content, $published_at);

    //if array is empty of errors
    if(empty($errors)) {


        //the getDB() is inside because we are first using the conditional to check if we need it,
        //loading the db from the require when used, also assigned to variable so the return of $link from database.php is the value here
        $link = getDB();

        $sql = "INSERT INTO article (title, content, published_at) VALUES (?, ?, ?)";

        // mysqli_escape_string($link, $_POST["content"])
        //the mysqli_escape_string can also be used to help prevent sql injections

        $result = mysqli_prepare($link, $sql);

        if ($result === FALSE) {

            echo mysqli_error($link);

        } else {

            if ($published_at == "") {
                $published_at == NULL;
            }

            mysqli_stmt_bind_param($result, "sss", $title, $content, $published_at);

            if (mysqli_stmt_execute($result)) {

                $id = mysqli_insert_id($link);

                redirect("/article.php?id=$id");

            } else {
                echo mysqli_stmt_error($result);
            }
        }
    }
}

?>

<?php include "includes/header.php"; ?>

<h2>New Article</h2>

<?php include "includes/article-form.php"; ?>

<?php include "includes/footer.php"; ?>

