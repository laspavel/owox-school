<?php

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
            $db = new MysqliDb (DB['host'], DB['username'], DB['password'], DB['dbname']);
        }
        return $db;
    }

}