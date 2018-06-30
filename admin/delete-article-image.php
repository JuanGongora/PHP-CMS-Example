<?php

require "../includes/init.php";

Auth::requireLogin();

if (isset($_GET["id"])) {

    $link = require "../includes/db.php";

    $article = Article::getByID($link, $_GET["id"]);

    if (!$article) {
        die("There's no article to edit with that id...");
    }
} else {

    die("This is bullshit, try again...");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $previous_image = $article->image_file;

    if ($article->setImageFile($link, null)) {

        if ($previous_image) {

            //deletes old image to be replaced by new one
            unlink("../uploads/$previous_image");
        }

        Url::redirect("/admin/edit-article-image.php?id={$article->id}");
    }
}

?>

<?php include "../includes/header.php"; ?>

    <h2>Delete Article Image</h2>

<?php if ($article->image_file): ?>
    <img src="/uploads/<?= $article->image_file ?>">
<?php endif; ?>

    <form method="post">

        <p>Are you sure?</p>
        <button>Delete Image</button>
        <a href="/admin/edit-article-image.php?id=<?= $article->id ?>">Cancel</a>

    </form>

<?php include "../includes/footer.php"; ?>