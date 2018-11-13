<?php
/**
 * 557 输出.
 * @author WiconWang <WiconWang@gmail.com>
 * @copyright  2018/10/19 1:46 PM
 */

namespace App\Utilities;


trait ResponseHelper
{

    /**
     * 转换列表为标准输出
     * @param int $total
     * @param array $data
     * @return array
     */
    protected function formatList($total = 0, $data = [])
    {
        return [
            'total' => $total,
            'list' => $data,
        ];
    }

    /**
     * 转换标准输出
     *
     * @param string $returnName
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function getStandardResult($returnName = 'ERROR', $msg = "", $data = [])
    {
        return [
            'code' => $this->returnCode($returnName),
            'message' => empty($msg) ? $this->returnInfo($returnName) : $msg,
            'data' => $data,
        ];
    }

    /**
     * 标准 JSON 输出
     *
     * @param $returnName
     * @param string $msg
     * @param array $data
     */
    public function responseJson($returnName, $msg = '', $data = [])
    {
        header('Content-type:text/json');
        echo response()->json(
            $this->getStandardResult($returnName, $msg, $data),
            200
        )->content();
        exit;
    }

    /**
     * 标准 JSONP 输出
     *
     * @param $returnName
     * @param string $msg
     * @param array $data
     * @param string $callback
     */
    public function responseJsonP($returnName, $msg = '', $data = [], $callback = 'callback')
    {
        header('Content-type:text/json');
        echo response()->jsonp(
            $callback,
            $this->getStandardResult($returnName, $msg, $data),
            200
        )->content();
        exit;
    }


    /**
     * 标准 JSON 输出
     *
     * @param $returnName
     * @param string $msg
     * @param array $data
     */
    public function responseDefaultJson($bool)
    {
        header('Content-type:text/json');
        $returnName = $bool?'SUCCESS':'ERROR';
        echo response()->json(
            $this->getStandardResult($returnName),
            200
        )->content();
        exit;
    }

}