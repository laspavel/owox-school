<?php

Class Articles
{

    const recordsOnPage = 30;

    private $db;
    private $data;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getArticlesList()
    {
        $this->render('articles_list');
    }

    public function getArticlesByCategory($limit)
    {

        $this->data['categories'] = $this->db->rawQuery('SELECT count(a.id) as count_articles, c.name FROM `articles` a LEFT JOIN `categories` c ON a.category_id=c.id GROUP BY c.name 
ORDER BY `count_articles`  DESC LIMIT ' . (int)$limit);
        $this->render('articles_by_category');
    }

    public function getArticlesByAuthors($limit)
    {

        $this->data['authors']=$this->db->rawQuery('SELECT count(a.id) as count_articles, au.name FROM `articles` a LEFT JOIN `authors` au ON a.author_id=au.id GROUP BY au.name ORDER BY au.name ASC LIMIT '.(int)$limit);
        $this->render('articles_by_author');
    }


    public function getArticlesByModified($limit)
    {

        $this->data['by_modifieds'] = $this->db->rawQuery('SELECT name FROM `articles`  
ORDER BY `articles`.`published` DESC LIMIT ' . (int)$limit);
        $this->render('articles_by_modified');
    }

    public function getArticlesTop($id,$limit)
    {

        $this->data['tops'] = $this->db->rawQuery('SELECT a.name as `name`,a.viewed as `viewed` FROM `articles` a LEFT JOIN `categories` c ON a.category_id=c.id WHERE a.category_id=(SELECT category_id FROM articles WHERE id='.(int)$id.')
ORDER BY `a`.`viewed`  DESC LIMIT ' . (int)$limit);
        $this->render('articles_top');
    }



    public function getArticleForm($id)
    {

        $this->data['article'] = $this->db->rawQueryOne('SELECT id,name,article_text,image,viewed FROM `articles`  
WHERE id=' . (int)$id);
        $this->data['max_id'] = $this->db->rawQueryOne('SELECT COUNT(id) FROM `articles` LIMIT 1');
        $this->db->rawQuery('UPDATE `articles` SET `viewed` = ' . ($this->data['article']['viewed'] + 1) . ' WHERE `articles`.`id` = ' . (int)$id);
        $this->render('articles_form');

    }

    public function getArticles($page)
    {

        $this->data['page'] = (int)$page;
        $this->data['max_page'] = $this->db->rawQuery('SELECT CEILING(COUNT(id)/' . Articles::recordsOnPage . ') FROM `articles` LIMIT 1');
        $this->data['articles'] = $this->db->rawQuery('SELECT `id`,`name` FROM `articles` WHERE id>' . ($this->data['page'] - 1) * Articles::recordsOnPage . ' AND id<' . $this->data['page'] * Articles::recordsOnPage);

        $this->render('articles_info');
    }


    protected function render($template = '')
    {

        if (file_exists(__DIR__ . '/templates/' . $template . '.php')) {

            if (!empty($this->data)) {
                extract($this->data);
            }
            ob_start();

            require(__DIR__ . '/templates/' . $template . '.php');

            $output = ob_get_contents();

            ob_end_clean();

            echo $output;
        } else {
            echo json_encode($this->data,
                JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        }
    }


}
