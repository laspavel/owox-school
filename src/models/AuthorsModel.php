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

        return static::RedisLayer('SELECT id,name FROM `authors`');

    }

}



