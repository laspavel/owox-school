<?php

class AuthorsModel extends Model
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

    public function getAllAuthors()
    {
        $CachedAuthors = $this->rc->getItem('AllAuthors');
        if (is_null($CachedAuthors->get())) {
            $allAuthors = $this->db->rawQuery('SELECT id,name FROM `authors`');
            $CachedAuthors->set($allAuthors)->expiresAfter(60);
            $this->rc->save($CachedAuthors);
        } else {
            $allAuthors = $CachedAuthors->get();

        }

        return $allAuthors;
    }

}



