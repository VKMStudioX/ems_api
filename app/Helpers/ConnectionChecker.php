<?php

namespace App\Helpers;

use App\config\database;
use Illuminate\Support\Facades\Redis;

class ConnectionChecker
{

    public static function isRedisReady($connection = 'rconn')
    {
        $isReady = true;
        try {
            $redis = Redis::connection($connection);
            $redis->connect();
            $redis->disconnect();
        } catch (\Exception $e) {
            $isReady = false;
        }

        return $isReady;
    }
}
