<?php

require "../includes/init.php";

Auth::requireLogin();

$link = require  "../includes/db.php";

$article = Article::getByID($link, $_POST["id"]);

$published_at = $article->publish($link);

?><time><?= $published_at; ?></time>