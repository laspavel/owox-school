<?php

Class AdmArticles
{
    private $model;

    public function __construct($db)
    {
        require_once "models/AdmArticlesModel.php";
        $this->model->articles = new AdmArticlesModel();

        require_once "models/AdmCategoriesModel.php";
        $this->model->categories = new AdmCategoriesModel();

        require_once "models/AdmAuthorsModel.php";
        $this->model->authors = new AdmAuthorsModel();

    }

    public function getAdmArticlesList()
    {
        $this->render('articles_list');
    }

    public function getAdmArticlesNew()
    {

        $this->render('articles_form', array(
            'categories' => $this->model->categories->getAllCategories(),
            'authors' => $this->model->authors->getAllAuthors(),
        ));

    }

    public function getAdmArticlesUpdate($id)
    {

        $post = $this->requestclean($_POST);

        if ((int)$id == 0) {
            $this->model->articles->insertArticle($post);
        } else {
            $this->model->articles->updateArticle($id, $post);
        }

        $this->render('articles_list', array(
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
        $this->render('articles_form', array(
            'article' => $this->model->articles->getArticle($id),
            'categories' => $this->model->categories->getAllCategories(),
            'authors' => $this->model->authors->getAllAuthors()
        ));

    }

    public function getAdmArticlesDelete($id)
    {
        $this->model->articles->deleteArticle($id);
        $this->render('articles_list', array(
            'success' => 'Deleted !'
        ));
    }

    public function getAdmArticles($page)
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
