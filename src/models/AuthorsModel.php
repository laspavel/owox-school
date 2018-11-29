<?php

class AuthorsModel extends Model
{
    public $recordsOnPage = 30;
    public $recordsLimit = 10;
    private $db;

    public function __construct()
    {
        $this->db = static::getDB();
    }

    public function getAllAuthors()
    {
        return $this->db->rawQuery('SELECT id,name FROM `authors`');
    }

}


