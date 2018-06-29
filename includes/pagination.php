<!-- The URI which was given in order to access this page; for instance, '/index.html?page=3' -->
<?php $base = strtok($_SERVER["REQUEST_URI"], "?"); ?>
<!-- the "?" is the delimiter in the url, as the query string is everything after it -->

<nav>
    <ul>
        <li>
            <!-- checks conditional true statement from Paginator -->
            <?php if ($paginator->previous): ?>
                <a href="<?= $base ?>?page=<?= $paginator->previous ?>">Previous</a>
            <?php else: ?>
                Previous
            <?php endif; ?>
        </li>
        <li>
            <!-- checks conditional true statement from Paginator -->
            <?php if ($paginator->next): ?>
                <a href="<?= $base ?>?page=<?= $paginator->next ?>">Next</a>
            <?php else: ?>
                Next
            <?php endif; ?>
        </li>
    </ul>
</nav>