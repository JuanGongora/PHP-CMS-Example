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
                throw new Exception("File is too large to upload");
                break;

            default:

                throw new Exception("An error occurred");
        }

        if ($_FILES["file"]["size"] > 1000000) {
            throw new Exception("File is too large");
        }

        //array of acceptable MIME types for the site
        $mime_types = ["image/gif", "image/png", "image/jpeg"];

        //create a new fileinfo resource and return the mime type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        //$finfo resource returned by finfo_open(), with the second parameter in
        //finfo_file() being the name of a file to be checked by the HTTP File Upload variables
        $mime_type = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
        //files uploaded are temporarily saved at: $_FILES["file"]["tmp_name"] of array

        //$mime_type returns a string, so checking if the type is in array
        //we replace the type in the $mime_types array, with that $mime_type value
        if (!in_array($mime_type, $mime_types)) {
            throw new Exception("Invalid file type");
        }

        //return info about file
        $pathinfo = pathinfo($_FILES["file"]["name"]);

        //function pathinfo() has 4 paths to know: dirname, basename, extension, filename
        $base = $pathinfo["filename"];

        //replaces any characters that shouldn't be allowed, with last argument $base being the file to apply the function into
        $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);

        //mb_substr gets part of string to check range of filename is within set limit
        $base = mb_substr($base, 0, 200);

        //rebuild sanitized filename to upload into DB
        $filename = $base . "." . $pathinfo["extension"];

        $destination = "../uploads/$filename";

        $i = 1;

        while (file_exists($destination)) {

            //rebuild sanitized filename to upload into DB, using incrementer in case a user uploads same name file
            $filename = $base . "-{$i}." . $pathinfo["extension"];
            $destination = "../uploads/$filename";

            $i++;
        }

        //https://stackoverflow.com/questions/37008227/what-is-the-difference-between-name-and-tmp-name/43566165#43566165
       if (move_uploaded_file($_FILES["file"]["tmp_name"], $destination)) {

            $previous_image = $article->image_file;

            if ($article->setImageFile($link, $filename)) {

                if ($previous_image) {

                    //deletes old image to be replaced by new one
                    unlink("../uploads/$previous_image");
                }

                Url::redirect("/admin/edit-article-image.php?id={$article->id}");
            }

       } else {

           throw new Exception("Unable to move uploaded file");
       }

    } catch (Exception $e) {
        //the catch outputs the errors for us after they were thrown above
        $error = $e->getMessage();
    }
}

?>

<?php include "../includes/header.php"; ?>

<h2>Edit Article Image</h2>

<?php if ($article->image_file): ?>
    <img src="/uploads/<?= $article->image_file ?>">
    <a class="delete" href="delete-article-image.php?id=<?= $article->id ?>">Delete</a>
<?php endif; ?>

<?php if (isset($error)): ?>
    <strong><?= $error ?></strong>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">

    <div>
        <label for="file">Image file</label>
        <input type="file" id="file" name="file">

        <input type="submit" value="Upload">
    </div>

</form>

<?php include "../includes/footer.php"; ?>