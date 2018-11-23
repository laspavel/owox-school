<?php

Class ArticlesController
{
    private $model;

    public function __construct()
    {
        $this->getArticlesModel();
    }


    private function getArticlesModel() {

        if ($this->model->articles===null) {

            require_once "models/ArticlesModel.php";
            $this->model->articles = new ArticlesModel();

        }

        return $this->model->articles;
    }


    public function getArticlesList()
    {
        $this->render('articles_list');
    }

    public function getArticlesByCategory()
    {
        $this->render('articles_by_category', array(
            'categories' => $this->model->articles->getTopArticlesByCategory()
        ));
    }

    public function getArticlesByAuthors()
    {
        $this->render('articles_by_author', array(
            'authors' => $this->model->articles->getTopArticlesByAuthor()
        ));
    }


    public function getArticlesByModified()
    {
        $this->render('articles_by_modified', array(
            'by_modifieds' => $this->model->articles->getLastArticles()
        ));
    }

    public function getArticlesTop($id)
    {
        $this->render('articles_top', array(
            'tops' => $this->model->articles->getTopArticlesInCategory($id)
        ));
    }


    public function getArticleForm($id)
    {
        $this->render('articles_form', array(
            'article' => $this->model->articles->getArticle($id),
            'max_id' => $this->model->articles->getMaxIdArticles()
        ));
    }

    public function getArticles($page)
    {
        $this->render('articles_info', array(
            'page' => (int)$page,
            'max_page' => $this->model->articles->getMaxPageArticles(),
            'articles' => $this->model->articles->getArticlesPargination($page)
        ));
    }


    protected function render($template = '', $data = array())
    {
        if (file_exists(__DIR__ . '/templates/' . $template . '.php')) {

            if (!empty($data)) {
                extract($data);
            }
            ob_start();

            require(__DIR__ . '/templates/' . $template . '.php');

            $output = ob_get_contents();

            ob_end_clean();

            echo $output;
        } else {
            die("Template $template not found");
        }
    }


}
