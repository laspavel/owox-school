<ul>
    <?php if (isset($categories)) { ?>
        <?php foreach ($categories as $category) { ?>
            <li><?php echo $category['name']; ?> (<?php echo $category['count_articles']; ?>)</li>
        <?php } ?>
    <?php } ?>
</ul>