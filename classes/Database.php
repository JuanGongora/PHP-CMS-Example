<?php

/**
 * Class Database connects to DB
 */
class Database {

    /**
     * @return PDO
     */
    public function getConn() {
        $db_host = "localhost:3307";
        $db_name = "cms";
        $db_user = "cms_www";
        $db_pass = "pass";
//        $db_port = "3307";

        $dsn = "mysql:host=" .$db_host . ";dbname=" . $db_name . ";charset=utf8";

        return $conn = new PDO($dsn, $db_user, $db_pass);
    }

}