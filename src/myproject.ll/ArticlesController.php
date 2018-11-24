<?php

Class ArticlesController extends App
{
    private $articles;
    private $view;

    public function __construct()
    {
        $this->getArticlesModel();
        $this->view = new View();

    }

    private function getArticlesModel()
    {

        if ($this->articles === null) {

            return $this->articles = new ArticlesModel();

        }

        return $this->articles;
    }


    public function getArticlesList()
    {
        return $this->view->render('articles_list');
    }

    public function getArticlesByCategory()
    {
        return $this->view->render('articles_by_category', array(
            'categories' => $this->articles->getTopArticlesByCategory()
        ));
    }

    public function getArticlesByAuthors()
    {
        return $this->view->render('articles_by_author', array(
            'authors' => $this->articles->getTopArticlesByAuthor()
        ));
    }


    public function getArticlesByModified()
    {
        return $this->view->render('articles_by_modified', array(
            'by_modifieds' => $this->articles->getLastArticles()
        ));
    }

    public function getArticlesTop($id)
    {
        return $this->view->render('articles_top', array(
            'tops' => $this->articles->getTopArticlesInCategory($id)
        ));
    }


    public function getArticleForm($id)
    {
        return $this->view->render('articles_form', array(
            'article' => $this->articles->getArticle($id),
            'max_id' => $this->articles->getMaxIdArticles()
        ));
    }

    public function getArticles($page)
    {
        return $this->view->render('articles_info', array(
            'page' => (int)$page,
            'max_page' => $this->articles->getMaxPageArticles(),
            'articles' => $this->articles->getArticlesPargination($page)
        ));
    }
}
