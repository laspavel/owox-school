<ul>
    <?php if (isset($authors)) { ?>
        <?php foreach ($authors as $author) { ?>
            <li><?php echo $author['name']; ?> (<?php echo $author['count_articles']; ?>)</li>
        <?php } ?>
    <?php } ?>
</ul>