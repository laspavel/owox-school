<ul>
    <?php foreach ($by_modifieds as $by_modified) { ?>
        <li><?php echo $by_modified['name']; ?>(<?php echo $by_modified['published']; ?>)</li>
    <?php } ?>
</ul>