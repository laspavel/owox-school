<?php

Class articles
{

    private $recordsOnPage = 30;
    private $db;
    private $template;
    private $data;
    private $output;

    public function __construct($db)
    {
        $this->db = $db;
    }

    function getArticlesList()
    {
        $this->template = 'articles_list';
        $this->render();
    }

    function getArticlesByCategory($limit)
    {

        $this->data['categories'] = $this->db->rawQuery('SELECT c.name, (SELECT count(id) FROM articles a WHERE a.category_id=c.id LIMIT 1) as count_articles FROM `categories` c 
ORDER BY `count_articles`  DESC LIMIT ' . (int)$limit);
        $this->template = 'articles_by_category';
        $this->render();
    }

    function getArticlesByAuthors($limit)
    {

//        $this->data['authors']=$this->db->rawQuery(' LIMIT '.(int)$limit);
        $this->template = 'articles_by_category';
        $this->render();
    }


    function getArticlesByModified($limit)
    {

        $this->data['by_modifieds'] = $this->db->rawQuery('SELECT name FROM `articles`  
ORDER BY `articles`.`published` DESC LIMIT ' . (int)$limit);
        $this->template = 'articles_by_modified';
        $this->render();
    }

    function getArticleForm($id)
    {

        $this->data['article'] = $this->db->rawQueryOne('SELECT id,name,article_text,image,viewed FROM `articles`  
WHERE id=' . (int)$id);
        $this->data['max_id'] = $this->db->rawQueryOne('SELECT COUNT(id) FROM `articles` LIMIT 1');
        $this->db->rawQuery('UPDATE `articles` SET `viewed` = ' . ($this->data['article']['viewed'] + 1) . ' WHERE `articles`.`id` = ' . (int)$id);
        $this->template = 'articles_form';
        $this->render();

    }

    function getArticles($page)
    {

        $this->data['page'] = (int)$page;
        $this->data['max_page'] = $this->db->rawQuery('SELECT CEILING(COUNT(id)/' . $this->recordsOnPage . ') FROM `articles` LIMIT 1');
        $this->data['articles'] = $this->db->rawQuery('SELECT `id`,`name` FROM `articles` WHERE id>' . ($this->data['page'] - 1) * $this->recordsOnPage . ' AND id<' . $this->data['page'] * $this->recordsOnPage);
        $this->template = 'articles_info';
        $this->render();
    }


    protected function render()
    {

        if (file_exists(__DIR__ . '/templates/' . $this->template . '.php')) {

            if (!empty($this->data)) {
                extract($this->data);
            }
            ob_start();

            require(__DIR__ . '/templates/' . $this->template . '.php');

            $this->output = ob_get_contents();

            ob_end_clean();

            echo $this->output;
        } else {
            echo json_encode($this->data,
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        }
    }


}
