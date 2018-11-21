<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blog Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/templates/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/templates/templ.css" rel="stylesheet">
<body>
<a name="start"></a>

<div class="container">


    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="/">Home</a></li>
        </ol>
        <h1 class="page-title"><?php echo $article['name']; ?></h1>
    </div>

    <div class="row">
        <div class="col-sm-8 page-main">

            <div class="page-post">
                <p class="page-post-meta">Просмотрено: <?php echo $article['viewed']; ?> раз.</p>
                <img src="<?php echo $article['image']; ?>"><br>
                <?php echo $article['article_text']; ?>

                <ul class="pager">
                    <?php if ($article['id'] != 1) { ?>
                        <li><a href="/article/<?php echo($article['id'] - 1); ?>">Previous</a></li>
                    <?php } ?>
                    <?php if ($article['id'] != $max_id) { ?>
                        <li><a href="/article/<?php echo($article['id'] + 1); ?>">Next</a></li>
                    <?php } ?>
                </ul>
            </div>

        </div><!-- /.page-main -->

        <div class="col-sm-3 col-sm-offset-1 page-sidebar">
            <div class="sidebar-module">
                <h4>Топ статей</h4>
                <div id="articles_top"></div>


            </div>

        </div><!-- /.page-sidebar -->

    </div><!-- /.row -->

</div><!-- /.container -->

<div class="page-footer">
    <p>
        <a href="#start">Back to top</a>
    </p>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/templates/jquery.min.js"></script>
<script src="/templates/bootstrap.min.js"></script>
<script src="/templates/docs.min.js"></script>

<script type="text/javascript">
    $('#articles_top').load('/articlestop/<?php echo $article['id'];?>');
</script>


</body>
</html>