<?php

class ArticlesModel extends Model
{
    public $recordsOnPage = 30;
    public $recordsLimit = 10;
    private $db;

    public function __construct()
    {
        $this->db = static::getDB();
    }

    public function getTopArticlesByCategory()
    {
        return $this->db->rawQuery('SELECT count(a.id) as count_articles, c.name FROM `articles` a LEFT JOIN `categories` c ON a.category_id=c.id GROUP BY c.name 
ORDER BY `count_articles`  DESC LIMIT ' . (int)$this->recordsLimit);
    }

    public function getTopArticlesInCategory($id)
    {
        return $this->db->rawQuery('SELECT a.name as `name`,a.viewed as `viewed` FROM `articles` a LEFT JOIN `categories` c ON a.category_id=c.id WHERE a.category_id=(SELECT category_id FROM articles WHERE id=' . (int)$id . ')
ORDER BY `a`.`viewed`  DESC LIMIT ' . (int)$this->recordsLimit);
    }

    public function getTopArticlesByAuthor()
    {
        return $this->db->rawQuery('SELECT count(a.id) as count_articles, au.name FROM `articles` a LEFT JOIN `authors` au ON a.author_id=au.id GROUP BY au.name ORDER BY au.name ASC LIMIT ' . (int)$this->recordsLimit);

    }

    public function getLastArticles()
    {
        return $this->db->rawQuery('SELECT name,published FROM `articles` ORDER BY `articles`.`published` DESC LIMIT ' . (int)$this->recordsLimit);
    }

    public function getArticle($id)
    {
        return $this->db->rawQueryOne('SELECT id,name,article_text,category_id,image,viewed FROM `articles`  
WHERE id=' . (int)$id);
    }

    public function getMaxIdArticles()
    {
        return $this->db->rawQueryOne('SELECT COUNT(id) FROM `articles` LIMIT 1');
    }

    public function getMaxPageArticles()
    {
        return ($this->db->rawQueryOne('SELECT CEILING(COUNT(id)/' . $this->recordsOnPage . ') as maxpage FROM `articles` LIMIT 1'))['maxpage'];
    }

    public function getArticlesPargination($page)
    {
        $maxPage=($this->getMaxPageArticles());
        return $this->db->rawQuery('SELECT `id`,`name` FROM `articles` WHERE id>' . ($maxPage -1 - $page) * $this->recordsOnPage . ' AND id<' . ($maxPage - $page)* $this->recordsOnPage);
    }

    public function setArticleViewed($id) {

        $this->db->rawQueryOne("UPDATE `articles` SET `viewed`= (`viewed` + 1)  WHERE id=" . (int)$id);
    }

    public function insertArticle($data)
    {
        return $this->db->insert ('articles', $data);
    }

    public function updateArticle($id, $data)
    {
        $this->db->rawQueryOne("UPDATE `articles` SET `viewed`='0', `name`='" . $data['name'] . "', `image`='" . $data['image'] . "', `article_text`='" . $data['article_text'] . "' WHERE id=" . (int)$id);
    }

    public function deleteArticle($id)
    {
        $this->db->rawQueryOne('DELETE FROM `articles` WHERE id=' . (int)$id);
    }
}


