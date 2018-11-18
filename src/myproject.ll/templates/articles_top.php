<ul>
    <?php if (isset($tops)) { ?>
        <?php foreach ($tops as $top) { ?>
            <li><?php echo $top['name']; ?> (<?php echo $top['viewed']; ?>)</li>
        <?php } ?>
    <?php } ?>
</ul>