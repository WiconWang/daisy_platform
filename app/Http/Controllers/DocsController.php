<?php

namespace App\Http\Controllers;

use App\Utilities\ConfigHelper;
use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function __construct()
    {
        if (!ConfigHelper::isDebug()) {
            throw new Exception('Permission denied');
        }

    }


    /**
     * 文档相关
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function index($type = 'index')
    {

        if ($type != 'index') {
            return view('doc/docs', array('type' => $type));
        } else {
            return view('doc/index', array(
                'modules' => ConfigHelper::getAllowModule(),
                'returnCode' => $this->getReturnCode()
            ));
        }
    }

    public function getReturnCode()
    {
        $html = "<table border='1'> ";
        foreach (config('returncode') as $returnCode => $returnName) {
            if ($returnCode % 100 == 0) {
                $html .= "<tr><th colspan='3' style='color:#ff6300'>";
                if ($returnCode < 1000) $html .= "正常码 0";
                if ($returnCode >= 1000 && $returnCode < 1100) $html .= "HTTP返回码  10xx";
                if ($returnCode >= 1100 && $returnCode < 1200) $html .= "服务器类  11xx";
                if ($returnCode >= 1200 && $returnCode < 1300) $html .= "参数类  12xx";
                if ($returnCode >= 1300 && $returnCode < 1400) $html .= "表单类  13xx";
                if ($returnCode >= 1400 && $returnCode < 1500) $html .= "数据库记录类 14xx ";
                if ($returnCode >= 1500 && $returnCode < 2000) $html .= "其它类  15xx";
                if ($returnCode >= 2000 && $returnCode < 2100) $html .= "模块：用户类 20xx";
                if ($returnCode >= 2100 && $returnCode < 2200) $html .= "模块：订单类 21xx";
                if ($returnCode >= 2200 && $returnCode < 2300) $html .= "模块：互动类 22xx";
                $html .= "</th></tr>";
            }
            $html .= "<tr><td>$returnCode</td><td>$returnName</td><td>" . trans('returncode.' . $returnName) . "</td></tr>";
        }
        $html .= "</table>";
        return $html;
    }
}
