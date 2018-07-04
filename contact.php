<?php

require "includes/init.php";

?>

<?php require "includes/header.php"; ?>

<h2>Contact</h2>

<form method="post">

    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" name="email" id="email" type="email" placeholder="Your email">
    </div>

    <div class="form-group">
        <label for="subject">Subject</label>
        <input class="form-control" name="subject" id="subject" placeholder="Your subject">
    </div>

    <div class="form-group">
        <label for="message">Message</label>
        <textarea class="form-control" name="message" id="message" placeholder="Your message"></textarea>
    </div>

    <button class="btn">Send</button>

</form>

<?php require "includes/footer.php"; ?>

