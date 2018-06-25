<?php

/**
 *
 * GET the database connection
 *
 * @return mysqli
 *
 *
 */
function getDB() {

    $db_host = "localhost";
    $db_name = "cms";
    $db_user = "cms_www";
    $db_pass = "pass";
    $db_port = "3307";

    $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name, $db_port);

    if (mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    }

    echo "Connected succesfully.";
    return $link;
    //this is returned so the variable exists in the scope that includes it
}

?>