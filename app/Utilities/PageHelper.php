<?php
/**
 * 557 ApiSystem.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/23 4:17 PM
 */

namespace App\Utilities;


class PageHelper
{
    const PAGE_SIZE = 20;

    /**
     * 从提交数组中分离页码和页数
     * @param $data
     * @return array
     */
    public static function getSqlSkipInArray($data)
    {
        return self::pageToSqlSkip(
            (isset($data['page']) ? $data['page'] : 0),
            (isset($data['pagesize']) ? $data['pagesize'] : self::PAGE_SIZE)
        );
    }

    public static function  pageToSqlSkip($page,$pagesize = 20)
    {
        return [(($page-1)<0?0:$page-1)*$pagesize,$pagesize];
    }
}