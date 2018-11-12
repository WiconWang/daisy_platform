<?php
/**
 * 557 ApiSystem.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/19 9:53 AM
 */

namespace App\Utilities;


class SqlDebug
{
    /**
     * 只回显SQL条目
     */
    public static function  s(){
        \DB::listen(function ($sql) {
            echo $sql->sql.PHP_EOL;
        });
    }
}