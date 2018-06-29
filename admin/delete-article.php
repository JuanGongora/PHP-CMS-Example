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

//article can only be deleted by using the form post method, going to delete link page won't actually remove it without post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($article->delete($link)) {

            Url::redirect("/admin/index.php");

        }
    }

?>

<?php include "../includes/header.php"; ?>

<h2>Delete Article</h2>

<form method="post">
    <p>Are you sure?</p>
    <button>Delete Article</button>
    <a href="../article.php?id=<?= $article->id ?>">Cancel</a>

</form>

<?php include "../includes/footer.php"; ?>

