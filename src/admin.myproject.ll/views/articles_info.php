<table class="table table-striped table-hover table-bordered">
    <thead>
    <tr>
        <th>Articles</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($articles as $article) { ?>
        <tr>
            <td align="left"><a href="/articles/<?php echo $article['id']; ?>"><?php echo $article['name']; ?></a></td>
            <td><a class="btn btn-danger btn-sm" href="/articles/<?php echo $article['id']; ?>/delete">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

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
        $('#articles_list').load('/get_articles/' + page);
    }
</script>






