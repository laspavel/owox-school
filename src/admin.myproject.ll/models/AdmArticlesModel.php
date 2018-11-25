<?php

class AdmArticlesModel extends Model
{
    public $recordsOnPage = 30;
    public $recordsLimit = 10;
    private $db;

    public function __construct()
    {
        $this->db = static::getDB();
    }

    public function insertArticle($data)
    {
        return $this->db->insert ('articles', $data);
        // db->rawQueryOne("INSERT INTO `articles` (name, image, article_text) VALUES ('" . $data['name'] . "', '" . $data['image'] . "', '" . $data['article_text'] . "')");
    }

    public function updateArticle($id, $data)
    {
        $this->db->rawQueryOne("UPDATE `articles` SET `viewed`='0', `name`='" . $data['name'] . "', `image`='" . $data['image'] . "', `article_text`='" . $data['article_text'] . "' WHERE id=" . (int)$id);
    }

    public function getArticle($id)
    {
        return $this->db->rawQueryOne('SELECT id,name,article_text,category_id,author_id,image FROM `articles`  
WHERE id=' . (int)$id);

    }

    public function deleteArticle($id)
    {
        $this->db->rawQueryOne('DELETE FROM `articles` WHERE id=' . (int)$id);
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


