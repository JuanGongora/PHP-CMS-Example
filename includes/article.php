<?php

/**
 * @param $link
 * @param $id
 * @return array|null
 */
function getArticle($link, $id) {

    $sql = "SELECT * FROM article WHERE id = ?";

    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {

        echo mysqli_error($link);
    } else {

        //the prepared statement
        mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {

                $results = mysqli_stmt_get_result($stmt);

                return mysqli_fetch_array($results, MYSQLI_ASSOC);
            }
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