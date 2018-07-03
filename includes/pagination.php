<!-- The URI which was given in order to access this page; for instance, '/index.html?page=3' -->
<?php $base = strtok($_SERVER["REQUEST_URI"], "?"); ?>
<!-- the "?" is the delimiter in the url, as the query string is everything after it -->

<nav>
    <ul class="pagination">
        <li class="page-item">
            <!-- checks conditional true statement from Paginator -->
            <?php if ($paginator->previous): ?>
                <a class="page-link" href="<?= $base ?>?page=<?= $paginator->previous ?>">Previous</a>
            <?php else: ?>
                <span class="page-link">Previous</span>
            <?php endif; ?>
        </li>
        <li class="page-item">
            <!-- checks conditional true statement from Paginator -->
            <?php if ($paginator->next): ?>
                <a class="page-link" href="<?= $base ?>?page=<?= $paginator->next ?>">Next</a>
            <?php else: ?>
                <span class="page-link">Next</span>
            <?php endif; ?>
        </li>
    </ul>
</nav>