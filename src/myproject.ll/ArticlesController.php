<?php

Class ArticlesController extends App
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->getArticlesModel();
        $this->view = new View();

    }

    private function getArticlesModel()
    {

        if ($this->model->articles === null) {

            return $this->model->articles = new ArticlesModel();

        }

        return $this->model->articles;
    }


    public function getArticlesList()
    {
        return $this->view->render('articles_list');
    }

    public function getArticlesByCategory()
    {
        return $this->view->render('articles_by_category', array(
            'categories' => $this->model->articles->getTopArticlesByCategory()
        ));
    }

    public function getArticlesByAuthors()
    {
        return $this->view->render('articles_by_author', array(
            'authors' => $this->model->articles->getTopArticlesByAuthor()
        ));
    }


    public function getArticlesByModified()
    {
        return $this->view->render('articles_by_modified', array(
            'by_modifieds' => $this->model->articles->getLastArticles()
        ));
    }

    public function getArticlesTop($id)
    {
        return $this->view->render('articles_top', array(
            'tops' => $this->model->articles->getTopArticlesInCategory($id)
        ));
    }


    public function getArticleForm($id)
    {
        return $this->view->render('articles_form', array(
            'article' => $this->model->articles->getArticle($id),
            'max_id' => $this->model->articles->getMaxIdArticles()
        ));
    }

    public function getArticles($page)
    {
        return $this->view->render('articles_info', array(
            'page' => (int)$page,
            'max_page' => $this->model->articles->getMaxPageArticles(),
            'articles' => $this->model->articles->getArticlesPargination($page)
        ));
    }


}
