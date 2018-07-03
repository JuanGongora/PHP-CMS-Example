<?php

require "includes/init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $link = require "includes/db.php";

    if (User::authenticate($link, $_POST["username"], $_POST["password"])) {

        Auth::login();

        Url::redirect("/index.html");

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
