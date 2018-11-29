<ul>
    <?php foreach ($articles as $article) { ?>
        <li><a href="/article/<?php echo $article['id']; ?>"><?php echo $article['name']; ?></a></li>
    <?php } ?>
</ul>

<ul class="pager">
    <?php if ($page != 1) { ?>
        <li><a onclick="LoadPage(<?php echo($page - 1); ?>)">Previous</a></li>
    <?php } ?>
    <?php if ($page != $max_page) { ?>
        <li><a onclick="LoadPage(<?php echo($page + 1); ?>)">Next</a></li>
    <?php } ?>
</ul>

<script type="text/javascript">
    function LoadPage(page) {
        $('#articles_list').remove;
        $('#articles_list').load('/articles/' + page);
    }
</script>






