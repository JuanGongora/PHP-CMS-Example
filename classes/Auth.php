<?php

/**
 * Class Auth checks log/logout
 */
class Auth {

   //not creating an object out of method so static
   public static function isLoggedIn() {
        return isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"];
    }

    public static function requireLogin() {
        if (! static::isLoggedIn()) {
            die("unauthorized");
        }
    }

    /**
     * Log in using the session
     *
     * @return void
     */
    public static function login() {

        //passing in the value of true below deletes the old session
        //and then creates a new one, while keeping current session information maintained
        //doing this helps to prevent session fixation attacks
        session_regenerate_id(true);

        $_SESSION["is_logged_in"] = true;

    }

    /*
     * Log out using the session
     *
     * @return void
     */
    public static function logout() {

        // Unset all of the session variables by making a blank array
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {

            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }
}