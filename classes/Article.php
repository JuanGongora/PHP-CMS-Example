<?php

/**
 * Class Article is a piece of writing for publication
 */
class Article {

    public $id;
    public $title;
    public $content;
    public $published_at;

    /**
     * @param $link
     * @return mixed
     *
     * this method doesn't act on individual articles, so it should be static
     */
    public static function getAll($link) {

        $sql = "SELECT * FROM article ORDER BY published_at";

        $result = $link->query($sql);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $link
     * @param $id
     * @param string $columns
     * @return mixed
     *
     * this method is not called on an instance of this class, so it should also be static
     */
    public static function getByID($link, $id, $columns = "*") {

        $sql = "SELECT $columns FROM article WHERE id = :id";

        $stmt = $link->prepare($sql);

        //the prepared statement
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        //if a record with the id is found, an object of the Article class will be returned this time
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Article");

        if ($stmt->execute()) {

            return $stmt->fetch();
        }
    }

}