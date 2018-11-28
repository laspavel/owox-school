<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

Class AdmArticlesController
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
            $id=$this->articles->insertArticle($post);
            $operation="insert";
        } else {
            $this->articles->updateArticle($id, $post);
            $operation='update';
        }

        $article=$this->articles->getArticle($id);

        $this->setMessageToSP(array(
            'id'=>$id,
            'category_id'=>$article['category_id'],
            'viewed'=>$article['viewed'],
            'operation'=>$operation
        ));

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

        $this->setMessageToSP(array(
            'id'=>$id,
            'operation'=>'delete'
        ));

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

    public function setMessageToSP($data) {

        $connection = new AMQPStreamConnection('rabbitmq1',  '5672',  'root',  'rootQ','rabbit');
        $channel = $connection->channel();

        $channel->exchange_declare('test_exchange', 'topic', false, true, false);
        $channel->queue_declare('test_queue', false, true, false, false);
        $channel->queue_bind('test_queue', 'test_exchange', '#');

        $json=json_encode(array(
            'id'=>(int)$data['id'],
            'category_id'=>(int)$data['category_id'],
            'viewed'=>(int)$data['viewed'],
            'operation'=>$data['operation']
        ));

        $message = new AMQPMessage($json, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $channel->basic_publish($message,
            'test_exchange',
            'test.hello'
        );

        $channel->close();
        $connection->close();

    }

}
