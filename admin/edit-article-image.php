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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        if (empty($_FILES)) {
            throw new Exception("Invalid upload");
        }

        //http://php.net/manual/en/features.file-upload.errors.php
        switch ($_FILES["file"]["error"]) {
            case UPLOAD_ERR_OK:
                break;

            case UPLOAD_ERR_NO_FILE:

                //uses default php class Exception for error handling
                throw new Exception("No file uploaded");
                break;

            case UPLOAD_ERR_INI_SIZE:
                throw new Exception("File is too large, please make sure it is 2Mb");
                break;

            default:

                throw new Exception("An error occurred");
        }
    } catch (Exception $e) {
        //the catch outputs the errors for us after they were thrown above
        echo $e->getMessage();
    }
}

?>

<?php include "../includes/header.php"; ?>

<h2>Edit Article Image</h2>

<form method="post" enctype="multipart/form-data">

    <div>
        <label for="file">Image file</label>
        <input type="file" id="file" name="file">

        <input type="submit" value="Upload">
    </div>

</form>

<?php include "../includes/footer.php"; ?>