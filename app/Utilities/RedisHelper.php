<?php
/**
 * 557 Redis统一管理类
 * User: wangweiqiang
 * Date: 2018/4/8
 * Time: 下午4:07
 */

namespace App\Utilities;

use Illuminate\Support\Facades\Redis;
use Closure;


class RedisHelper
{

    /*
     * $redisKey = RedisHelper::keyBuilder('task', 'sendedcount',$clockId);
     * RedisHelper::remember($redisKey, rand(1,100) + 60 * 60 * 24 * 10, 'int', function () use ($clockId) {
     *    return Model::where('id',Id)->count();
     * });
     */

    /**
     * 生成缓存键名
     * 缓存名拼接规则 ： prefix:module:func:field:string:args
     * 参数名仅供参考，按业务情况自行安排各拼接项即可
     *
     * @param string $module 模块名 必需
     * @param string $func 模块方法
     * @param string $field 字段
     * @param string $string 附加名
     * @param string $args 附加参数
     * @return string
     */
    public static function keyBuilder(...$args)
    {
        if (empty($args)) return false;
        $keys = array(config('database.redis.default.prefix'));
        foreach ($args as $arg)
            array_push($keys, $arg);
        return implode(':', $keys);
    }

    public static function remove($key)
    {
        return Redis::del($key);
    }


    /**
     * 取得缓存内容，不存在则重新生成缓存并返回内容
     * 注意：请注意内容与字段类型要合理匹配
     *
     * @param string $key 键名
     * @param \DateTimeInterface|\DateInterval|float|int $seconds 过期时间秒数
     * @param string $dataType
     * @param Closure $callback 闭包数据方法 返回值需要是string、int、array
     * @return mixed
     */
    public static function remember($key, $seconds = 0, $dataType = 'string', Closure $callback)
    {
        // 当Redis出问题时，直接取出原始记录
        try {
            // 根据自己的类型，分流程
            if ($dataType == 'hash') {
                $value = Redis::hGetAll($key);
                if (!is_null($value) && !empty($value)) {
                    return $value;
                }
                $value = $callback();
                if (!$value) {
                    return null;
                }
                Redis::hMset($key, $value);

            } elseif ($dataType == 'set') {
                $value = Redis::sMembers($key);
                if (!is_null($value) && !empty($value)) {
                    return $value;
                }
                $value = $callback();
                if (!$value) {
                    return null;
                }
                Redis::sAdd($key, $value);

            } elseif ($dataType == 'zset') {
                $value = Redis::zRange($key, 0, -1);
                if (!is_null($value) && !empty($value)) {
                    return $value;
                }
                $value = $callback();
                if (!$value) {
                    return null;
                }
                // TODO ZADD有问题暂不处理
                // Redis::zAdd($key,1, $value = $callback());

            } elseif ($dataType == 'int') {
                $value = Redis::get($key);
                if (!is_null($value)) {
                    return $value;
                }
                $value = $callback();
                // 对于0值也进行存储
                if (!is_int($value)) {
                    return null;
                }
                Redis::set($key, $value);

            } else {
                $value = Redis::get($key);
                if ($value && !is_null($value)) {
                    $array = @unserialize($value);
                    if ($array === false && $value !== 'b:0;') {
                        return $value;
                    } else {
                        return $array;
                    }
                }


                $value = $callback();
                if (!$value) {
                    return null;
                }

                if (is_array($value)) {
                    Redis::set($key, serialize($value));
                } else {
                    Redis::set($key, $value);
                }

            }
            // 过期时间
            if ($seconds > 0) {
                Redis::expire($key, $seconds);
            }
            return $value;

        } catch (\Exception $e) {
            // TODO 需要继续处理, 如果Redis出现故障，直接把请求转交给MYSQL ，需要调用系统报警等接口
//            echo $e->getMessage();
            return $callback();
        }
    }

    public static function exists($key)
    {
        return Redis::exists($key);
    }

    public static function incr($key)
    {
        return Redis::incr($key);
    }


    /**
     * 左侧如队列
     * @param $key
     * @param $value
     * @return int
     */
    public static function lpush($key, $value)
    {
        return Redis::lPush($key, $value);
    }

    /**
     * 右侧如队列
     * @param $key
     * @param $value
     * @return int
     */
    public static function rpush($key, $value)
    {
        if (!self::getWrite()) return false;

        return Redis::rPush($key, $value);
    }


    /**
     * 左侧出队列
     * @param $key
     * @return
     */
    public static function lpop($key)
    {
        return Redis::lPop($key);
    }


    /**
     * 取指定key的所有hash
     * @param $key
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function hGetAll($key)
    {
        return Redis::hGetAll($key);
    }


    /**
     * 取指定字段Hash
     * @param $key
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function hGet($key, $field)
    {
        return Redis::hGet($key, $field);
    }

    /**
     * 设置Hash
     * @param $key
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function hSet($key, $field, $value)
    {
        return Redis::hSet($key, $field, $value);
    }

    /**
     * 删除Hash指定值
     * @param $key
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function hDel($key, $field)
    {
        return Redis::hDel($key, $field);
    }

    /**
     * 对指定键进行自增
     * @param $key
     * @param $field
     * @param $value
     * @return mixed
     */
    public static function hIncr($key, $field)
    {
        return Redis::hIncrBy($key, $field, 1);
    }

}
