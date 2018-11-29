<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/templ.css" rel="stylesheet">
<body>
<a name="start"></a>

<div class="container">
    <?php if (isset($success)) { ?>
        <div class="alert alert-dismissible alert-success">
            <?php echo $success; ?>
        </div>
    <?php } ?>

    <div class="page-header">
        <h1 class="page-title">Admin: articles list</h1>
    </div>

    <div class="row">
        <div class="col-sm-12 page-main">
            <p><a class="btn btn-info btn-lg" href="/articles">New</a></p>

            <div id="articles_list"></div>

        </div><!-- /.page-main -->

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
<script src="/jquery.min.js"></script>
<script src="/bootstrap.min.js"></script>
<script src="/docs.min.js"></script>

<script type="text/javascript">
    $('#articles_list').load('/get_articles/1');
</script>


</body>
</html>