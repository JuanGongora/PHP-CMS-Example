<?php

require "includes/init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $link = require "includes/db.php";

    if (User::authenticate($link, $_POST["username"], $_POST["password"])) {

        Auth::login();

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

    <div class="form-group">
        <label for="username">Username</label>
        <input class="form-control" name="username" id="username">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" name="password" id="password">
    </div>

    <button class="btn">Log in</button>

</form>

<?php require "includes/footer.php"; ?>
