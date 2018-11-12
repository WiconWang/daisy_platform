<?php
/**
 * 557 ApiSystem.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/17 11:06 AM
 */

namespace App\Utilities;


class ConfigHelper
{

    public static function isProduction()
    {
        return config('app.env') == 'production';
    }


    public static function isDebug()
    {
        return config('app.debug') == true;
    }

    public static function getAllowModule()
    {
        if (!empty($module = config('app.allow_module'))){
            return explode(',',$module);
        }
        return [];
    }
}