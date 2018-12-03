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

    protected static function RedisLayer($query)
    {
        $Key=hash('md5',$query);

        $rc=self::getRedisCache();
        $CachedData = $rc->getItem($Key);
        if (is_null($CachedData->get())) {

            $db=self::getDB();
            $result=$db->rawQuery($query);
            $CachedData->set($result)->expiresAfter(60);
            $rc->save($CachedData);
        } else {
            $result = $CachedData->get();
        }

        return $result;
    }

    protected static function RedisClear()
    {
        return self::getRedisCache()->clear();

    }




}