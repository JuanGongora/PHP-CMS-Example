<?php

/**
 * @param $path
 */
function redirect($path)
{

//the below is the standard way of telling whether a server is using a type of secure connection
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "OFF") {
        $protocol = "https";
    } else {
        $protocol = "http";
    }

//this redirects to the article page, while passing in the custom id of that page
    header("location: $protocol://" . $_SERVER["HTTP_HOST"] . $path);
    exit;
}