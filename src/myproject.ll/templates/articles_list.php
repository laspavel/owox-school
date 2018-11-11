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
        <h1 class="page-title">Список статей</h1>
    </div>

    <div class="row">
        <div class="col-sm-8 page-main">
            <div id="articles_list"></div>

        </div><!-- /.page-main -->

        <div class="col-sm-3 col-sm-offset-1 page-sidebar">
            <div class="sidebar-module">
                <h4>Облако тэгов по темам</h4>
                <div id="articles_by_category"></div>
            </div>
            <div class="sidebar-module">
                <h4>Облако тэгов по авторам</h4>
                <div id="articles_by_authors"></div>
            </div>

            <div class="sidebar-module">
                <h4>Облако тэгов по датам публикации</h4>
                <div id="articles_by_modified"></div>
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
    $('#articles_list').load('/articles/1');
    $('#articles_by_category').load('/articlesbycategory/10');
    $('#articles_by_authors').load('/articlesbyauthors/10');
    $('#articles_by_modified').load('/articlesbymodified/10');
</script>


</body>
</html>