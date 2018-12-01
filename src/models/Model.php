<?php

use Phpfastcache\CacheManager;
use Phpfastcache\Drivers\Redis\Config;

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

    protected static function getRedisCache()
    {
        static $rc = null;
        if ($rc === null) {
            $rc = CacheManager::getInstance('redis', new Config([
                'host' => REDIS['host'],
                'port' => REDIS['port']
            ]));
        }
        return $rc;
    }


}