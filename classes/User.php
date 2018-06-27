<?php

/**
 * Class User authenticates visitors for actions
 */
class User {

    public $id;
    public $username;
    public $password;


    /**
     * @param $link
     * @param $username
     * @param $password
     * @return bool true if credentials are correct, null otherwise
     *
     * method is static as we won't have instances of User
     */
    public static function authenticate($link, $username, $password) {

        $sql = "SELECT * FROM user WHERE username = :username";

        $stmt = $link->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);

        //fetch is converted to an object of this class
        $stmt->setFetchMode(PDO::FETCH_CLASS, "User");

        $stmt->execute();

        //fetch results into an object variable (not an array thanks to setFetchMode conversion) after execution
        if ($user = $stmt->fetch()) {
            //when true it will trigger login.php to accept authentication
            return $user->password == $password;
        }
    }
}