<?php

/**
 * @param $link
 * @param $id
 * @param string $columns
 * @return array|null
 */
function getArticle($link, $id, $columns = "*") {

    $sql = "SELECT $columns FROM article WHERE id = :id";

    $stmt = $link->prepare($sql);

    //the prepared statement
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/**
 * @param $title
 * @param $content
 * @param $published_at
 * @return array
 */
function validateArticle($title, $content, $published_at) {

    $errors = [];

    if ($title == "") {
        $errors[] = "Title is required";
    }
    if ($content == "") {
        $errors[] = "Content is required";
    }
    if ($published_at != "") {

        $date_time = date_create_from_format("y--M-D H:i:s", $published_at);

        if ($date_time === FALSE) {
            $errors[] = "Invalid date and time";
        } else {
            $date_errors = date_get_last_errors();

            if ($date_errors["warning_count"] > 0) {
                $errors[] = "Invalid date and time";
            }
        }
    }

    return $errors;
}