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

        $dsn = "mysql:host=" .$db_host . ";dbname=" . $db_name . ";charset=utf8";

        try {
            $link = new PDO($dsn, $db_user, $db_pass);

            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $link;

        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

}