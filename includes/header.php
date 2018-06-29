<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Site</title>
</head>
    <body>

        <nav>
            <ul>
                <li><a href="/">Home</a> </li>
                <?php if (Auth::isLoggedIn()): ?>

                    <li><a href="/admin/">Admin</a></li>
                    <li><a href="/logout.php">Log out</a></li>

                <?php else: ?>

                <li><a href="/login.php">Log in</a></li>

                <?php endif; ?>
            </ul>
        </nav>

        <article>