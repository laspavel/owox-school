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
<form method="POST">

    <a name="start"></a>

    <div class="container">

        <div class="page-header">
            <input class="form-control form-control-lg" type="text" placeholder="Article name" id="inputLarge"
                   name='name' value="<?php echo $article['name']; ?>">

        </div>

        <div class="row">
            <div class="col-sm-8 page-main">

                <div class="form-group">
                    <label>Category</label>
                    <select class="form-control" name="category_id">
                        <?php if (isset($categories)) { ?>
                            <?php foreach ($categories as $category) { ?>
                                <option <?php echo ($category['id'] == $article['category_id']) ? 'selected' : ''; ?>
                                        value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                            <?php } ?>
                        <?php } ?>

                    </select>
                </div>


                <div class="page-post">

                    <input class="form-control form-control-lg" type="text" placeholder="Image URL" id="inputLarge"
                           name='image' value="<?php echo $article['image']; ?>">

                    <br>
                    <textarea name='article_text' class="form-control" id="exampleTextarea"
                              rows="10"><?php echo $article['article_text']; ?></textarea>

                    <div class="form-group">
                        <label>Author</label>
                        <select class="form-control" name="category_id">
                            <?php if (isset($authors)) { ?>
                                <?php foreach ($authors as $author) { ?>
                                    <option <?php echo ($author['id'] == $article['author_id']) ? 'selected' : ''; ?>
                                            value="<?php echo $author['id']; ?>"><?php echo $author['name']; ?></option>
                                <?php } ?>
                            <?php } ?>

                        </select>
                    </div>


                </div>


            </div>

        </div><!-- /.page-main -->


    </div><!-- /.row -->


    </div><!-- /.container -->


    <div class="page-footer">
        <input class="btn btn-primary btn-lg" type="submit" value="Save">
        <a class="btn btn-warning btn-lg" href="/">Cancel</a>
        <p>
            <a href="#start">Back to top</a>
        </p>
    </div>
</form>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery.min.js"></script>
<script src="bootstrap.min.js"></script>
<script src="docs.min.js"></script>

</body>
</html>