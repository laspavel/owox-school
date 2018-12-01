<?php

class CategoriesModel extends Model
{
    public $recordsOnPage = 30;
    public $recordsLimit = 10;
    private $db;
    private $rc;

    public function __construct()
    {
        $this->db = static::getDB();
        $this->rc = static::getRedisCache();
    }

    public function getAllCategories()
    {
        $CachedCategories = $this->rc->getItem('AllCategories');
        if (is_null($CachedCategories->get())) {
            $allCategories = $this->db->rawQuery('SELECT id,name FROM `categories`');
            $CachedCategories->set($allCategories)->expiresAfter(60);
            $this->rc->save($CachedCategories);
        } else {
            $allCategories = $CachedCategories->get();
        }

        return $allCategories;
    }
}


