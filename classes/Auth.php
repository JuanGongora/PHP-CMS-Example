<?php

/**
 * Class Auth checks log/logout
 */
class Auth {

   //not creating an object out of method so static
   public static function isLoggedIn() {
        return isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"];
    }
}