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
        return $this->db->rawQuery('SELECT name FROM `articles` ORDER BY `articles`.`published` DESC LIMIT ' . (int)$this->recordsLimit);
    }

    public function getArticle($id)
    {
        return $this->db->rawQueryOne('SELECT id,name,article_text,image,viewed FROM `articles`  
WHERE id=' . (int)$id);
    }

    public function getMaxIdArticles()
    {
        return $this->db->rawQueryOne('SELECT COUNT(id) FROM `articles` LIMIT 1');
    }

    public function getMaxPageArticles()
    {
        return $this->db->rawQuery('SELECT CEILING(COUNT(id)/' . $this->recordsOnPage . ') FROM `articles` LIMIT 1');
    }

    public function getArticlesPargination($page)
    {
        return $this->db->rawQuery('SELECT `id`,`name` FROM `articles` WHERE id>' . ($page - 1) * $this->recordsOnPage . ' AND id<' . $page * $this->recordsOnPage);
    }

}

