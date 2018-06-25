<?php

require "includes/database.php";
require "includes/article.php";
require "includes/url.php";

if (isset($_GET["id"])) {

    //the getDB() is inside because we are first using the conditional to check if we need it, thus only loading the db from the require when we need it
    $link = getDB();

    $article = getArticle($link, $_GET["id"], "id");

    if ($article) {
        $id = $article["id"];
    } else {
        die("There's no article to edit with that id...");
    }
}
else {

    echo "This is bullshit, try again...";
//    $article = null;
}

//article can only be deleted by using the form post method, link to delete page won't actually remove it without post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "DELETE FROM article WHERE id = ?";

// mysqli_escape_string($link, $_POST["content"])
//the mysqli_escape_string can also be used to help prevent sql injections

    $result = mysqli_prepare($link, $sql);

    if ($result === FALSE) {

        echo mysqli_error($link);

    } else {

        mysqli_stmt_bind_param($result, "i", $id);

        if (mysqli_stmt_execute($result)) {

            redirect("/index.php");

        } else {
            echo mysqli_stmt_error($result);
        }
    }
}

?>

<?php include "includes/header.php"; ?>

<h2>Delete Article</h2>

<form method="post">
    <p>Are you sure?</p>
    <button>Delete Article</button>
    <a href="article.php?id=<?= $article["id"] ?>">Cancel</a>

</form>

<?php include "includes/footer.php"; ?>

