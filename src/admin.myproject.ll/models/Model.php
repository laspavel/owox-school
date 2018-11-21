<?php

abstract class Model
{
    protected static function getDB()
    {
        static $db = null;
        if ($db === null) {
            $db = new MysqliDb ('myproject-ll-mysql', 'myproject', '2Ple86kcJZibGC5y', 'myproject');
        }
        return $db;
    }

}