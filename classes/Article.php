<?php

/**
 * Class Article is a piece of writing for publication
 */
class Article {

    public $id;
    public $title;
    public $content;
    public $published_at;
    public $image_file;
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
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public static function getPage($link, $limit, $offset, $only_published = false) {

        //this only becomes true if we set its condition outside of the method default
        $condition = $only_published ? " WHERE published_at IS NOT NULL" : "";

        //the below has a sub query with an alias called "a", this query displays a listing of all articles
        //with an assigned category, including duplicates if an article has more than one selected category
        $sql = "SELECT a.*, category.name AS category_name
                FROM (SELECT * 
                FROM article
                $condition
                ORDER BY published_at 
                LIMIT :limit 
                OFFSET :offset) AS a
                LEFT JOIN  article_category
                ON a.id = article_category.article_id
                LEFT JOIN category
                ON article_category.category_id = category.id";

        $stmt = $link->prepare($sql);

        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

        $stmt->execute();

        //conglomeration of all articles into one mass array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];

        //this will keep track of existing ids, in order to not display a duplicate as a result of
        //more than one category to an article, during iteration in the foreach below
        $previous_id = null;

        foreach ($results as $row) {

            //set article id from each iterated article array of $results
            $article_id = $row["id"];

            //if the article exits already then it won't display a duplicate
            if ($article_id != $previous_id) {

                //creating a new key/pair as an empty array for the container of more than one category per article
                $row["category_names"] = [];

                //assign entire row as the value to the correct article id, that was previously fetched from $row itself
                $articles[$article_id] = $row;
            }

            //assigning to new array the category names (doing var_dump($articles[$article_id]); will show you one full article)
            $articles[$article_id]["category_names"][] = $row["category_name"];

            //to keep track of duplicates during iteration
            $previous_id = $article_id;
        }

        //the new array is cleaned and completed
        return $articles;
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
     * Get the article record based on the ID along with assoc. categories, if any
     *
     * @param $link the database
     * @param $id for article
     * @return mixed article data with categories
     */
    public static function getWithCategories($link, $id, $only_published = false) {

        $sql = "SELECT article.*, category.name AS category_name
                FROM article 
                LEFT JOIN article_category 
                ON article.id = article_category.article_id 
                LEFT JOIN category 
                ON article_category.category_id = category.id 
                WHERE article.id = :id";

        if ($only_published) {
            $sql .= " AND article.published_at IS NOT NULL";
        }

        $stmt = $link->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        //$stmt will most likely return an array of records so let's combine it into an assoc. array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * will be called on Article object to fetch its category, so not static
     *
     * @param $link
     * @return mixed category data
     */
    public function getCategories($link) {

        $sql = "SELECT category.*
                FROM category
                JOIN article_category
                ON category.id = article_category.category_id
                WHERE article_id = :id";

        $stmt = $link->prepare($sql);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * this is called on an instance of Article, which allows us to call its variable id
     *
     * @param $link to DB
     * @param $ids collection of selected/de-selected categories
     */
    public function setCategories($link, $ids) {

        if ($ids) {

            $sql = "INSERT IGNORE INTO article_category (article_id, category_id) VALUES ";

            $values = [];

            //dynamically generating values for a sql call
            foreach ($ids as $id) {
                $values[] = "({$this->id}, ?)";
            }

            $sql .= implode(", ", $values);

            //you only need to prepare the sql statement once, even though below there are multiple executions for the categories
            $stmt = $link->prepare($sql);

            foreach ($ids as $index => $id) {

                $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);

            }

            $stmt->execute();

        }

        $sql = "DELETE FROM article_category WHERE article_id = {$this->id}";

        if ($ids) {

            //generates the amount of placeholders needed to update the individual categories (either for deleting or inserting)
            $placeholders = array_fill(0, count($ids), "?");


            //lets the call delete any categories that have not been related in the latest update, as a measure
            //for removing a category which may have previously existed within the article, but the user no longer
            //wants to keep that relation at update time through unchecking #=> http://beginner-sql-tutorial.com/sql-not-in.html
            $sql .= " AND category_id NOT IN (" .implode(", ", $placeholders) . ")";

        }

        //you only need to prepare the sql statement once, even though below there are multiple bindings
        $stmt = $link->prepare($sql);

        foreach ($ids as $index => $id) {
            $stmt->bindValue($index + 1, $id, PDO::PARAM_INT);
        }

        $stmt->execute();
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

    /**
     * @param $link
     * @return bool
     */
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

    /**
     * Gets total count of articles
     *
     * @param $link connects to database
     *
     * @return integer of total records
     */
    public static function getTotal($link, $only_published = false) {

        //this only becomes true if we set its condition outside of the method default
        $condition = $only_published ? " WHERE published_at IS NOT NULL" : "";

        $sql = "SELECT COUNT(*) FROM article{$condition}";

        //query and fetchColumn are object methods from PDO, as $link becomes a child of PDO
        //fetchColumn allows me to grab the requested output from the resulting called column
        return $link->query($sql)->fetchColumn(0);

    }

    /**
     * @param $link
     * @param $filename
     * @return mixed
     *
     * this method is called on Article objects, hence it's not static, and can call it's variables
     */
    public function setImageFile($link, $filename) {

        $sql = "UPDATE article SET image_file = :image_file WHERE id = :id";

        $stmt = $link->prepare($sql);

        $stmt->bindValue(":image_file", $filename, $filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}