<?php
/**
 * 557 ApiSystem.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/23 4:17 PM
 */

namespace App\Utilities;


class PageHelper
{

    public static function  pageToSqlSkip($page,$pagesize = 20)
    {
        return [(($page-1)<0?0:$page-1)*$pagesize,$pagesize];
    }
}