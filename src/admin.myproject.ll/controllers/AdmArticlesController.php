<?php

Class AdmArticlesController extends App
{
    private $articles;
    private $categories;
    private $authors;
    private $view;

    public function __construct()
    {
        $this->getArticlesModel();
        $this->getCategoriesModel();
        $this->getAuthorsModel();

        $this->view = new View();

    }

    private function getArticlesModel()
    {

        if ($this->articles === null) {

            return $this->articles = new AdmArticlesModel();

        }

        return $this->articles;
    }

    private function getAuthorsModel()
    {

        if ($this->authors === null) {

            return $this->authors = new AdmAuthorsModel();

        }

        return $this->authors;
    }

    private function getCategoriesModel()
    {

        if ($this->categories === null) {

            return $this->categories = new AdmCategoriesModel();

        }

        return $this->categories;
    }


    public function getAdmArticlesList()
    {
        return $this->view->render('articles_list');
    }

    public function getAdmArticlesNew()
    {

        return $this->view->render('articles_form', array(
            'categories' => $this->categories->getAllCategories(),
            'authors' => $this->authors->getAllAuthors(),
        ));

    }

    public function getAdmArticlesUpdate($id)
    {

        $post = $this->requestclean($_POST);

        if ((int)$id == 0) {
            $this->articles->insertArticle($post);
        } else {
            $this->articles->updateArticle($id, $post);
        }

        return $this->view->render('articles_list', array(
            'success' => 'Updated !'
        ));

    }

    private function requestclean($data)
    {

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
                $data[$this->requestclean($key)] = $this->requestclean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT);
        }
        return $data;
    }

    public function getAdmArticlesEdit($id)
    {

        return $this->view->render('articles_form', array(
            'article' => $this->articles->getArticle($id),
            'categories' => $this->categories->getAllCategories(),
            'authors' => $this->authors->getAllAuthors()
        ));

    }

    public function getAdmArticlesDelete($id)
    {
        $this->articles->deleteArticle($id);
        return $this->view->render('articles_list', array(
            'success' => 'Deleted !'
        ));
    }

    public function getAdmArticles($page)
    {
        return $this->view->render('articles_info', array(
            'page' => (int)$page,
            'max_page' => $this->articles->getMaxPageArticles(),
            'articles' => $this->articles->getArticlesPargination($page)
        ));
    }
}
