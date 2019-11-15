<?php
/**
 * 557 ApiSystem.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/17 11:06 AM
 */

namespace App\Utilities;


class OutputHelper
{


    public static function lowPicQuality($url)
    {
        return $url . '?x-oss-process=image/resize,w_750/quality,Q_80/format,jpg';
    }
}
