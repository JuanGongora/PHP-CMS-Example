<?php

class Category {

    /**
     * Get all the categories
     *
     * @param $link
     * @return mixed assoc array of all the category records
     */
    public static function getAll($link) {

        $sql = "SELECT * FROM category ORDER BY name";

        $result = $link->query($sql);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}