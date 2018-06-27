<?php

/**
 * Class Article is a piece of writing for publication
 */
class Article {

    public $id;
    public $title;
    public $content;
    public $published_at;
    public $errors;

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

        //if a record with the id is found, an object of the Article class will be returned this time, allowing you to use its public variables
        $stmt->setFetchMode(PDO::FETCH_CLASS, "Article");

        if ($stmt->execute()) {

            return $stmt->fetch();
        }
    }

    /**
     * @param $link
     * @return mixed
     */
    public function update($link) {

        if ($this->validate()) {


            $sql = "UPDATE article SET title = :title, content = :content, published_at = :published_at WHERE id = :id";

            $stmt = $link->prepare($sql);

            $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            $stmt->bindValue(":title", $this->title, PDO::PARAM_STR);
            $stmt->bindValue(":content", $this->content, PDO::PARAM_STR);

            if ($this->published_at == "") {
                $stmt->bindValue(":published_at", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":published_at", $this->published_at, PDO::PARAM_STR);

            }
            return $stmt->execute();
        } else {
            return false;
        }
    }

    /**
     * @return bool error
     *
     * we aren't going to call this method outside of the class so it should be protected, scope will be to class and its children
     */
    protected function validate() {

        if ($this->title == "") {
            $this->errors[] = "Title is required";
        }
        if ($this->content == "") {
            $this->errors[] = "Content is required";
        }
        if ($this->published_at != "") {

            $date_time = date_create_from_format("y--M-D H:i:s", $this->published_at);

            if ($date_time === FALSE) {
                $this->errors[] = "Invalid date and time";
            } else {
                $date_errors = date_get_last_errors();

                if ($date_errors["warning_count"] > 0) {
                    $this->errors[] = "Invalid date and time";
                }
            }
        }

        //we want this to return a true statement, if not then it returns the errors (false)
        return empty($this->errors);
    }

    /**
     * @param $link
     * @return mixed
     */
    public function delete($link) {

        $sql = "DELETE FROM article WHERE id = :id";

        $stmt = $link->prepare($sql);

        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    public function create($link) {

        if ($this->validate()) {


            $sql = "INSERT INTO article (title, content, published_at) VALUES (:title, :content, :published_at)";

            $stmt = $link->prepare($sql);

            $stmt->bindValue(":title", $this->title, PDO::PARAM_STR);
            $stmt->bindValue(":content", $this->content, PDO::PARAM_STR);

            if ($this->published_at == "") {
                $stmt->bindValue(":published_at", null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(":published_at", $this->published_at, PDO::PARAM_STR);

            }

            //if statement is true, we can assign this instance the id that SQL auto-generated on the DB for it
            if ($stmt->execute()) {
                //returns the id of the last inserted row or sequence value (PDO method)
                $this->id = $link->lastInsertID();
                return true;
            }
        } else {
            return false;
        }
    }

}