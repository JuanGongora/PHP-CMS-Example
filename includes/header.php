<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
          crossorigin="anonymous">
    <!-- set after Boostrap to override any of its settings -->
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <title>Blog Site</title>
</head>
    <body>

        <div class="container">

        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="/">Home</a> </li>
                <?php if (Auth::isLoggedIn()): ?>

                    <li class="nav-item"><a class="nav-link" href="/admin/">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout.php">Log out</a></li>

                <?php else: ?>

                <li class="nav-item"><a class="nav-link" href="/login.php">Log in</a></li>

                <?php endif; ?>
            </ul>
        </nav>

        <article>