<?php
/**
 * 557 返回码.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/21 下午6:14
 */

namespace App\Utilities;


trait ReturnCodeHelper
{

    // 用返回名，查返回码
    public function returnCode($returnName)
    {
        $returnCodes = array_flip(config('returncode'));
        if (isset($returnCodes[$returnName])) {
            return $returnCodes[$returnName];
        } else {
            return $returnCodes['ERROR'];
        }
    }

    // 用返回名，查返回语句
    public function returnInfo($returnName)
    {
        return trans('returncode.' . $returnName);
    }

    // 用返回码，查返回语句
    public function returnInfoByCode($returnCode)
    {
        $returnName = config('returncode.' . $returnCode);
        return $this->returnInfo($returnName);
    }


    /**
     * 把Laravel返回码转换成自定义码
     *
     * @param $statusCode
     * @return array
     */
    public function transStatusCodeToReturnCode($statusCode)
    {
        $returnName = '';
        switch ($statusCode)
        {
            case 401: $returnName = 'TOKEN_LOST'; break;
            case 403: $returnName = 'FORBIDDEN'; break;
            case 404: $returnName = 'NOT_FOUND'; break;
            case 405: $returnName = 'METHOD_NOT_ALLOWED'; break;
            case 408: $returnName = 'REQUEST_TIMEOUT'; break;
            case 500: $returnName = 'SERVER_ERROR'; break;
            case 501: $returnName = 'SERVER_ERROR'; break;
            case 502: $returnName = 'SERVER_ERROR'; break;
            case 503: $returnName = 'SERVER_BUSY'; break;
            default:
                $returnName = 'ERROR';
        }
        return [$returnName, $this->returnInfo($returnName)];
    }
}