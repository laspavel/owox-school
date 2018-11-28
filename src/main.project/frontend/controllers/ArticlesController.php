<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

Class ArticlesController
{
    private $articles;
    private $view;

    public function __construct()
    {
        $this->getArticlesModel();
        $this->view = new View('frontend');

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
        $this->articles->setArticleViewed($id);
        $article=$this->articles->getArticle($id);

        $connection = new AMQPStreamConnection('rabbitmq1',  '5672',  'root',  'rootQ','rabbit');
        $channel = $connection->channel();

        $channel->exchange_declare('test_exchange', 'topic', false, true, false);
        $channel->queue_declare('test_queue', false, true, false, false);
        $channel->queue_bind('test_queue', 'test_exchange', '#');

        $json=json_encode(array(
            'id'=>$id,
            'category_id'=>$article['category_id'],
            'viewed'=>$article['viewed'],
            'operation'=>'update'
        ));

        $message = new AMQPMessage($json, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $channel->basic_publish($message,
            'test_exchange',
            'test.hello'
        );

        $channel->close();
        $connection->close();

        return $this->view->render('articles_form', array(
            'article' => $article,
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
