<?php

require "includes/init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new Database();
    $link = $db->getConn();

    if (User::authenticate($link, $_POST["username"], $_POST["password"])) {

        //passing in the value of true below deletes the old session
        //and then creates a new one, while keeping current session information maintained
        //doing this helps to prevent session fixation attacks
        session_regenerate_id(true);

        $_SESSION["is_logged_in"] = true;

        Url::redirect("/index.php");

    } else {

        $error = "Login is incorrect";
    }
}

?>

<?php require "includes/header.php"; ?>

<?php if (!empty($error)): ?>
    <strong><?= $error ?></strong>
<?php endif ?>

<h2>Login</h2>

<form method="post">

    <div>
        <label for="username">Username</label>
        <input name="username" id="username">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <button>Log in</button>

</form>

<?php require "includes/footer.php"; ?>
